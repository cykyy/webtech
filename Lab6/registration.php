<?php
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
            echo 'New User successfully registered!! <a href="../showAllProducts.php">Go Back</a> ';
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
    <style>

        .make-it-center{
            margin: auto;
            width: 50%;
        }

        body{
            background: #eeeaea;
            margin: auto;
            width: 50%;
            border: 1px solid #3e3c3c;
            padding: 20px;

        }

        .lefterr{
            margin-left: -10%;
        }

        .required:after {
            content:"*";
            color: red;
        }
        .error{
            color: red;
        }

        /* The sidebar menu */
        .sidenav {
            height: 100%; /* Full-height: remove this if you want "auto" height */
            width: 220px; /* Set the width of the sidebar */
            position: fixed; /* Fixed Sidebar (stay in place on scroll) */
            z-index: 1; /* Stay on top */
            top: 0; /* Stay at the top */
            left: 0;
            background-color: #111; /* Black */
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 20px;
        }

        /* The navigation menu links */
        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
        }

        /* When you mouse over the navigation links, change their color */
        .sidenav a:hover {
            color: #f1f1f1;
        }

    </style>
</head>

<body>
<?php include 'templates/nav.php';?>
<div class="donor-info make-it-center">
<br />
<div class="container" style="width:500px;">
    <h3 align="">Register a New Account</h3><br />
    <form method="post">
        <?php
        if(isset($error))
        {
            echo $error;
        }
        ?>
        <br />
        <label>Name</label>  <span class="error">* <?php echo $nameErr;?></span>
        <input type="text" name="name" class="form-control" value="<?php echo $name;?>" /> <br/>
        <label>E-mail</label> <span class="error">* <?php echo $emailErr;?></span>
        <input type="text" name = "email" class="form-control" value="<?php echo $email;?>" /><br />
        <label>User Name</label>  <span class="error">* <?php echo $userErr;?></span>
        <input type="text" name = "username" class="form-control" value="<?php echo $username;?>" /><br />
        <label>Password</label>  <span class="error">* <?php echo $passErr;?></span>
        <input type="password" name = "password" class="form-control" /><br />
        <label>Confirm Password</label>  <span class="error">* <?php echo $confrmPassErr;?></span>
        <input type="password" name = "cnfrmPass" class="form-control" /><br />

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
        </fieldset>

        <input type="submit" name="submit" value="Register" class="btn btn-info" /><br />
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
<?php include 'templates/footer.php';?>
</html>