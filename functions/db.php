<?php

$config = require($_SERVER['DOCUMENT_ROOT'] . "/../config.php");

$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
?>