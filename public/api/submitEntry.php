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

$date = $_POST['date'];
$miles = $_POST['miles'];
$exercise_type = $_POST['exercise-type'];

if (floatval($miles) > 100) {
    header("Location: /submitEntry.php?invalidData=1");
    die();
}

$user_id = getUserID($conn, $_SESSION['sessionID']);
if ($user_id == FALSE) {
    echo "Something went wrong...";
    die("User ID could not be retreived.");
}

$statement = $conn->prepare("INSERT INTO entries (user_id, exercise_date, qty_miles, exercise_type) VALUES (?, ?, ?, ?)");
$statement->bind_param("isis", $user_id, $date, $miles, $exercise_type);
$statement->execute();

header("Location: /submitEntry.php?success=1");
die();