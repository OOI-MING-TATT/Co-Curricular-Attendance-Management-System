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
        // QUICK SEARCH VALUE
        $ActID = "";
        $StID = "";
        $searchQuery = "";
        $dateFilter = "";

        if(isset($_GET['activityID'])){
            $ActID = safe($con, $_GET['activityID']);
        }

        if(isset($_GET['studentID'])){
            $StID = safe($con, $_GET['studentID']);
        }

        if(isset($_GET['search'])){
            $searchQuery = safe($con, $_GET['search']);
        }

        if(isset($_GET['dateFilter'])){
            $dateFilter = safe($con, $_GET['dateFilter']);
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
    </style>

    <div class="main-content">
        <div id="Div1">
            <img class='logo' src="images/picture2.png" alt="logo"><span style="vertical-align: middle;font-weight: 650;">E-Attendance IICP Computer Club INTI</span><hr>
            <br><br><h3 class="textindent">Attendance List</h3><br><hr>
        </div>
        <!-- SHOW ALL RECORDS FROM STUDENT TABLE -->
         <div class="search-container">
            <form action="" method="GET">
                <br><input type="text" id="myInput" style="float:right;" name="search" autocomplete="off" placeholder="SEARCH" size="50" value="<?php if(isset($_GET['search'])){ echo htmlspecialchars($_GET['search']);} ?>" autofocus>
            </form>
        </div>
        <form method="GET" action="">
            <select name="activityID" onchange="this.form.submit()">
                <option value="">All Activities</option>
                <?php
                    $activityList = mysqli_query($con, "SELECT * FROM activity");

                    while($act = mysqli_fetch_array($activityList)){
                ?>
                    <option value="<?php echo $act['activityID']; ?>"
                        <?php if(isset($_GET['activityID']) && $_GET['activityID']==$act['activityID']) echo "selected"; ?>>
                        <?php echo $act['activityName']; ?>
                    </option>
                <?php } ?>
            </select>

            <select name="dateFilter" onchange="this.form.submit()">
                <option value="">All Dates</option>
                <option value="past" <?php if(isset($_GET['dateFilter']) && $_GET['dateFilter']=='past') echo "selected"; ?>>Past Activities</option>
                <option value="upcoming" <?php if(isset($_GET['dateFilter']) && $_GET['dateFilter']=='upcoming') echo "selected"; ?>>Upcoming Activities</option>
            </select>

            <select name="studentID" onchange="this.form.submit()">
                <option value="">All Students</option>

                <?php
                $studentList = mysqli_query($con, "SELECT * FROM student ORDER BY studentName ASC");

                while($stu = mysqli_fetch_array($studentList)){
                ?>
                    <option value="<?php echo $stu['studentID']; ?>"
                        <?php if(isset($_GET['studentID']) && $_GET['studentID']==$stu['studentID']) echo "selected"; ?>>
                        <?php echo $stu['studentName']; ?>
                    </option>
                <?php } ?>
            </select>
        </form>
        <div class="table-container">
            <table class="move" id="studentlist">
                <tr>
                    <th>No</th>
                    <th>studentID</th>
                    <th>studentName</th>
                    <th>activityID</th>
                    <th>activityName</th>
                    <th>attendanceStatus</th>
                </tr>
            <!-- DISPLAY AND SEARCH FUNCTION -->
                <?php
                    $no=1;
                    $query = "SELECT * FROM student AS t1
                            INNER JOIN record AS t2
                            ON t1.studentID = t2.studentID
                            INNER JOIN activity AS t3
                            ON t3.activityID = t2.activityID
                            WHERE 1=1";
                    // SEARCH BOX
                    if($searchQuery != ""){
                        $query .= " AND CONCAT(t2.attendanceStatus,t1.studentID,t1.studentName,t3.activityName,t3.activityID) LIKE '%$searchQuery%'";
                    }
                    // FILTER BY ACTIVITY
                    if($ActID != ""){
                        $query .= " AND t2.activityID='$ActID'";
                    }
                    // FILTER BY STUDENT
                    if($StID != ""){
                        $query .= " AND t2.studentID='$StID'";
                    }
                    // FILTER BY DATE
                    if($dateFilter == "past"){
                        $query .= " AND t3.date < CURDATE()"; 
                    } else if($dateFilter == "upcoming"){
                        $query .= " AND t3.date >= CURDATE()"; 
                    }

                    $query .= " ORDER BY t1.studentID ASC";

                    $result = mysqli_query($con, $query);

                    $todayDate = date('Y-m-d');

                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                        //Disable editing if the activity date has passed
                        $disableEdit = ($row['date'] < $todayDate) ? "disabled" : "";
                ?>
                                <tr data-date="<?php echo $row['date']; ?>">
                                    <td><?php echo $no; ?></td>
                                    <td><?php echo $row['studentID']; ?></td>
                                    <td><?php echo $row['studentName']; ?></td>
                                    <td><?php echo $row['activityID']; ?></td>
                                    <td><?php echo $row['activityName']; ?></td>
                                    <!-- CHANGE ATTENDANCE STATUS FUNCTION -->
                                    <td>
                                        <form action="attendance_update.php" method="POST">
                                            <input type="hidden" name="studentID" value="<?php echo $row['studentID']; ?>">
                                            <input type="hidden" name="activityID" value="<?php echo $row['activityID']; ?>">
                                            <input type="hidden" name="returnURL" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>">
                                            
                                            <input type="hidden" name="studentID"
                                                value="<?php echo $row['studentID']; ?>">

                                            <input type="hidden" name="activityID"
                                                value="<?php echo $row['activityID']; ?>">

                                            <label>
                                                <input type="radio" 
                                                    name="attendanceStatus"
                                                    value="Present"
                                                    <?php if ($row['attendanceStatus'] == 'Present') echo 'checked'; ?>
                                                        <?php echo $disableEdit; ?>
                                                    onchange="this.form.submit();">
                                                Present
                                            </label>

                                            <label>
                                                <input type="radio"
                                                    name="attendanceStatus"
                                                    value="Absent"
                                                    <?php if ($row['attendanceStatus'] == 'Absent') echo 'checked'; ?>
                                                        <?php echo $disableEdit; ?>
                                                    onchange="this.form.submit();">
                                                Absent
                                            </label>

                                        </form>
                                    </td>
                                </tr>
                <?php $no++;} 
                    }else{
                        echo "<tr><td colspan='6'>No record found.</td></tr>";
                    }
                ?>
            </table><br>
        </div>
            <!-- PRINT FUNCTION -->
            <br><p>
                <button class="button3" id="button">
                    <span class="button_text3">PRINT</span>
                    <span class="button_icon3">
                        <ion-icon name="print-outline"></ion-icon>
                    </span>
                </button>
            </p><br>
            
            <script>
                // FUNCTION FOR MENU
                let btn = document.querySelector('#btn')
                let sidebar = document.querySelector('.sidebar')

                btn.onclick = function(){
                sidebar.classList.toggle('active')
                };

                // FUNCTION FOR SAVING AND RESTORING SCROLL POSITIONS (WINDOW + TABLE)
                document.addEventListener("DOMContentLoaded", function(){
                    const tableContainer = document.querySelector(".table-container");

                    //RESTORE POSITIONS ON LOAD
                    const savedWindowScroll = localStorage.getItem("windowScrollTop");
                    const savedTableScroll = localStorage.getItem("tableScrollTop");

                    if(savedWindowScroll !== null){
                        window.scrollTo(0, parseInt(savedWindowScroll, 10));
                    }

                    if(tableContainer && savedTableScroll !== null){
                        tableContainer.scrollTop = parseInt(savedTableScroll, 10);
                    }

                    //SAVE POSITIONS ON RADIO BUTTON CLICK (Before Form Reloads)
                    const radioButtons = document.querySelectorAll('input[type="radio"][name="attendanceStatus"]');
                    radioButtons.forEach(function (radio) {
                        radio.addEventListener("click", function(){
                            //Save page window scroll position
                            localStorage.setItem("windowScrollTop", window.scrollY || document.documentElement.scrollTop);
                            
                            //Save inner table scroll position
                            if(tableContainer){
                                localStorage.setItem("tableScrollTop", tableContainer.scrollTop);
                            }
                        });
                    });

                    //ALSO SAVE IF DROPDOWN FILTERS ARE USED
                    const selects = document.querySelectorAll('select[name="activityID"], select[name="studentID"]');
                    selects.forEach(function (select){
                        select.addEventListener("change", function(){
                            localStorage.setItem("windowScrollTop", window.scrollY || document.documentElement.scrollTop);
                            if(tableContainer){
                                localStorage.setItem("tableScrollTop", tableContainer.scrollTop);
                            }
                        });
                    });
                    //ALSO SAVE IF DROPDOWN FILTERS ARE USED
                    const selects = document.querySelectorAll('select[name="activityID"], select[name="studentID"], select[name="dateFilter"]');
                    selects.forEach(function (select){
                        select.addEventListener("change", function(){
                            localStorage.setItem("windowScrollTop", window.scrollY || document.documentElement.scrollTop);
                            if(tableContainer){
                                localStorage.setItem("tableScrollTop", tableContainer.scrollTop);
                            }
                        });
                    });
                });
                

                // PRINT FUNCTION
                function printData(){
                    // GET THE TABLE AND MAKE A COPY
                    var divToPrint = document.getElementById("studentlist").cloneNode(true);

                    var rows = divToPrint.querySelectorAll("tr");

                    var totalRecords = 0;
                    var presentRecords = 0;
                    var absentRecords = 0;
                    var activityDates = [];

                    // CHANGE RADIO BUTTONS TO PRESENT OR ABSENT TEXT
                    rows.forEach(function(row, index){
                        if(index > 0 && row.cells.length >= 6){
                            // GET ACTIVITY DATE
                            var activityDate = row.getAttribute("data-date");
                            if(activityDate && !activityDates.includes(activityDate)){
                                activityDates.push(activityDate);
                            }

                            // GET SELECTED ATTENDANCE STATUS
                            var statusCell = row.cells[5];
                            var selectedStatus = statusCell.querySelector("input[type='radio']:checked");
                            if(selectedStatus){
                                totalRecords++;                                
                                if(selectedStatus.value == "Present"){
                                    presentRecords++;
                                }else{
                                    absentRecords++;
                                }
                                statusCell.textContent = selectedStatus.value;
                            }
                        }
                    });

                    // CALCULATE ATTENDANCE RATE
                    var attendanceRate = 0;

                    if(totalRecords > 0){
                        attendanceRate = (presentRecords / totalRecords) * 100;
                    }

                    // DETERMINE REPORT DATE
                    var reportDate;

                    if(activityDates.length == 1){
                        reportDate = activityDates[0];
                    }else{
                        reportDate = new Date().toLocaleDateString();
                    }

                    // OPEN PRINT WINDOW
                    var newWin = window.open("");

                    newWin.document.write(`
                    <html>
                        <head>
                            <title>Attendance Report</title>
                            <style>
                                body{
                                    font-family: Arial, sans-serif;
                                    margin: 30px;
                                    color: #333;
                                }
                                h2{
                                    text-align: center;
                                    margin-bottom: 5px;
                                }
                                .report-info{
                                    text-align: center;
                                    font-size: 13px;
                                    margin-bottom: 25px;
                                }
                                table{
                                    width: 100%;
                                    border-collapse: collapse;
                                    margin-top: 20px;
                                }
                                th{
                                    background-color: #eeeeee;
                                }

                                th, td{
                                    border: 1px solid #cccccc;
                                    padding: 10px;
                                    text-align: center;
                                    font-size: 12px;
                                }
                                .summary{
                                    margin-top: 25px;
                                    padding: 15px;
                                    border: 1px solid #cccccc;
                                    background-color: #f8f8f8;
                                }
                                .summary h3{
                                    margin-top: 0;
                                }
                                .summary p{
                                    margin: 7px 0;
                                    font-size: 13px;
                                }
                                @media print{
                                    body{
                                        margin: 15mm;
                                    }
                                }
                            </style>
                        </head>

                        <body>
                            <h2>E-Attendance IICP Computer Club INTI</h2>

                            <div class="report-info">
                                Attendance Report
                                <br>
                                Date: ${reportDate}
                            </div>

                            ${divToPrint.outerHTML}

                            <div class="summary">
                                <h3>Attendance Summary</h3>
                                <p><b>Total Records:</b> ${totalRecords}</p>
                                <p><b>Present:</b> ${presentRecords}</p>
                                <p><b>Absent:</b> ${absentRecords}</p>
                                <p><b>Attendance Rate:</b> ${attendanceRate.toFixed(2)}%</p>
                            </div>
                        </body>
                    </html>
                    `);

                    newWin.document.close();
                    newWin.focus();
                    newWin.print();
                    newWin.close();
                }

                const btn2 = document.getElementById("button");
                btn2.addEventListener('click', () => printData());

            </script>
        </div>
    </div>
    </body>
</html>
