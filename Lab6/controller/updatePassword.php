<?php
require_once 'model/model.php';
require_once 'controller/getUser.php';
require_once 'controller/updatePassword.php';
session_start();
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    echo "<h2>Change Password</h2>";

    $curPassErr = $newPassErr = $retypePassErr = $userErr = "";
    $username = "";
    $currPass = $newPass = $retypePass = "";
    $errCount = 0;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $username = $_SESSION['uname'];

        if (empty($_POST["current_pass"])) {
            $curPassErr = "Current password is required to change password";
            $errCount = $errCount + 1;
        } else {
            $currPass = check_input($_POST["current_pass"]);

            $newPass = check_input($_POST["new_password"]);
            $retypePass = check_input($_POST["retype_password"]);

            if (empty($newPass)) {
                // code...
                $newPassErr = "New password is required to change password";
                $errCount = $errCount + 1;
            }

            if (empty($retypePass)) {
                $retypePassErr = "You must retype your new password!";
                $errCount = $errCount + 1;
            }

            if ($newPass === $currPass) {
                // validation for the new password
                $newPassErr .= " New Password should not be same as the Current Password";
                $errCount = $errCount + 1;
            }

            if ($newPass !== $retypePass) {
                // code...
                $retypePassErr .= " Retype password don't match with new password!";
                $errCount = $errCount + 1;
            }

            if (strlen($currPass) < 8) {
                // code...
                $curPassErr .= " Current password cannot be less than 8 characters. Error!";
                $errCount = $errCount + 1;
            }

            // Change Password Code
            if ($errCount <= 0) {
                if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[\d%$#@]).+$/", $newPass)) {
                    /*
                      ^ starts the string
                    (?=.*[a-z]) Atleast a lower case letter
                    (?=.*[A-Z]) Atleast an upper case letter
                    (?!.* ) no space
                    (?=.*\d%$#@) Atleast a digit and atleast one of the specified characters.
                    .{8,16} between 8 to 16 characters
                      */
                    $newPassErr = "New Password must contain at-least a digit, a lower case and an upper case letter, atleast one of the [%$#@] and no space.";
                    $errCount = $errCount + 1;
                }
            }

        }

        if ($errCount < 1){
            $userRes = getUserAccount($_SESSION['uname']);
            if ($userRes) {
                $user_found = true;
                if ($currPass === $userRes['Password']){
                    // password also matched! now change password...
                    echo "<br>";
                    echo "Thanks for approving the password change". $userRes['Name'] . "! Request processing...";
                    // change password code here...
                    echo "<br>";
                    $pass_change = true;
                }else{
                    $curPassErr .= "Password Wrong!";
                }
            }
            if ($pass_change){
                if(updatePassword($username, $newPass)){
                    echo "<span style='color: green'>Password Changed Successfully!</span><br>";
                }
            }

            if (!$user_found){
                echo $userErr .= "No account found!";
            }


            //exit;

        }

    }


} else{
    header('Location: login.php');
}

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>
