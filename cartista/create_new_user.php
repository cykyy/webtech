<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';

require_once 'controller/createNewUserIncludes.php'
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <script>
        function validateForm() {
            let usrnm = document.forms["reg_form"]["username"].value;
            let passwrd = document.forms["reg_form"]["password"].value;
            let name = document.forms["reg_form"]["name"].value;
            let email = document.forms["reg_form"]["email"].value;
            let cnfrmPass = document.forms["reg_form"]["cnfrmPass"].value;
            let gender = document.forms["reg_form"]["gender"].value;
            let dob = document.forms["reg_form"]["dob"].value;
            let resp;
            if (name === "") {
                alert("Name must be filled out");
                document.getElementById("res_text").innerHTML = "Name must be filled out";
                document.getElementById("res_text").style.color="red";
                return false;
            }else if (email === "") {
                alert("Email must be filled out");
                document.getElementById("res_text").innerHTML = "Email must be filled out";
                document.getElementById("res_text").style.color="red";
                return  false;
            }else if (gender === "") {
                alert("Gender must be filled out");
                document.getElementById("res_text").innerHTML = "Gender must be filled out";
                document.getElementById("res_text").style.color="red";
                return false;
            }else if (dob === "") {
                alert("Date of Birth must be filled out");
                document.getElementById("res_text").innerHTML = "Date of Birth must be filled out";
                document.getElementById("res_text").style.color="red";
                return false;
            }else if (usrnm === "") {
                alert("Username must be filled out");
                document.getElementById("res_text").innerHTML = "Username must be filled out";
                document.getElementById("res_text").style.color="red";
                return false;
            } else if (passwrd === ""){
                alert("Password must be filled out");
                document.getElementById("res_text").innerHTML = "Password must be filled out";
                document.getElementById("res_text").style.color="red";
                return false;
            }else if (cnfrmPass === "") {
                alert("Confirm password must be filled out");
                document.getElementById("res_text").innerHTML = "Confirm password must be filled out";
                document.getElementById("res_text").style.color="red";
                return false;
            }else{
                document.getElementById("res_text").innerHTML = x;
                document.getElementById("res_text").style.color="black";
            }
        }
        // vanilla js XMLHTTP
        function check_username_vanilla() {
            var username = document.getElementById("username").value
            //alert('all good '+username)
            if (!username) {
                document.getElementById("result").innerHTML = '';
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        document.getElementById("result").innerHTML = this.responseText;
                    }
                }
                xmlhttp.open("GET", "controller/check_username_db.php?username="+username, true);
                xmlhttp.send();
            }
        }

        function validedName(){
            var name = document.getElementById('name').value
            if (howManyWord(name) < 2){
                document.getElementById("name_res").innerHTML = '<span style="color: red">Please type both last and first name!</span>';
            } else {
                document.getElementById('name_res').innerHTML = ''
            }
        }

        function howManyWord(val){
            var res = val.trim().split(' ').length;
            // alert(res)
            return res
        }

    </script>
    <link rel="stylesheet" href="assets/css/registration.css">
</head>

<body>
<div class="text-center">
<div class="container" style="width:500px;">
    <h2 class="text-center">Create a New Account</h2>
    <form method="post" onsubmit="return validateForm()" name="reg_form" class="form">
        <?php
        if(isset($error))
        {
            echo $error;
        }
        ?>
        <div id="res_text"></div>
        <label>Name</label>  <span class="error">* <?php echo $nameErr;?></span>
        <input type="text" id="name" onchange="validedName()" name="name" class="form-control" value="<?php echo $name;?>" />
        <div id="name_res"></div><br>
        <label>E-mail</label> <span class="error">* <?php echo $emailErr;?></span>
        <input type="text" name = "email" class="form-control" value="<?php echo $email;?>" /><br /><br/>
        <label>User Name</label>  <span class="error">* <?php echo $userErr;?></span>
        <input type="text" id="username" onkeyup="check_username_vanilla()" name = "username" class="form-control" value="<?php echo $username;?>" />
        <div id="result"></div><br>
        <label>Password</label>  <span class="error">* <?php echo $passErr;?></span>
        <input type="password" name = "password" class="form-control" /><br /><br/>
        <label>Confirm Password</label>  <span class="error">* <?php echo $confrmPassErr;?></span>
        <input type="password" name = "cnfrmPass" class="form-control" /><br /><br/>

        <fieldset>
            <legend>Gender</legend>  <span class="error">* <?php echo $genderErr;?></span>
            <input type="radio" id="male" name="gender" value="male" <?php if ($gender === 'male'){ echo 'checked';}?> >
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female" <?php if ($gender === 'female'){ echo 'checked';}?> >
            <label for="female">Female</label>
            <input type="radio" id="other" name="gender" value="other" <?php if ($gender === 'other'){ echo 'checked';}?> >
            <label for="other">Other</label><br>

            <legend>Date of Birth:</legend>  <span class="error">* <?php echo $dobErr;?></span>
            <input type="date" name="dob" value="<?php echo $dob;?>"> <br><br>
        </fieldset><br/>

        <label for="acc_grp">Choose a Account Type:</label>

        <select name="acc_grp" id="acc_grp">
            <option value="Subscriber">Subscriber</option>
            <option value="Support">Support</option>
        </select> <br><br>

        <button type="submit" name="submit" value="Create Now" class="btn btn-info" >Create Now </button><br />
        <?php
        if(isset($message))
        {
            echo $message;
        }
        ?>
    </form>
</div>
<br />
</div>
</body>
</html>