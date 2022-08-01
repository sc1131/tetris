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

if(isset($_POST['firstname']) && isset($_POST['lastname'])&& isset( $_POST['uname'])&& isset($_POST['pass'])&&isset($_POST['setting']))
{
    //Collect info
    $firstname=$_POST['firstname'];
    $surname=$_POST['lastname'];
    $username=$_POST['uname'];
    $password=$_POST['pass'];
    $displayscore=$_POST['setting']=='Yes'?1:0;


    $sql = "SELECT * FROM Users WHERE username ='".$username."';";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        echo("User already exists");
    }
    else{
        $sql = "INSERT INTO Users (firstname,surname, username,unhashedpassword,displayscore) VALUES 
    ('". $firstname . "','".$surname."','" .  $username . "','" . $password. "',".$displayscore.");";

        if ($conn->query($sql) === TRUE) {
            echo "User Created <br>";
            echo ("<a href='http://localhost:8888/src/Tetris/index.php '>Log in here</a>");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>


<html>

<head>
    <link rel="stylesheet" href="generalstyling.css"></link>
    <style>
        #regForm{
            box-shadow: 5px 5px;
            background-color: grey;
            width: 300px;
            margin:auto;
        }

        h1{

           text-align: center;
        }

        form{

            text-align: center;
        }

    </style>
    <title>Registration </title>
</head>

<div class="topnav">

    <a href="index.php">Home</a>

    <div class="right-topnav">

        <a href="tetris.php">Play Tetris</a>
        <a href="leaderboard.php">Leaderboard</a>

    </div>
</div>


<div class="main">

    <h1>Register</h1>
    <div id="regForm">



<form method="post">
    <label for="fname">First Name:</label><br>
   <p>  <input type="text" id="first" name="firstname"></p>
    <label for="sname">Surname:</label><br>
    <p>  <input type="text" id="last" name="lastname"></p>
    <label for="uname">Username:</label><br>
    <p><input type="text" id="username" name="uname" placeholder="Enter username"></p>
    <label for="pass">Password:</label><br>
    <p> <input type="password" id="password" name="pass" Placeholder="Password" onChange="onChange()"></p>
    <label for="pass">Password:</label><br>
    <p><input type="password" id="password" name="confirmPass" Placeholder="Confirm Password" onChange="onChange()"></p>
    <label for="score?">Display Scores on Leaderboard:</label> <br>
    <label for="affirmative">Yes</label>
    <input type="radio" id="affirmative" name="setting" value="Yes">
    <label for="negative">No</label>
    <input type="radio" id="negative" name="setting" value="No"><br>


   <p> <input type="submit" value="Register"></p>
</form>

    </div>

<script>

    function onChange() {
        const password = document.querySelector('input[name=pass]');
        const confirm = document.querySelector('input[name=confirmPass]');
        if (confirm.value === password.value) {
            confirm.setCustomValidity('');
        } else {
            confirm.setCustomValidity('Passwords do not match');
        }
    }



</script>



</div>

</html>

