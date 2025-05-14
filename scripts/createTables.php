<?php

$config = require("../config.php");
$conn = new mysqli($config['db_host'], $config['db_user'], $config['db_password'], $config['db_name']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "CREATE TABLE users (
user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(64),
email VARCHAR(255) UNIQUE
)";

if ($conn->query($sql) == TRUE) {
    echo "Created users table successfully!\n";
} else {
    echo "Unable to create users table\n";
    echo $conn->error;
}

$sql = "CREATE TABLE entries (
    entry_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    exercise_date DATE,
    qty_miles INT UNSIGNED,
    exercise_type VARCHAR(64),
    entry_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_id
        FOREIGN KEY (user_id) REFERENCES users (user_id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )";
    
if ($conn->query($sql) == TRUE) {
    echo "Created entries table successfully!\n";
} else {
    echo "Unable to create entries table\n";
    echo $conn->error;
}

$sql = "CREATE TABLE sessions (
    session_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    session_start DATETIME,
    session_secret VARCHAR(512),
    cookie VARCHAR(512),
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_id_sessions
        FOREIGN KEY (user_id) REFERENCES users (user_id)
        ON DELETE CASCADE
        ON UPDATE RESTRICT
    )";
    
if ($conn->query($sql) == TRUE) {
    echo "Created sessions table successfully!\n";
} else {
    echo "Unable to create sessions table\n";
    echo $conn->error;
}


$conn->close();