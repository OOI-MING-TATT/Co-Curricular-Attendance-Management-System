<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
      *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      }
      .user-img{
        width: 50px;
        border-radius: 100%;
        border: 1px solid #eee  
      }
      .sidebar{
        position: fixed;
        top: 0;
        left: 0;
        height: 115%;
        width: 80px;
        background-color: #12171e;
        padding: .4rem .8rem;
        transition: all 0.5s ease;
        z-index: 9999;
        overflow: visible
      }
      .sidebar.active ~ .main-content{
        left: 250px;
        width: calc(100% - 250px);
      }
      .sidebar.active{
        width: 250px
      }
      .sidebar #btn{
        position: absolute;
        color: #fff;
        top: .4rem;
        left: 50%;
        font-size: 1.2rem;
        line-height: 50px;
        transform: translateX(-50%);
        cursor: pointer;
      }
      .sidebar.active #btn{
        left: 90%;
      }
      .sidebar .top .logo{
        color: #fff;
        display: flex;
        height: 50px;
        width: 100%;
        align-items: center;
        pointer-events: none;
        opacity: 0;
      }
      .sidebar.active .top .logo{
        opacity: 1;
      }
      .top .logo i{
        font-size: 2rem;
        margin-right: 5px;
      }
      .user{
        display: flex;
        align-items: center;
        margin: 1rem 0;
      }
      .user p{
        color: #fff;
        opacity: 1;
        margin-left: 1rem;
      }
      .bold{
        font-weight: 600;
      }
      .sidebar p{
        opacity: 0;
      }
      .sidebar.active p{
        opacity: 1;
      }
      .sidebar ul li{
        position: relative;
        list-style-type: none;
        height: 50px;
        width: 90%;
        margin: 0.8rem auto;
        line-height: 50px; 
      }
      .sidebar ul li .tooltip{
        position: absolute;
        left: 125px;
        top: 50%;
        transform: translate(-50%, -50%);
        color: white;
        background-color: #12171e;
        box-shadow: 0 0.5rem 0.8rem rgba(0,0,0,1);
        border-radius: .6rem;
        padding: .4rem 1.2rem;
        line-height: 1.8rem;
        z-index: 20;
        opacity: 0;
        pointer-events: none;
      }
      .sidebar ul li:hover .tooltip{
        opacity: 1;
      }
      .sidebar.active ul li .tooltip {
        display: none;
      }
      .sidebar ul li a{
        color: #fff;
        display: flex;
        align-items: center;
        text-decoration: none;
        border-radius: 0.8rem;
      }
      .sidebar ul li a:hover{
        background-color: #fff;
        color: #12171e;
      }
      .sidebar ul li a i{
        min-width: 50px;
        text-align: center;
        height: 50px;
        border-radius: 12px;
        line-height: 50px;
      }
      .sidebar .nav-item {
        opacity: 0;
      }
      .sidebar.active .nav-item {
        opacity: 1;
      }
      .main-content{
        position: relative;
        min-height: 100vh;
        top: 0;
        left: 80px;
        transition: all 0.5s ease;
        width: calc(100% - 80px);
        padding: 1rem;
      }
      .top .logo img{
        font-size: 2rem;
        margin-right: 5px;
        width: 30%;
        border-radius: 10px;
      }
      #container{
        position: relative;
      }
    </style>
  </head>
  <body>
    <div id="container">
        <div class="sidebar">
        <!-- Admin Menu -->
        <?php
            if($_SESSION['user']=="advisor"){
        ?>
        <div class="top">
            <div class="logo">
                <img src="images/picture3.png" alt="logo">
                <span>IICP_CC</span>          
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <div class="user">
            <img src="images/logo.png" alt="member" class="user-img">
            <div>
                <p class="bold">IICP_COMPUTER CLUB_UNIT</p>
                <p>Advisor</p>
            </div>
        </div>
        <ul>
            <li>
                <a href="dashboard.php">
                    <i class='bx bxs-home'></i>
                    <span onmouseover="tooltiphome()"class="nav-item">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li>
                <a href="student_update.php">
                    <i class='bx bxs-user-rectangle' ></i>
                    <span class="nav-item">Student_Update</span>
                </a>
                <span class="tooltip">Student_Update</span>
            </li>
            <li>
                <a href="attendance.php">
                    <i class='bx bxs-notepad'></i>
                    <span class="nav-item">Attendance</span>
                </a>
                <span class="tooltip">Attendance</span>
            </li>
            <li>
                <a href="logout.php">
                    <i class='bx bxs-log-out'></i>
                    <span class="nav-item">Log_Out</span>
                </a>
                <span class="tooltip">Log_Out</span>
            </li>
        </ul>
        <!-- Student Menu -->
        <?php
            }else{
        ?>
        <div class="top">
            <div class="logo">
                <img src="images/picture3.png" alt="logo">
                <span>IICP_CC</span>          
            </div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <div class="user">
            <img src="images/logo.png" alt="member" class="user-img">
            <div>
                <p class="bold">IICP_COMPUTER CLUB_UNIT</p>
                <p><?php echo strtoupper ($_SESSION['name']);?></p>
            </div>
        </div>
        <ul>
            <li>
                <a href="dashboard.php">
                <i class='bx bxs-home'></i>
                <span class="nav-item">Home</span>
                </a>
                <span class="tooltip">Home</span>
            </li>
            <li>
                <a href="logout.php">
                <i class='bx bxs-log-out'></i>
                <span class="nav-item">Log_Out</span>
                </a>
                <span class="tooltip">Log_Out</span>
            </li>
        </ul>
        <?php }?>
    </div>
    <script>
        function tooltiphome(){
            <span class="tooltip">Home</span>
        }
    </script>