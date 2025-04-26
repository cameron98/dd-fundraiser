<?php

if (isset($_SESSION['sessionID'])) {
    $cookie = $_SESSION['sessionID'];
} else {
    header("Location: /login.php");
    die();
}

$sql = "SELECT * FROM sessions WHERE cookie='$cookie' AND session_start > ( NOW() - INTERVAL 3 DAY ) ";
$result = $conn->query($sql);

if ($result->num_rows != 1) {
    $_SESSION = array();
    header("Location: /login.php");
    die();
}