<?php
// DATABASE CONNECTION
    require 'database.php';
// RECEIVE POST VALUE
    $AcID=$_POST['activityID'];
    $AcName=$_POST['activityName'];
    $Acdate=$_POST['date'];
    $Actime=$_POST['time'];
    $AcL=$_POST['location'];
    $Acadv=$_POST['advisor'];

    if(isset($_POST['add'])){
// CHECK EXISTING DATA       
        $checkActivity=mysqli_query($con,"SELECT * FROM activity WHERE activityID='$AcID'");

        $Acdetail=mysqli_num_rows($checkActivity);
// MAKE SURE NO RECORD
        if($Acdetail == 0){
            mysqli_query($con, "INSERT INTO activity (activityID, activityName, date, time, location, advisorID) VALUES
            ('$AcID','$AcName','$Acdate','$Actime','$AcL','$Acadv')") or die(mysqli_error($con));
            echo "<script>alert('Record added successfully');
            window.location='dashboard.php'</script>";
        }else{
            echo "<script>
            alert('Failed to add the record, please try again.');
            window.location='dashboard.php'</script>";
        }
    }
?>