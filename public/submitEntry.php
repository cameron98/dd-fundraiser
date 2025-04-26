<?php
session_start();

require("../functions/utils.php");
require("../functions/db.php");
require("../includes/validateLoggedIn.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/styles/base.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/assets/basketball.ico">
    <title>Dorset Demons - Submit Entry</title>
</head>
<body>
<?php include("../includes/header.php") ?>

<?php
if (isset($_GET['success'])) {
    include("../includes/submissionSuccessful.php");
}

if (isset($_GET['invalidData'])) {
    include("../includes/invalidData.php");
}
?>

<article class="center-article">
    <h2 class="center-text">Exercise Log Entry</h2>

    <form method="post" action="/api/submitEntry.php">

        <div>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" class="align-right" min="2025-06-01" max="2025-06-30"/>
        </div>

        <div>    
            <label for="miles">Miles:</label>
            <input type="number" id="miles" name="miles" class="align-right" />
        </div>

        
        <label>Type</label>
        <div class="radio-form">
            <div>
                    <input type="radio" name="exercise-type" value="running" id="running">
                    <label for="running">Running</label>
            </div>
            
            <div>
                <input type="radio" name="exercise-type" value="running" id="walking">
                <label for="walking">Walking</label>
            </div>
            
            <div>
                <input type="radio" name="exercise-type" value="pushing" id="pushing">
                <label for="pushing">Pushing</label>
            </div>
        
        <div>
            <input type="radio" name="exercise-type" value="cycling" id="cycling">
            <label for="cycling">Cycling</label>
        </div>
        
        <div>
            <input type="radio" name="exercise-type" value="other" id="other">
            <label for="other">Other</label>
        </div>
    </div>
        
        <button type="submit" class="form-submit-btn">Submit</button>
    </form>
</article>

</body>
</html>