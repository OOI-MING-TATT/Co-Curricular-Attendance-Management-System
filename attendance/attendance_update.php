<?php
// DATABASE CONNECTION
    require 'database.php';

// RECEIVE POST VALUE
    $atStID = $_POST['studentID'];
    $atActID = $_POST['activityID'];
    $AttStatus = $_POST['attendanceStatus'];

// GET PREVIOUS PAGE URL
    $backPage = $_SERVER['HTTP_REFERER'];

    if($AttStatus == "Present" || $AttStatus == "Absent"){
        mysqli_query($con, "UPDATE record SET attendanceStatus='$AttStatus' WHERE studentID='$atStID' AND activityID='$atActID'") or die(mysqli_error($con));
        echo "<script>window.location='$backPage'</script>";
    }else{
        echo "<script>window.location='$backPage'</script>";
    }
?>