<?php 
session_start();

require("../functions/db.php");
require("../functions/utils.php");

$loggedIn = getLoginStatus($conn);

if ($loggedIn === TRUE) {
    header("Location: /submitEntry.php");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/base.css">
    <link rel="stylesheet" href="/styles/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <title>Demons Login</title>
    <link rel="icon" type="image/x-icon" href="/assets/basketball.ico">
</head>
<body>

<?php include("../includes/header.php") ?>


<article>
    <form method="POST" action="/api/requestLogin.php">
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email"/>
        </div>

        <button type="submit">Login</button>
    </form>
</article>
    
</body>
</html>