<?php

$servername="localhost";
$username = "root";
$password ="root";
$dbname = "Tetris";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT username, score, gamedate FROM Scores inner JOIN Users ON Scores.userid=Users.userid WHERE displayscore=1 ORDER BY score DESC ";
$result=$conn->query($sql);

?>


<html>
<head>
    <link rel="stylesheet" href="generalstyling.css"></link>

<style>
    #scoreboard{
        border-collapse: collapse;

    }
   #scoreboard th,#scoreboard td{
        border: 1px solid black;
        padding: 3px 5px;
    }

   h1{
       text-align: center;
   }
   /*align the table */
   #scoretable{

       box-shadow: 5px 5px;
       background-color: grey;
       width: 300px;
       margin:auto;
   }


</style>

</head>

<div class="topnav">

    <a href="index.php">Home</a>

    <div class="right-topnav">

        <a href="tetris.php">Play Tetris</a>
        <a href="leaderboard.php">Leaderboard</a>

    </div>
</div>

<div class="main">



<h1>Leaderboard</h1>


    <div id="scoretable">

    <table id="scoreboard">
    <tr><th>Username</th><th>Score</th><th>Date</th></tr>



    <?php


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo ("<tr> <td>".$row['username']."</td><td>".$row['score']."</td> <td>".$row['gamedate']."</td></tr>");
    }
} else {
    echo "0 results";
}
$conn->close();


?>

</table>
    </div>

</div>
</html>
