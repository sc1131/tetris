<?php
$servername = "localhost";
$username = "root";
$password ="root";
$dbname = "Tetris";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if(isset($_POST['score'])&&isset($_COOKIE['userid']))
{
    $userid=$_COOKIE['userid'];
    $score=$_POST['score'];

    $sql = "INSERT INTO Scores (score,userid) VALUES (" .  $score . ",". $userid. ");";

    if ($conn->query($sql) === TRUE) {
        echo "Game Saved";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


}




?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <script src="implementor.js"></script>
    <link rel="stylesheet" href="generalstyling.css"></link>
    <style>
        h2{
            text-align:center;
        }
        h3{
            text-align: center;
        }
        #start_button{
            display: block;
            margin: 0 auto;
        }

        #board{
            box-shadow: 5px 5px;
            background-color: grey;
            width: 500px;
            margin:auto;

        }

    </style>
    <title>Tetris</title>
</head>



<body>
<div class="topnav">

    <a href="index.php">Home</a>

    <div class="right-topnav">

    <a href="tetris.php">Play Tetris</a>
    <a href="leaderboard.php">Leaderboard</a>

    </div>
</div>

<div class="main">
    <div id="board">

<?php

if(!isset($_COOKIE["username"])){ echo("<h3>Incognito!</h3>");}
else {
    echo "<h3>User:" . $_COOKIE["username"]."</h3>";
}
?>


<h2>Score: <span id="score">0</span></h2>
<button id="start_button">Start/Pause </button>

<div id = "game-view">
    <div id ="grid"></div>
    <div id="small-grid"></div>
</div>

    </div>

</body>

</div>

</html>
