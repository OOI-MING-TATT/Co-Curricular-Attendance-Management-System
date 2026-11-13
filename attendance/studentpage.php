<style>
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
    .bold{
        font-weight: 600;
    }
    #myInput{
        background-image: url('images/searchicon.png');
        background-position: 10px 10px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid #ddd;
        margin-bottom: 12px;
    }
    .table-container{
        max-height: 446px; 
        overflow-y: auto;
        border: 1px solid #ddd;
    }
    .search-container {
        display: flex;
        justify-content: flex-start;
        width: 100%;
    }
</style>
<div class="search-container">
    <form action="" method="GET">
        <br><input type="text" id="myInput" style="float:right;" name="search" autocomplete="off" placeholder="SEARCH" size="50" value="<?php if(isset($_GET['activityID'])){echo $_GET['activityID']; } ?>" autofocus>
    </form>
</div>
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
            if(isset($_GET['search'])){
                $searchQuery = safe($con, $_GET['search']);
                $studentID = safe($con, $_SESSION['studentID']);
                $query = "SELECT * FROM student AS t1 INNER JOIN record AS t2 ON t1.studentID = t2.studentID
                            INNER JOIN activity AS t3 ON t3.activityID = t2.activityID
                            WHERE t1.studentID = '$studentID' AND CONCAT(t2.attendanceStatus,t3.activityName,t3.activityID) LIKE '%$searchQuery%' 
                            ORDER BY t2.activityID ASC";
            }else{
                $studentID = safe($con, $_SESSION['studentID']);
                $query = "SELECT * FROM student AS t1 INNER JOIN record AS t2 ON t1.studentID = t2.studentID
                            INNER JOIN activity AS t3 ON t3.activityID = t2.activityID
                            WHERE t1.studentID = '$studentID' ORDER BY t2.activityID ASC";
            }
            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
        ?>
                        <tr data-date="<?php echo $row['date']; ?>">
                            <td><?php echo $no; ?></td>
                            <td><?php echo $row['studentID']; ?></td>
                            <td><?php echo $row['studentName']; ?></td>
                            <td><?php echo $row['activityID']; ?></td>
                            <td><?php echo $row['activityName']; ?></td>
                            <td><?php echo $row['attendanceStatus']; ?></td>
                        </tr>
        <?php $no++;} 
            }else{
                echo "<tr><td colspan='6'>No record found.</td></tr>";
            }
        ?>
    </table><br>
    </div>
    <!-- PRINT FUNCTION-->
    <br><p>
        <button class="button3" id="button">
            <span class="button_text3">PRINT</span>
            <span class="button_icon3">
                <ion-icon name="print-outline"></ion-icon>
            </span>
        </button>
    </p><br>

    <script>
        // PRINT FUNCTION
        function printData(){
            // GET THE TABLE AND MAKE A COPY
            var divToPrint = document.getElementById("studentlist").cloneNode(true);

            var rows = divToPrint.querySelectorAll("tr");

            var totalRecords = 0;
            var presentRecords = 0;
            var absentRecords = 0;
            var activityDates = [];

            // GET ATTENDANCE STATUS AND ACTIVITY DATE
            rows.forEach(function(row, index){

                if(index > 0 && row.cells.length >= 6){
                    // GET ACTIVITY DATE
                    var activityDate = row.getAttribute("data-date");

                    if(activityDate && !activityDates.includes(activityDate)){
                        activityDates.push(activityDate);
                    }

                    // GET ATTENDANCE STATUS DIRECTLY FROM TABLE
                    var status = row.cells[5].textContent.trim();

                    totalRecords++;

                    if(status == "Present"){
                        presentRecords++;
                    }else if(status == "Absent"){
                        absentRecords++;
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
