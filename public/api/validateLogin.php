<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] != "GET") {
    header("Location: /");
    die();
}

if (!isset($_GET['key'])) {
    header("Location: /");
    die();
}

require("../../functions/db.php");
require("../../functions/utils.php");

$statement = $conn->prepare("SELECT * FROM sessions WHERE session_secret=? AND session_start IS NULL");
$statement->bind_param("s", $_GET['key']);
$statement->execute();
$session_result = $statement->get_result();

if ($session_result == FALSE) {
    die("Could not query session database. Exiting...");
} else {
    if ($session_result->num_rows <= 0) {
        echo "Session key invalid";
        header("Location: /invalidLogin.php");
        die();
    }
}

$session_cookie = genRand();
$_SESSION['sessionID'] = $session_cookie;

$statement = $conn->prepare("UPDATE sessions SET cookie=?, session_start = NOW() WHERE session_secret=? AND session_start IS NULL");
$statement->bind_param("ss", $session_cookie, $_GET['key']);
$statement->execute();


header("Location: /submitEntry.php");