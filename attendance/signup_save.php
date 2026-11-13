<?php
// CONNECT TO DATABASE
    require 'database.php';
// RECEIVE POST VALUES
    $studentName = $_POST['studentName'];
    $studentID = $_POST['studentID'];
    $phoneNumber = $_POST['phoneNumber'];
    $password = $_POST['password'];
    $programme = $_POST['programme'];
// CHECK EXISTING RECORDS FIRST
    $checkStudent = mysqli_query($con,"SELECT * FROM student WHERE studentID ='$studentID'");
    $studentCount = mysqli_num_rows($checkStudent);
// ENSURE THAT NO RECORDS EXIST
    if($studentCount == 0){
        mysqli_query($con, "INSERT INTO student (studentID, studentName, password, phoneNo, programme) VALUES ('$studentID','$studentName', '$password', '$phoneNumber','$programme')") or die(mysqli_error($con));
        echo "<script>alert('Registration successful');
        window.location='index.php'</script>";
    }else{
        echo "<script>
        alert('Registration failed. Please check your student ID');
        window.location='signup.php'</script>";
    }
?>
