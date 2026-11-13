<?php include 'header.php'; ?>
<html>
    <?php include 'menu.php';?>
    <?php
    // REDIRECT USER IF NOT LOGGED IN
        if(!isset($_SESSION['user'])){
            echo "<script>window.location='index.php'</script>";
        }
        if($_SESSION['user'] != 'advisor'){
            echo "<script>window.location='dashboard.php'</script>";
        }
        function safe($con, $value) {
            if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
                $value = stripslashes($value);
            }
            $value = mysqli_real_escape_string($con, $value);
            return $value;
        }
    ?>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <style>
        h3.textindent{
            text-indent: 20px;
        }
        a.width{
            display: block;
            width: 20%;
        }
        table,th,td{
            text-align: center;
            font-size: 12px;
        }
        table.move{
            margin-top:10px;
            margin-left:0px;
            border-collapse: collapse;
            width: 100%;
        }
        th{
            position: sticky;
            top: 0;
            background-color: #ffffff;
            z-index: 1;
            height: 20px;
        }
        th, td{
            padding: 8px;
            border-bottom: 1px solid #DDD;
        }
        tr{
            background-color: #ffffff;
            height: 25px;
        }
        tr:hover{
            background-color: #D6EEEE;
        }
        img.logo{
            display: inline-block;
            height: 10%;
            pointer-events: none;
            vertical-align: middle;
        }
        #myInput {
            background-image: url('images/searchicon.png');
            background-position: 10px 10px;
            background-repeat: no-repeat;
            width: 100%;
            font-size: 16px;
            padding: 12px 20px 12px 40px;
            border: 1px solid #ddd;
            margin-bottom: 12px;
        }
        .search-container {
            display: flex;
            justify-content: flex-start;
            width: 100%;
        }
        .table-container{
            max-height: 446px; 
            overflow-y: auto;
            border: 1px solid #ddd;
        }
        .password-wrapper {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-start;
            vertical-align: top;
        }
        .show-password-label {
            font-size: 12px;
            margin-top: 4px;
            cursor: pointer;
            user-select: none;
        }
    </style>
    <div class="main-content">
        <div id="Div1">
            <img class='logo' src="images/picture2.png" alt="logo"><span style="vertical-align: middle;font-weight: 650;">E-Attendance IICP Computer Club INTI</span><hr>
            <br><br><h3 class="textindent">Student List</h3><br><hr>
        </div>
        <!-- SHOW ALL RECORDS FROM STUDENT TABLE -->
         <div class="search-container">
            <form action="" method="GET">
                <br><input type="text" id="myInput" style="float:right;" name="search" autocomplete="off" placeholder="SEARCH" size="50" value="<?php if(isset($_GET['studentID'])){echo $_GET['studentID']; } ?>" autofocus>
            </form>
        </div>
        <div class="table-container">
            <table class="move" id="studentlist">
                <tr>
                    <th>No</th>
                    <th>studentID</th>
                    <th>studentName</th>
                    <th>password</th>
                    <th>phoneNo</th>
                    <th>programme</th>
                    <th>DELETE</th>
                </tr>
            <!-- STUDENT ACC DISPLAY AND SEARCH FUNCTION -->
                <?php
                    $no=1;
                    if(isset($_GET['search'])){
                        $searchQuery = safe($con, $_GET['search']);
                        $query = "SELECT * FROM student 
                                    WHERE CONCAT(studentName,programme) LIKE '%$searchQuery%' 
                                    ORDER BY studentID ASC";
                    }else{
                        $query = "SELECT * FROM student ORDER BY studentID ASC";
                    }
                    $result = mysqli_query($con, $query);

                    if(mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                ?>
                                <tr>
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['studentID']; ?></td>
                                    <td><?php echo $row['studentName']; ?></td>
                                    <td><?php echo $row['password']; ?></td>
                                    <td><?php echo $row['phoneNo']; ?></td>
                                    <td><?php echo $row['programme']; ?></td>
                                    <!-- DELETE STUDENT ACC FUNCTION -->
                                    <td><a style="display: inline-block; width: auto;" href="student_delete.php?id=<?php echo $row['studentID'];?>" onclick="return confirm('Delete student account?')">
                                        <button class="button2"><span class="button_icon2"><ion-icon name="close-outline"></ion-icon></span></button></a>
                                    </td>
                                </tr>
                <?php $no++;} 
                    }else{
                        echo "<tr><td colspan='7'>No student found.</td></tr>";
                    }
                ?>
            </table><br>
        </div>
        <hr><br><h3 class="textindent">Add New Student Account</h3><br>
        <form method="post" action="student_save.php" style="text-align: center;">
            <input type="text" name="studentID" placeholder="Student ID" size="25" pattern="P[0-9]{8}" required autofocus>
            <input type="text" name="studentName" placeholder="Student Name" size="25" pattern="[A-Za-z\s]{1,}" required autofocus>
            <div class="password-wrapper">
                <input type="password" name="password" id="newPassword" placeholder="Set Password" size="25" required autofocus>
                <label class="show-password-label">
                    <input type="checkbox" onclick="showPassword4()">Show Password</td>
                </label>
            </div>
            <input type="password" name="password" id="newPassword" placeholder="Set Password" size="25" required autofocus>
            <input type="text" name="phoneNumber" placeholder="PhoneNo Without -" pattern="[0-9]{10,14}" size="25" required autofocus>
            <select name="programme" required>
                <option value="">--Programme--</option>
                <option value="AUP">AUP</option>
                <option value="BACFIN">BACFIN</option>
                <option value="BCSCUN">BCSCUN</option>
                <option value="BCSCUNP">BCSCUNP</option>
                <option value="BPSNHU">BPSNHU</option>
                <option value="CBSN">CBSN</option>
                <option value="CFB">CFB</option>
                <option value="CFIT">CFIT</option>
                <option value="CFSI">CFSI</option>
                <option value="CIT">CIT</option>
                <option value="CITA">CITA</option>
                <option value="DBMN">DBMN</option>
                <option value="DCAN">DCAN</option>
                <option value="DCS">DCS</option>
                <option value="DCSA">DCSA</option>
                <option value="DDM">DDM</option>
                <option value="DDMX">DDMX</option>
                <option value="DECN">DECN</option>
                <option value="DEEI">DEEI</option>
                <option value="DHMN">DHMN</option>
                <option value="DIAN">DIAN</option>
                <option value="DIBN">DIBN</option>
                <option value="DITA">DITA</option>
                <option value="DITN">DITN</option>
                <option value="DMCN">DMCN</option>
                <option value="DMCNX">DMCNX</option>
                <option value="DMEN">DMEN</option>
                <option value="DMKTN">DMKTN</option>
            </select>
            <br><br>
            <!-- ADD STUDENT BUTTON -->
            <div style="float: right;">
                <button class="button1" name="add2" type="submit">
                    <span class="button_text1">ADD</span>
                    <span class="button_icon1">
                        <ion-icon name="add-outline"></ion-icon>
                    </span>
            </button><br>
            </div>
        </form><br>
    </div> 
    </body>
    <script>
        // FUNCTION OF MENU
        let btn = document.querySelector('#btn')
        let sidebar = document.querySelector('.sidebar')

        btn.onclick = function(){
            sidebar.classList.toggle('active')
        };

        function showPassword4(){
            var x = document.getElementById("newPassword");
            if(x.type == "password"){
                x.type = "text";
            }else{
                x.type = "password";
            }
        }
  </script>
</html>
