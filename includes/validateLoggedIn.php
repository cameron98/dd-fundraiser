<?php

if (isset($_SESSION['sessionID'])) {
    $cookie = $_SESSION['sessionID'];
} else {
    header("Location: /login.php");
    die();
}

$statement = $conn->prepare("SELECT * FROM sessions WHERE cookie=? AND session_start > ( NOW() - INTERVAL 3 DAY ) ");
$statement->bind_param("s", $cookie);
$statement->execute();
$result = $statement->get_result();

if ($result->num_rows != 1) {
    $_SESSION = array();
    header("Location: /login.php");
    die();
}