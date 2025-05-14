<?php 
session_start();

require("../functions/db.php");
require("../functions/utils.php");

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


<section id="progress-block">
    <progress max="1024" value="<?php echo $totalMiles; ?>"></progress>
    <p id="progress-bar-caption"><?php echo $totalMiles; ?> miles down, <?php echo 1024 - $totalMiles; ?> to go!</p>
    <p class="article-text">
    Dorset is 1,024 square miles in area and we, as a team, are going to walk, run, push or cycle 
    that distance throughout June! We would love for you to sponsor us to help keep the club going. Or, even better,
    join the club! New members are always welcome and we have a lot of miles left to cover!
    </p>
    
    <a href="<?php echo $config['donations_url'] ?>"><div class="primary-btn">Sponsor Us!</div></a>

    <section class="who-are-we-sec">
        
        
        <div id="who-are-we-div">
            <img alt="dorset demons logo" id="club-logo" src="/assets/demons-logo.png" />
            <div>
                <h2>Who are we?</h2>
                <p class="article-text">
                    We are a wheelchair basketball club based at Ashdown Leisure Center in Poole. Some of us play in the 
                    <a href="https://britishwheelchairbasketball.co.uk/">British Wheelchair Basketball</a> Inspire League 
                    and some of us just turn up for some exercise and a laugh! We welcome anyone, with or without a disability.
                </p>
            </div>
        </div>    
    </section>
</section>

<div id="center-img-ctn">
    <img src="/assets/background_640.png" alt="wheelchair-basketball-image" id="center-image" />
</div>

<section id="center-block">
    <div id="club-info">
        <h2 class="center-text">Get in touch!</h2>
        <div id="link-box">
            <a href="https://facebook.com/DorsetDemons">
                <div class="contact-link">
                    <img src="/assets/facebook.svg" alt="facebook-logo" />
                </div>
            </a>
            <a href="https://www.youtube.com/@DorsetDemonsWBC">
                <div class="contact-link">
                    <img src="/assets/youtube.svg" alt="youtube-logo" />
                </div>
            </a>
            <a href="https://www.instagram.com/dorsetdemonswbc">
                <div class="contact-link">
                    <img src="/assets/instagram.svg" alt="instagram-logo" />
                </div>
            </a>
            <a href="https://www.tiktok.com/@dorsetdemonswbc">
                <div class="contact-link">
                    <img src="/assets/tiktok.svg" alt="tiktok-logo" />
                </div>
            </a>
        </div>
    </div>
    <div></div>
    <div id="leaderboard-ctn">
        <h2 class="center-text">Leaderboard</h2>
        <ol id="leaderboard-list">
        <?php
        $sql = "SELECT DISTINCTROW users.name, (SELECT SUM(entries.qty_miles) FROM entries WHERE users.user_id=entries.user_id) AS miles FROM users, entries WHERE (SELECT SUM(entries.qty_miles) FROM entries WHERE users.user_id=entries.user_id) > 0 ORDER BY miles DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $i = 0;
            while ($i < 3 && $i < $result->num_rows && $row = $result->fetch_assoc()) {
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
                }
                echo "<li><div class='leaderboard-div'><img class='leaderboard-logo' src='$logo_url' alt='medal' /><span><p><strong>$name</strong> ($miles miles)</p></span></div></li>";
                $i++;
            }
        } else {
            die($conn->error);
        }

        ?>
        </ol>
        <?php 
        if ($loggedIn === TRUE) {
            echo "<a href='/submitEntry.php'><div class='primary-btn'>New Entry</div></a>";
        } else {
            echo "<a href='/login.php'><div class='primary-btn'>Team Login</div></a>";
        }
        ?>
    </div>
</section>

<footer></footer>

</body>
</html>