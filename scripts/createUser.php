<?php

$config = require("../config.php");
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "\n--- Create a new user ---\n\n";
echo "Enter Name:";
$handle = fopen("php://stdin", "r");
$name = trim(fgets($handle));

echo "Enter email address:";
$email = trim(fgets($handle));

echo "Creating user: ". $name . " Email: " . $email;

$sql = "INSERT INTO users (name, email) VALUES ('" . $name . "', '" . $email . "')";
if ($conn->query($sql) == TRUE) {
    echo "\nUser added successfully!\n";
} else {
    echo "Failed to add user";
    echo $conn->error;
}

echo "\n\n --- Exiting ---\n\n";
