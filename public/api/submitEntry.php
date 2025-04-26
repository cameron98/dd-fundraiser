<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /");
    die();
}

require("../../functions/db.php");
require("../../includes/validateLoggedIn.php");
require("../../functions/utils.php");


if (!isset($_POST['date']) || !isset($_POST['miles']) || !isset($_POST['exercise-type'])) {
    header("Location: /");
    die();
} else if ($_POST['date'] == '' || $_POST['miles'] == '' || $_POST['exercise-type'] == '') {
    header("Location: /submitEntry.php?invalidData=1");
    die();
}

$date = sql_sanitise($_POST['date']);
$miles = sql_sanitise($_POST['miles']);
$exercise_type = sql_sanitise($_POST['exercise-type']);

if (floatval($miles) > 25) {
    header("Location: /submitEntry.php?invalidData=1");
    die();
}

$user_id = getUserID($conn, $_SESSION['sessionID']);
if ($user_id == FALSE) {
    echo "Something went wrong...";
    die("User ID could not be retreived.");
}

$sql = "INSERT INTO entries (user_id, exercise_date, qty_miles, exercise_type) VALUES ($user_id, '$date', $miles, '$exercise_type')";
echo $sql;
if ($conn->query($sql) === TRUE) {
    header("Location: /submitEntry.php?success=1");
    die();
} else {
    echo $conn->error;
}