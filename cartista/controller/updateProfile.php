<?php
require_once 'controller/getUser.php';
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    $name = $email = $gender = $dob = '';
    $err = '';

    echo "<h1 class='text-center'>Edit Profile </h1>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //$name = $email = $gender = $dob = '';
        $errCount = 0;
        if (!empty($_POST["name"])) {
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

        if (!empty($_POST["email"])) {
            $email = check_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $email="";
                $errCount = $errCount + 1;
            }
        }

        if (!empty($_POST["gender"])) {
            $gender = check_input($_POST["gender"]);
        }

        if (!empty($_POST["dob"])) {
            $dob = $_POST["dob"];
        }

        if($errCount > 0) {
            echo "<span class='error'>One or more error occurred!</span>";
        } else {
            $user_edited = false;
            $dataDB = null;
            $userRes = getUserAccount($_SESSION['uname']);
            if ($userRes) {
                // var_dump($arra);

                if ($_SESSION['uname'] === $userRes['Username']) {
                    $dataDB['Name'] = $name;
                    $dataDB['Email'] = $email;
                    $dataDB['Gender'] = $gender;
                    $dataDB['dob'] = $dob;
                    $user_edited = true;

                }

                if ($user_edited) {
                    if(updateUser($_SESSION['uname'], $dataDB)){
                        echo "<span style='color: green'>User Edited Successfully!</span>";
                    }
                }
            }

        }


    } else {
        $userRes = getUserAccount($_SESSION['uname']);
        if ($_SESSION['uname'] === $userRes['Username']){
            // do stuff
            $name = $userRes['Name'];
            $email = $userRes['Email'];
            $gender = $userRes['Gender'];
            $dob = $userRes['dob'];
        }
    }

} else{
    header('Location: login.php');
}
function check_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>