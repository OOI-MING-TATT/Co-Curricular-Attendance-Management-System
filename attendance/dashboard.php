<?php include 'header.php';?>
<html>
    <?php include 'menu.php';?>
    <?php
    // REDIRECT USER IF NOT LOGGED IN
        if(!isset($_SESSION['user'])){
            echo "<script>window.location='index.php'</script>";
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
        h4.textindent{
            text-indent: 20px;
        }
        img.logo{
            display: inline-block;
            height: 10%;
            pointer-events: none;
            vertical-align: middle;
        }
    </style>
    <div class="main-content">
        <div id="Div1">
            <img class='logo' src="images/picture2.png" alt="logo"><span style="vertical-align: middle;font-weight: 650;">E-Attendance IICP Computer Club INTI</span><hr>
                <br><br><h3 class="textindent">Welcome <?php
                    echo strtoupper ($_SESSION['name']);
                    echo"</h3><br><hr><br><h4 class='textindent'>DATE: ".$dateNow;
                    echo"</h4><h4 class='textindent'>TIME: ".$timeNow;
                    echo"</h4>"?><br><hr>
        </div>
        <?php
        // VERIFY WHETHER THE USER IS AN ADMIN OR A STUDENT, AND ROUTE TO THE APPROPRIATE FUNCTION
            if($_SESSION['user']!="advisor"){
                include 'studentpage.php';
            }else{
                include 'activityedit.php';
            }
        ?>
    </div>
    </body>
    <script>
        // FUNCTION OF MENU
        let btn = document.querySelector('#btn')
        let sidebar = document.querySelector('.sidebar')

        btn.onclick = function(){
            sidebar.classList.toggle('active')
        };
  </script>
</html>