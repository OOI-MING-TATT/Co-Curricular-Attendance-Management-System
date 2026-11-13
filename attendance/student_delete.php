<?php
// DATABASE CONNECTION
    require 'database.php';
// GET THE DATA THAT WANT TO DELETE
    $Delete=$_GET['id'];
// FUNGSI SINGKIR AHLI
    mysqli_query($con,"DELETE FROM student WHERE studentID='$Delete'");
    echo "<script>
        alert('Delete record successfully');
        window.location='student_update.php'</script>";
?>