<?php
// SET TIME ZONE
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $dateNow=date("Y-m-d");
    $timeNow=date("H:i:s");
// SET DATABASE
    $host="localhost";
    $user="root";
    $db="attendance";
    $password="";
// DATABASE CONNECTION
    $con= mysqli_connect($host,$user,$password,$db);
    if(mysqli_connect_errno()){
        echo"Database connection failed!:".mysqli_connect_error();
    }
?>
