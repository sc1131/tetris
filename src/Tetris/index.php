

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
$message="";
$success=false;
if(isset($_POST['uname'])&& isset($_POST['pass']))
{
    $username=$_POST['uname'];
    $password=$_POST['pass'];

    $sql = "SELECT userid FROM Users WHERE username ='".$username."' AND unhashedpassword='".$password."';";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row=$result->fetch_row();
        $userid=$row[0];

       $message="Login Successful <br> Welcome to Tetris <br> <a href='http://localhost:8888/src/Tetris/tetris.php'> Click Here to Play </a>";
        $success=true;


    setcookie("userid",$userid,time()+(24*60*60));
    setcookie("username",$username,time()+(24*60*60));
    }
    else{

        $message= "Login failed <br>Don't have a user account? <a href='http://localhost:8888/src/Tetris/register.php'>Register Now</a>" ;
    }
}

?>


<html>

<head>
    <title>Welcome </title>
    <link rel="stylesheet" href="generalstyling.css"></link>
    <style>
        #box{
            width: 300px;

            box-shadow: 5px 5px;
            background-color: grey;
            margin: auto;
        }
        h1{
            text-align: center;
        }
        #result{

            text-align: center;



        }

        form{
            text-align: center;

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



<h1>Welcome to Tetris</h1>
    <?php
    if(!$success)
//  print form if no successful login
    {


    ?>
    <div id="box">



<form method="post">
    <label for="uname">Username:</label><br>
    <input type="text" id="username" name="uname" placeholder="Enter username"><br>
    <label for="pass">Password:</label><br>
    <input type="password" id="password" name="pass" Placeholder="Password"><br>
    <input type="submit" value="Login">
</form>



    </div>

    <?php
    }
    ?>

    <div id="result">
        <?php

        echo($message);

        ?>

    </div>



</div>


</html>


