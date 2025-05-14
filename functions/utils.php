<?php

function genRand() {
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
}

function getUserID($conn, $cookie) {

    $cookie = sql_sanitise($cookie);
    $sql = "SELECT user_id FROM sessions WHERE cookie='$cookie'";
    $result = $conn->query($sql);
    if ($result != FALSE) {
        $row = $result->fetch_assoc();
        return $row['user_id'];
    } else {
        echo $result->error;
        return false;
    }
}

function getLoginStatus($conn) {
    if (isset($_SESSION['sessionID'])) {
        $cookie = $_SESSION['sessionID'];
    } else {
        return FALSE;
    }
    
    $sql = "SELECT * FROM sessions WHERE cookie='$cookie' AND session_start > ( NOW() - INTERVAL 3 DAY ) ";
    $result = $conn->query($sql);
    
    if ($result->num_rows != 1) {
        $_SESSION = array();
        return FALSE;
    } else {
        return TRUE;
    }
}

function getTotalMiles($conn) {
    $sql = "SELECT SUM(entries.qty_miles) AS miles FROM entries";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['miles'];
    }
    else {
        return 0;
    }
}

function sql_sanitise($input) {
    $input = str_replace(";", "", $input);
    $input = str_replace("%", "", $input);
    $input = str_replace("DROP", "", $input);
    $input = str_replace("SELECT", "", $input);
    $input = str_replace("=", "", $input);
    $input = str_replace(">", "", $input);
    $input = str_replace("<", "", $input);

    return $input;
}