<?php

if ($_SERVER['REQUEST_METHOD'] != "POST" || !isset($_POST['email'])) {
    header("Location: /login.php");
}

require("../../functions/db.php");
require("../../functions/utils.php");
require("../../functions/aws.php");

// Check user exists in DB
$email = sql_sanitise($_POST['email']);
$sql = "SELECT * FROM users WHERE email='" . trim($email) ."'";
$user_result = $conn->query($sql);

if ($user_result->num_rows > 0) {
    // Get user ID
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['user_id'];

    // Limit login attempts
    $sql = "SELECT COUNT(*) AS login_count FROM sessions WHERE user_id=$user_id AND created > ( NOW() - INTERVAL 5 MINUTE )";
    $login_count_result = $conn->query($sql);
    if (!$login_count_result) {
        echo "Failed to query database";
        echo $conn->error;
        die("Failed to Failed to query database. Exiting...");
    }
    $row = $login_count_result->fetch_assoc();
    $login_count = $row['login_count'];

    if ($login_count > 5) {
        header("Location: /limitExceeded.php");
        die("Rate limit exceeded");
    }


    // Create session key and add it to the DB
    $uniqueKey = genRand();
    $sql = "INSERT INTO sessions (user_id, session_secret) VALUES (". $user_id . ", '" . $uniqueKey . "')";
    if ($conn->query($sql) != TRUE) {
        echo "Failed to create new session in database";
        echo $conn->error;
        die("Failed to create new session in database. Exiting...");
    }

    // Send email with magic login link
    $email_result = sendEmail($user_row['email'], "Demons - Login Link", "Welcome demon! Your login link is https://dev.cfstuff.org/api/validateLogin.php?key=" . $uniqueKey, $aws_key, $aws_secret, $from_email);
    if ($email_result != TRUE) {
        echo "Failed to send login email. Exiting.";
        die("Failed to send email. Exiting.");
    }

    header("Location: /emailSent.php");
} else {
    header("Location: /invalidLogin.php");
}


