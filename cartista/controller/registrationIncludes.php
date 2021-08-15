<?php
session_start();
include 'templates/nav2.php';
include 'templates/base2.php';
if (isset($_SESSION['uname'])) {
    header('Location: dashboard.php');

} else {
// define variables and set to empty values
    $nameErr = $emailErr = $degreeErr = $genderErr = $userErr = $passErr = $confrmPassErr = $dobErr = "";
    $name = $email = $gender = $username = $password = $cnfrmPass = "";
    $dob = $successmsg = "";
    $dobdd = $dobmm = $dobyy = "";
    $errCount = 0;
    $message = '';
    $error = '';
    function check_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    if (isset($_POST["submit"])) {

        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
            $errCount = $errCount + 1;
        } else {
            $name = check_input($_POST["name"]);
            $wcount = str_word_count($name);
            if ($wcount < 2) {
                // code...
                $nameErr = "Minimum 2 words required";
                $errCount = $errCount + 1;
            }

            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z]/", $name)) {
                $nameErr = "Name must start with a letter!";
                $name = "";
                $errCount = $errCount + 1;
            }

            if (!preg_match("/^[a-zA-Z_\-. ]*$/", $name)) {
                $nameErr = "Only letters, period and white space allowed";
                $name = "";
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
                $email = "";
                $errCount = $errCount + 1;
            }
        }


        if (empty($_POST["username"])) {
            $userErr = "Username is required";
            $errCount = $errCount + 1;
        } else {
            $username = $_POST["username"];

            if (strlen($username) < 2) {
                // code...
                $userErr = "Minimum 2 characters required";
                $errCount = $errCount + 1;
            }

            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z_\-.]*$/", $username)) {
                $userErr = "Username can contain alpha numeric characters, period, dash or underscore only!";
                $username = "";
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


            if (strlen($password) < 8) {
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
                $password = "";
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


        if ($errCount > 0) {
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


            if (registerUser($data)) {
                echo '<span class="text-center">New User successfully registered!!</span>';
                $name = '';
                $email = '';
                $username = $gender = $dob = '';
            }

        }
    }

}
?>