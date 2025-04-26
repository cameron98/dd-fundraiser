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

$sql = "SELECT * FROM sessions WHERE session_secret='" . $_GET['key'] . "' AND session_start IS NULL";
echo $sql;

$session_result = $conn->query($sql);
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

$sql = "UPDATE sessions SET cookie='" . $session_cookie . "', session_start = NOW() WHERE session_secret='" . $_GET['key'] . "' AND session_start IS NULL";
if ($conn->query($sql) == FALSE) {
    echo "Could not update database";
    echo $conn->error;
    die($conn->error);
}

header("Location: /submitEntry.php");