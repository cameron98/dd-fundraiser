<?php 
session_start();

require("../functions/db.php");
require("../functions/utils.php");
require("../includes/validateLoggedIn.php");


$config = require($_SERVER['DOCUMENT_ROOT'] . "/../config.php");

$loggedIn = getLoginStatus($conn);
$totalMiles = getTotalMiles($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Dorset Demons Fundraising Event June 2024 Homepage" />
    <link rel="stylesheet" href="/styles/base.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <title>Dorset Demons Fundraiser</title>
    <link rel="icon" type="image/x-icon" href="/assets/basketball.ico">
</head>
<body>

<?php include("../includes/header.php") ?>


    <div id="leaderboard-ctn" style="width: 50%; margin-left: auto; margin-right: auto;">
        <h2 class="center-text">Leaderboard</h2>
        <ol id="leaderboard-list">
        <?php
        $sql = "SELECT DISTINCTROW users.name, (SELECT SUM(entries.qty_miles) FROM entries WHERE users.user_id=entries.user_id) AS miles FROM users, entries WHERE (SELECT SUM(entries.qty_miles) FROM entries WHERE users.user_id=entries.user_id) > 0 ORDER BY miles DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $i = 0;
            while ($i < $result->num_rows && $row = $result->fetch_assoc()) {
                $name = $row['name'];
                $miles = $row['miles'];
                switch ($i) {
                    case 0:
                        $logo_url = "/assets/gold-medal.svg";
                        break;
                    case 1:
                        $logo_url = "/assets/silver-medal.svg";
                        break;
                    case 2:
                        $logo_url = "/assets/bronze-medal.svg";
                        break;
                    default:
                        $logo_url = '';
                }

                if ($logo_url == '') {
                    echo "<li><div class='leaderboard-div'><span><p><strong>$name</strong> ($miles miles)</p></span></div></li>";
                } else {
                    echo "<li><div class='leaderboard-div'><img class='leaderboard-logo' src='$logo_url' alt='medal' /><span><p><strong>$name</strong> ($miles miles)</p></span></div></li>";
                }
                $i++;
            }
        }
        
        ?>
        </ol>
        <a href='/'><div class='primary-btn'>Home</div></a>
    </div>



<footer></footer>

</body>
</html>