<?php
// START SESSION
    session_start();
// CONNECT TO DATABASE
    require 'database.php';
?>
<?php
// GET POST VALUES
    if(isset($_POST['submit'])){
        $ID = mysqli_real_escape_string($con,$_POST['ID']);
        $password = mysqli_real_escape_string($con,$_POST['password']);
        $queryStudent = mysqli_query($con,"SELECT * FROM student WHERE studentID = '$ID' AND password = '$password'");
        
        if(mysqli_num_rows($queryStudent) > 0){
            $row = mysqli_fetch_assoc($queryStudent);
            $_SESSION['studentID'] = $row['studentID'];
            $_SESSION['user'] = 'student';
            $_SESSION['name'] = $row['studentName'];
            echo "<script> alert('Login successful');
            window.location='dashboard.php' </script>";
            exit();
        }

        $queryAdvisor = mysqli_query($con, "SELECT * FROM advisor WHERE advisorID = '$ID' AND advisorPw = '$password'");
        
        if(mysqli_num_rows($queryAdvisor) > 0){
            $row = mysqli_fetch_assoc($queryAdvisor);
            $_SESSION['advisorID'] = $row['advisorID'];
            $_SESSION['user'] = 'advisor'; 
            $_SESSION['name'] = $row['advisorName'];
            echo "<script> alert('Login successful');
            window.location='dashboard.php' </script>";
            exit();
        }
        
        echo "<script> alert('The ID or password entered is incorrect');
        window.location='index.php' </script>";
    }
?>