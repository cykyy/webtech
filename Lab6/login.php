<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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

<?php
session_start();
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    header('Location: dashboard.php');

} else{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $userErr = "Username is required";
        $errCount = $errCount + 1;
    } else {
        $username = check_input($_POST["username"]);

        if (strlen($username) <2 ) {
            // code...
            $userErr = "Minimum 2 characters required";
            $errCount = $errCount + 1;
        }elseif (!preg_match("/^[a-zA-Z_\-.]*$/", $username)) {
            $userErr = "Username can contain alpha numeric characters, period, dash or underscore only!";
            $username ="";
            $errCount = $errCount + 1;
        } else{
            if (isset($_POST['rmbm'])) {
                $time = time();
                setcookie('username', $username, $time + 120);
                setcookie('password', $password, $time + 120);
            }
        }

    }

    if (empty($_POST["password"])) {
        $passErr = "Password is required";
        $errCount = $errCount + 1;
    } else {
        $password = check_input($_POST["password"]);
    }

    if (strlen($password) <8 ) {
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

    if ($errCount < 1){
        $time = time();
        if (isset($_POST['rmbm'])) {
            setcookie('username', $username, $time + 10);
            setcookie('password', $password, $time + 10);
        }
        require_once 'controller/login.php';

        // db login goes here
        $dt = loginUser($username);
        if ($dt) {
            $user_found = true;
            if ($password === $dt['Password']){
                $_SESSION['uname'] = $username;
                echo "Thanks for logging in.";
                header('Location: dashboard.php');
            } else{
                $passErr .= "Password Wrong!";
            }
        } else{
            $user_found = false;
        }

        if (!$user_found){
            echo $userErr .= "No account found!";
        }


        //exit;

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

<div class="donor-info make-it-center">
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Username: <input type="text" name="username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">
        <span class="error">* <?php echo $userErr;?></span>
        <br><br>
        Password: <input type="password" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
        <span class="error">* <?php echo $passErr;?></span>
        <br><br>
        <input type="checkbox" id="rmbm" name="rmbm" value="True">
        <label for="rmbm"> Remember Me</label><br><br>

        <input type="submit" name="submit" value="Submit">
        <a href="/webtech/Lab6/forgot.php"> <span>Forgot Password?</span> </a>

    </form>

</div>


</body>
<?php include 'templates/footer.php';?>
</html>