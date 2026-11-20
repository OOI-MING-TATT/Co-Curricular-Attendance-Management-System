<?php
// DATABASE CONNECTION
    require 'database.php';
// RECEIVE POST VALUE
    $StID=$_POST['studentID'];
    $StName=$_POST['studentName'];
    $StPw=$_POST['password'];
    $StHp=$_POST['phoneNumber'];
    $StPro=$_POST['programme'];

    if(isset($_POST['add2'])){
// CHECK EXISTING DATA       
        $checkStudent=mysqli_query($con,"SELECT * FROM student WHERE studentID='$StID'");

        $Stdetail=mysqli_num_rows($checkStudent);
// MAKE SURE NO RECORD
        if($Stdetail == 0){
            mysqli_query($con, "INSERT INTO student (studentID, studentName, password, phoneNo, programme) VALUES ('$StID','$StName', '$StPw', '$StHp','$StPro')") or die(mysqli_error($con));
            echo "<script>alert('Student added successfully');
            window.location='student_update.php'</script>";
        }else{
            echo "<script>
            alert('Failed to add the student, please try again.');
            window.location='student_update.php'</script>";
        }
    }
?>