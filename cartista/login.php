<?php
session_start();
// all css files are mentioned there on the base2 and nav2 file.
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';?>
<?php
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
                    $_SESSION['ugroup'] = $dt['acc_group'];
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
<br><br>
<h4 class="text-center">You are not logged in! Please Login!</h4>

<script>
    function validateForm() {
        let usrnm = document.forms["login-form"]["username"].value;
        let passwrd = document.forms["login-form"]["password"].value;
        if (usrnm === "") {
            alert("Username must be filled out");
            document.getElementById("text").innerHTML = "Username must be filled out";
            document.getElementById("text").style.color="red";
            return false;
        } else if (passwrd === ""){
            alert("Password must be filled out");
            document.getElementById("text").innerHTML = "Password must be filled out";
            document.getElementById("text").style.color="red";
            return false;
        }else{
            document.getElementById("text").innerHTML = x;
            document.getElementById("text").style.color="black";
        }
    }

    function checkTextInput(){
        let usrnm = document.forms["login-form"]["username"].value;
        let passwrd = document.forms["login-form"]["password"].value;
        if (usrnm !== "" && passwrd !== "") {
            document.getElementById("sub_btn").hidden = false;
            // document.getElementById("sub_btn").style.backgroundColor="green";
        }

    }

</script>

<div class="container">
    <form method="POST" class="form" name="login-form" onsubmit="return validateForm()">

        Username:
        <span class="error">* <?php echo $userErr;?></span>
        <input type="text" onkeyup="checkTextInput()" name="username" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>">

        Password:
        <span class="error">* <?php echo $passErr;?></span>
        <input type="password" onkeyup="checkTextInput()" name="password" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
        <br>

        <input type="checkbox" id="rmbm" name="rmbm" value="True">
        <label for="rmbm"> Remember Me</label><br><br>
        <span id="text"></span>

        <!-- style="background-color: gray; " --->
        <button type="submit" id="sub_btn" value="Log in" hidden>login</button> <br> <br>

        <a href="./forgot.php"> <span>Forgot Password?</span> </a> <br>
        <a href="./registration.php"> <span>New Registration</span> </a>

    </form>
  </div>

