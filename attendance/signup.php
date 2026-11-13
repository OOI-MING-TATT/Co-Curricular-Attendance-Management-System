<?php include 'header.php'; ?>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <style>
        h2{
            display: block;
            font-size: 1.5em;
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 0;
            margin-right: 0;
            font-weight: bold;
        }
        h4{
            display: block;
            font-size: 0.7em;
            margin-top: 0;
            margin-bottom: 0;
            margin-left: 0;
            margin-right: 0;
            font-weight: bold;
        }
        p{
            font-size: 1.0em;
            font-weight: bold;
            color: #000000;
        }
        img{
            position: absolute;
            bottom: 70px;
            right: 40px;
        }
        table,th,td{
            text-align: left;
        }
        td.button{
            text-align: right;
        }
        th.blank,td.blank{
            width: 50px;
        }
        td.blank2{
            width: 50px;
            height: 15px;
        }
        form.move {
            left: 50%;
            top: 50%;
            position: absolute;
            transform: translate(-50%, -50%);
            width: 600px;
            padding: 3%;
            background-color: rgba(255,255,255,.5);
            border: none;
            outline: none;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: rgba(0, 0, 0, 0.19)
            0px 10px 20px,
            rgba(0, 0, 0, 0.23)
            0px 6px 6px;
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
        <div class="content">
            <form class="move" method="post" id="form1" action="signup_save.php">
                <h2>REGISTRATION</h2>
                <h4>*Please ensure that your information is correct before registering.</h4><br>
                <table>
                    <tr>
                        <th><p>Student ID</p></th>
                        <th class="blank"></th>
                        <th><p>Name</p></th>
                    </tr>
                    <tr>
                        <td><input type="text" name="studentID" placeholder="Type here *PXXXXXXXX"
                        size="20" pattern="P[0-9]{8}" required autofocus></td>
                        <td class="blank"></td>
                        <td><input type="text" name="studentName" placeholder="Your name"
                        size="40" pattern="[A-Za-z\s]{1,}" autocomplete="off" required autofocus></td>
                    </tr>
                    <tr>
                        <td class="blank2"></td>
                        <td class="blank2"></td>
                        <td class="blank2"></td>
                    </tr>
                    <tr>
                        <td><p>New Password</p></td>
                        <td class="blank"></td>
                        <td><p>Phone Number</p></td>
                    </tr>
                    <tr>
                        <td><input type="password" name="password" id="newPassword" placeholder="******"
                        size="20" required autofocus><br>
                        <input type="checkbox" onclick="showPassword2()">Show Password</td>
                        <td class="blank"></td>
                        <td><input type="text" name="phoneNumber" placeholder="Without -"
                        pattern="[0-9]{10,14}" size="25" autocomplete="off" required autofocus></td>
                    </tr>
                    <tr>
                        <td class="blank2"></td>
                        <td class="blank2"></td>
                        <td class="blank2"></td>
                    </tr>
                    <tr>
                        <td><p>Confirm Password</p></td>
                        <td class="blank"></td>
                        <td><p>Programme</p></td>
                    </tr>
                    <tr>
                        <td><input type="password" name="confirmPassword" id="confirmPassword" placeholder="Same as new password"
                        onkeyup="validate_password()" minlength="6" maxLength="6" size="20" required autofocus><br>
                        <input type="checkbox" onclick="showPassword3()">Show Password</td>
                        <td class="blank"></td>
                        <td><select name="programme" required>
                                <option value="">--SELECT--</option>
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
                            </select></td>
                    </tr>
                    <tr>
                        <td class="blank2"></td>
                        <td class="blank2"></td>
                        <td class="blank2"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="blank"></td>
                        <td class="button"><span id="passwordAlert"></span>
                            <button name="submit" id="create" type="submit" onclick="wrong_pass_alert()">REGISTER</button></td>
                    </tr>
                </table>
                <script>
                // POP-UP FUNCTION FOR INVALID INPUT
                    document.querySelector('input[name="studentName"]').addEventListener('invalid', function(){
                        if(this.validity.patternMismatch){
                            this.setCustomValidity('Your name can only contain alphabetic characters');
                        }else if(this.validity.valueMissing){
                            this.setCustomValidity('Please enter your name');
                        }else{
                            this.setCustomValidity('');
                        }
                    });

                    document.querySelector('input[name="studentID"]').addEventListener('invalid', function(){
                        if(this.validity.patternMismatch && this.value.length === 9){
                            this.setCustomValidity('Student ID must start with a capital P followed by 8 digits');
                        }else if(this.value.length !== 9 && this.value.length >= 1){
                            this.setCustomValidity('Student ID must be exactly 9 characters long (P + 8 digits)');
                        }else if(this.validity.valueMissing){
                            this.setCustomValidity('Please enter your Student ID');
                        }else{
                            this.setCustomValidity('');
                        }
                    });

                    document.querySelector('input[name="phoneNumber"]').addEventListener('invalid', function(){
                        if(this.validity.patternMismatch && (this.value.length >= 10 && this.value.length <= 14)){
                            this.setCustomValidity('Phone number must contain 10 to 14 digits');
                        }else if(this.validity.valueMissing){
                            this.setCustomValidity('Please enter your phone number');
                        }else if(this.value.length >= 1 && (this.value.length < 10 || this.value.length > 14)){
                            this.setCustomValidity('Phone number must contain 10 to 14 digits');
                        }else{
                            this.setCustomValidity('');
                        }
                    });

                    document.querySelector('input[name="password"]').addEventListener('invalid', function(){
                        if(this.validity.valueMissing){
                            this.setCustomValidity('Please enter your password');
                        }else if(this.value.length !== 6){
                            this.setCustomValidity('Password must contain exactly 6 characters');
                        }else{
                            this.setCustomValidity('');
                        }
                    });

                    document.querySelector('input[name="confirmPassword"]').addEventListener('invalid', function(){
                        if(this.validity.valueMissing){
                            this.setCustomValidity('Please confirm your password');
                        }else if(this.value.length !== 6){
                            this.setCustomValidity('Password must contain exactly 6 characters');
                        }else{
                            this.setCustomValidity('');
                        }
                    });

                // CHECK NEW PASSWORD
                    function validate_password(){
                        let newPassword = document.getElementById('newPassword').value;
                        let confirmPassword = document.getElementById('confirmPassword').value;
                        if(newPassword != confirmPassword){
                            document.getElementById('passwordAlert').style.color = 'red';
                            document.getElementById('passwordAlert').innerHTML
                            = '☒ Passwords do not match';
                            document.getElementById('create').disabled = true;
                            document.getElementById('create').style.opacity = (0.4);
                        }else{
                            document.getElementById('passwordAlert').style.color = 'green';
                            document.getElementById('passwordAlert').innerHTML
                            = '🗹 Passwords match';
                            document.getElementById('create').disabled = false;
                            document.getElementById('create').style.opacity = (1);
                        }
                    }

                    function showPassword2(){
                        var x = document.getElementById("newPassword");
                        if(x.type == "password"){
                            x.type = "text";
                        }else{
                            x.type = "password";
                        }
                    }

                    function showPassword3(){
                        var x = document.getElementById("confirmPassword");
                        if(x.type == "password"){
                            x.type = "text";
                        }else{
                            x.type = "password";
                        }
                    }
                </script>
            </form>
        </div>
    </body>
</html>