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
<!-- SHOW ALL RECORDS FROM ACTIVITY TABLE -->
<div class="search-container">
    <form action="" method="GET">
        <br><input type="text" id="myInput" style="float:right;" name="search" autocomplete="off" placeholder="SEARCH" size="50" value="<?php if(isset($_GET['activityID'])){echo $_GET['activityID']; } ?>" autofocus>
    </form>
</div>
<div class="table-container">
    <table class="move" id="activitylist">
        <tr>
            <th>No</th>
            <th>activityID</th>
            <th>acitivityName</th>
            <th>date</th>
            <th>time</th>
            <th>location</th>
            <th>advisor</th>
            <th>DELETE</th>
        </tr>
    <!-- RECORD DISPLAY AND SEARCH FUNCTION -->
        <?php
            $no=1;
            if(isset($_GET['search'])){
                $searchQuery = safe($con, $_GET['search']);
                $query = "SELECT * FROM activity AS t1 INNER JOIN advisor AS t2 
                            ON t1.advisorID = t2.advisorID
                            WHERE CONCAT(t2.advisorName,t1.activityName,t1.location) LIKE '%$searchQuery%' 
                            ORDER BY t1.activityID ASC";
            }else{
                $query = "SELECT * FROM activity AS t1 INNER JOIN advisor AS t2 
                            ON t1.advisorID = t2.advisorID
                            ORDER BY t1.activityID ASC";
            }
            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
        ?>
                        <tr>
                            <td><?php echo $no; ?></td>
                            <td><?php echo $row['activityID']; ?></td>
                            <td><?php echo $row['activityName']; ?></td>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['advisorName']; ?></td>
                            <!-- DELETE ACTIVITY FUNCTION -->
                            <td><a style="display: inline-block; width: auto;" href="activity_delete.php?id=<?php echo $row['activityID'];?>" onclick="return confirm('Delete activity record?')">
                                <button class="button2"><span class="button_icon2"><ion-icon name="close-outline"></ion-icon></span></button></a>
                            </td>
                        </tr>
        <?php $no++;} 
            }else{
                echo "<tr><td colspan='7'>No record found.</td></tr>";
            }
        ?>
    </table><br>
</div>
<hr><br><h3 class="textindent">Add New Activity</h3><br>
<form method="post" action="activity_save.php" style="text-align: center;">
    <input type="text" name="activityID" placeholder="Activity ID" size="20" maxlength="4" required>
    <input type="text" name="activityName" placeholder="Activity Name" size="20" required autofocus>
    <input type="date" name="date" required>
    <input type="time" name="time" required>
    <select name="location" required>
        <option value="">Select Activity Location</option>
        <option value="LR501">LR501</option>
        <option value="LR502">LR502</option>
        <option value="LR503">LR503</option>
        <option value="LR504">LR504</option>
        <option value="LR505">LR505</option>
        <option value="LR506">LR506</option>
        <option value="LR507">LR507</option>
        <option value="LR508">LR508</option>
        <option value="LR509">LR509</option>
        <option value="LR510">LR510</option>
        <option value="LR511">LR511</option>
        <option value="LR512">LR512</option>
        <option value="AI Lab">AI Lab</option>
        <option value="ICT Lab A">ICT Lab A</option>
        <option value="ICT Lab B">ICT Lab B</option>
        <option value="Lecture Theatre">Lecture Theatre</option>
    </select>
    <select name="advisor" required>
        <option value="">--SELECT ADVISOR--</option>
            <?php
                $advisor_query = mysqli_query($con, "SELECT * FROM advisor ORDER BY advisorName ASC");
                while($adv = mysqli_fetch_assoc($advisor_query)){
                    echo "<option value='".$adv['advisorID']."'>".$adv['advisorName']."</option>";
                }
            ?>
    </select>
    <br><br>
    <!-- ADD ACTIVITY BUTTON -->
    <div style="float: right;">
        <button class="button1" name="add" type="submit">
            <span class="button_text1">ADD</span>
            <span class="button_icon1">
                <ion-icon name="add-outline"></ion-icon>
            </span>
    </button><br>
    </div>
</form><br>
</html>