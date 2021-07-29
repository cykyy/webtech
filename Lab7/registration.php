<?php
include 'templates/nav2.php';
include 'templates/base2.php';
// define variables and set to empty values
$nameErr = $emailErr = $degreeErr = $genderErr = $userErr = $passErr = $confrmPassErr = $dobErr = "";
$name = $email = $gender = $username = $password = $cnfrmPass = "";
$dob = $successmsg = "";
$dobdd = $dobmm = $dobyy = "";
$errCount = 0;
$message = '';
$error = '';
if(isset($_POST["submit"]))  {

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
        $errCount = $errCount + 1;
    } else {
        $name = check_input($_POST["name"]);
        $wcount = str_word_count($name);
        if ($wcount < 2 ) {
            // code...
            $nameErr = "Minimum 2 words required";
            $errCount = $errCount + 1;
        }

        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z]/", $name)) {
            $nameErr = "Name must start with a letter!";
            $name ="";
            $errCount = $errCount + 1;
        }

        if (!preg_match("/^[a-zA-Z_\-. ]*$/",$name)) {
            $nameErr = "Only letters, period and white space allowed";
            $name="";
            $errCount = $errCount + 1;
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
        $errCount = $errCount + 1;
    } else {
        $email = check_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $email="";
            $errCount = $errCount + 1;
        }
    }


    if (empty($_POST["username"])) {
        $userErr = "Username is required";
        $errCount = $errCount + 1;
    } else {
        $username = $_POST["username"];

        if (strlen($username) <2 ) {
            // code...
            $userErr = "Minimum 2 characters required";
            $errCount = $errCount + 1;
        }

        // check if name only contains letters and whitespace
        if (!preg_match("/^[a-zA-Z_\-.]*$/", $username)) {
            $userErr = "Username can contain alpha numeric characters, period, dash or underscore only!";
            $username ="";
            $errCount = $errCount + 1;
        }

    }


    if (empty($_POST["password"])) {
        $passErr = "Password is required";
        $errCount = $errCount + 1;
    } else {

        $password = check_input($_POST["password"]);
        $cnfrmPass = check_input($_POST["cnfrmPass"]);

        if (empty($cnfrmPass)) {
            // code...
            $confrmPassErr = "Confirm password is required";
            $errCount = $errCount + 1;
        } else {
            if ($password != $cnfrmPass) {
                // code...
                $confrmPassErr = "Confirm password is didn't match with password!";
                $errCount = $errCount + 1;
            }
        }


        if (strlen($password) < 8 ) {
            // code...
            $passErr = "Minimum 8 characters required";
            $errCount = $errCount + 1;
        }

        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[%$#@]).+$/", $password)) {
            /*
            ^ starts the string
                 (?=.*[a-z]) Atleast a lower case letter
                 (?=.*[A-Z]) Atleast an upper case letter
                 (?!.* ) no space
                 (?=.*\d%$#@) Atleast a digit and atleast one of the specified characters.
                 .{8,16} between 8 to 16 characters
            */
            $passErr .= " Password must contain atleast a digit, a lower case and an upper case letter, atleast one of the [%$#@] and no space.";
            $password ="";
            $errCount = $errCount + 1;
        }

    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
        $errCount = $errCount + 1;
    } else {
        $gender = check_input($_POST["gender"]);
    }

    if (empty($_POST["dob"])) {
        $dobErr = "Date of Birth is required";
        $errCount = $errCount + 1;
    } else {
        $dob = $_POST["dob"];
    }


    if($errCount > 0) {
        echo "<span class='error'>One or more error occurred!</span>";
    } else {

        require_once 'model/model.php';

        $data['name'] = $_POST['name'];
        echo $_POST['email'];
        $data['email'] = $email;
        $data['username'] = $_POST['username'];
        $data['password'] = $_POST['password'];
        $data['gender'] = $_POST['gender'];
        $data['dob'] = $_POST['dob'];
        $data['ppic_abs_path'] = '';

        if (isset($_POST['display'])) {
            $data['display'] = 1;
        } else {
            $data['display'] = 0;
        }

        if (registerUser($data)) {
            echo 'New User successfully registered!!';
            $name='';
            $email='';
            $username = $gender = $dob = '';
        }

    }
}
function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="staticfiles/extras.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                resp = false;
            }else if (email === "") {
                alert("Email must be filled out");
                document.getElementById("res_text").innerHTML = "Email must be filled out";
                document.getElementById("res_text").style.color="red";
                resp = false;
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
            document.getElementById("sub_btn").disabled = !(usrnm !== "" && passwrd !== "" && name !== "" && email !== "" && cnfrmPass !== "" && gender !== "" && dob !== "");
        }

        function check_username(){
            //alert('testtttt')
            // Get value from input on the page
            var username = jQuery("#username").val();
            if (username) {
                // Send the input data to the server using get
                jQuery.get("check_username_db.php", {"username": username}, function (data) {
                    // Display the returned data
                    // alert(username)
                    // alert(data)
                    document.getElementById("result").innerHTML = data;
                });
            } else {
                document.getElementById("result").innerHTML = '';
            }

            checkTextInput()
        }

    </script>
</head>

<body>
<div class="donor-info make-it-center">
<br />
<div class="container" style="width:500px;">
    <h3>User Registration</h3>
    <form name="reg_form" onsubmit="return validateForm()" method="post">
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
            <input type="radio" id="male" name="gender" oninput="checkTextInput()" value="male" <?php if ($gender === 'male'){ echo 'checked';}?> >
            <label for="male">Male</label>

            <input type="radio" id="female" name="gender" oninput="checkTextInput()" value="female" <?php if ($gender === 'female'){ echo 'checked';}?> >
            <label for="female">Female</label>

            <input type="radio" id="other" name="gender" oninput="checkTextInput()" value="other" <?php if ($gender === 'other'){ echo 'checked';}?> >
            <label for="other">Other</label><br>

            <legend>Date of Birth:</legend>  <span class="error">* <?php echo $dobErr;?></span>
            <input type="date" name="dob" oninput="checkTextInput()" value="<?php echo $dob;?>"> <br><br>

        </fieldset> <br>

        <span id="res_text"></span> <br>

        <input disabled type="submit" id="sub_btn" name="submit" value="Register" class="btn btn-info" /><br />
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