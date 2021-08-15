<?php
require_once 'controller/registrationIncludes.php'
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>

    <style>
        body{
            color: white;

        }
        .required:after {
            content:"*";
            color: red;
        }
        .error{
            color: red;
        }

    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        function validateName(){

        }
        function validateForm() {
            alert('test')
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

        function checkTextInput(){
            let usrnm = document.forms["reg_form"]["username"].value;
            let passwrd = document.forms["reg_form"]["password"].value;
            let name = document.forms["reg_form"]["name"].value;
            let email = document.forms["reg_form"]["email"].value;
            let cnfrmPass = document.forms["reg_form"]["cnfrmPass"].value;
            let gender = document.forms["reg_form"]["gender"].value;
            let dob = document.forms["reg_form"]["dob"].value;
            //alert('test')
            document.getElementById("sub_btn").hidden = !(usrnm !== "" && passwrd !== "" && name !== "" && email !== "" && cnfrmPass !== "" && gender !== "" && dob !== "");
        }

        // jQuery version
        function check_username(){
            //alert('testtttt')
            // Get value from input on the page
            var username = jQuery("#username").val();
            if (username) {
                // Send the input data to the server using get
                jQuery.get("controller/check_username_db.php", {"username": username}, function (data) {
                    // Display the returned data
                    // alert(data)
                    document.getElementById("result").innerHTML = data;
                });
            } else {
                document.getElementById("result").innerHTML = '';
            }

            checkTextInput();
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
            // alert(res)
            return val.trim().split(' ').length
        }

    </script>
    <link rel="stylesheet" type="text/css" href="assets/css/registration.css">
</head>

<body>
<div class="text-center">
<br />
<div class="container">
    <h3>User Registration</h3>
    <form name="reg_form" onsubmit="return validateForm()" method="post" class="form">
        <?php
        if(isset($error))
        {
            echo $error;
        }
        ?>
        <br />
        <label>Name</label>  <span class="error">* <?php echo $nameErr;?></span>
        <input type="text" onkeyup="checkTextInput()" name="name" class="form-control" value="<?php echo $name;?>" /> <br/><br/>
        <label>E-mail</label> <span class="error">* <?php echo $emailErr;?></span>

        <input type="text" name="email" onkeyup="checkTextInput()" class="form-control" value="<?php echo $email;?>" /><br /><br/>

        <label>User Name</label>  <span class="error">* <?php echo $userErr;?></span>
        <input type="text" id="username" name="username" onkeyup="check_username()" class="form-control" value="<?php echo $username;?>" /> <br/>
        <div id="result"></div><br/>

        <label>Password</label>  <span class="error">* <?php echo $passErr;?></span>

        <input type="password" name="password" onkeyup="checkTextInput()" class="form-control" /><br /><br/>
        <label>Confirm Password</label>  <span class="error">* <?php echo $confrmPassErr;?></span>

        <input type="password" name = "cnfrmPass" onkeyup="checkTextInput()" class="form-control" /><br /><br/>

        <fieldset>
            <legend>Gender</legend>  <span class="error">* <?php echo $genderErr;?></span>
            <input type="radio" id="male" name="gender" oninput="checkTextInput()" value="male" <?php if (isset($gender)){ if ($gender === 'male'){ echo 'checked';}}?> >
            <label for="male">Male</label>

            <input type="radio" id="female" name="gender" oninput="checkTextInput()" value="female" <?php if (isset($gender)){ if ($gender === 'female'){ echo 'checked';}}?> >
            <label for="female">Female</label>

            <input type="radio" id="other" name="gender" oninput="checkTextInput()" value="other" <?php if (isset($gender)){ if ($gender === 'other'){ echo 'checked';}}?> >
            <label for="other">Other</label><br>
        </fieldset> <br>

            <legend>Date of Birth:</legend>  <span class="error">* <?php echo $dobErr;?></span>
            <input type="date" name="dob" oninput="checkTextInput()" value="<?php echo $dob;?>"> <br><br>



        <span id="res_text"></span> <br>

        <button type="submit" id="sub_btn" name="submit" hidden value="Register">Register</button><br />
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