<?php include "header.php";?>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <style>
        form.move{
            left: 50%;
            top: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            width:400px;
        }
        br.small{
            line-height: 10px;
        }
        img.lg{
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }
        body{
            background: url('images/background.jpg');
            background-size: 100% 100%;
            background-repeat: no-repeat;
            background-position: center center;
            background-attachment: fixed;
        }
    </style>
    <body>
        <div id="menu">
            <form class="move" method="post" action="login_check.php">
                <img class="lg" src="images/picture2.png">
                <br><br>
                <label>Student ID / Advisor ID</label><br>
                <input type="text" name="ID" placeholder="TYPE HERE *PXXXXXXXX OR UR ADVISOR ID"
                size="50%" required autofocus />
                <br><br>
                <label>Password</label><br>
                <input type="password" name="password" id="password"
                placeholder="******" size="50%" required autofocus/><br>
                <input type="checkbox" onclick="showPassword()">Show Password<br><br>
                <div class="text-center">
                    <button name="submit" type="submit">LOG IN</button><br><br class="small">
            </form>
                    <a href="signup.php"><button type="button">SIGNUP</button></a>
                </div>
                <script>
                    function showPassword(){
                        var x = document.getElementById("password");
                        if(x.type == "password"){
                            x.type = "text";
                        }else{
                            x.type = "password";
                        }
                    }
                </script>
        </div>
    </body>
</html>