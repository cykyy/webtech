<?php
// define variables and set to empty values
$userErr = $passErr = $accUsernameErr = $accGrpErr = $accStatusErr = "";
$username = $password = $acc_username = $acc_grp = $acc_status = "";
$errCount = 0;

if (isset($_SESSION['uname']) && isset($_SESSION['ugroup'])) {
    $name = $email = $gender = $dob = '';
    $err = '';

    if ($_SESSION['ugroup'] === 'Subscriber'){
        echo '<br><div style="text-align: center">' . $_SESSION['ugroup']. ' is not allowed to perform this task!</div>';
        header('HTTP/1.0 405 Not Allowed', true, 405);
        exit();
    }

    echo "<h1 class='text-center'>Edit Any Account </h1>";

    // array code
    //$strJsonFileContents = file_get_contents("data.json");
    // var_dump($strJsonFileContents);
    //$arra = json_decode($strJsonFileContents);

    require_once 'controller/getUser.php';
    $arra = getAllUserAccount();

    // ends

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

        if (!empty($_POST["acc_grp"])) {
            $acc_grp = check_input($_POST["acc_grp"]);
            if (!($acc_grp === 'Admin' || $acc_grp === 'Support' || $acc_grp === 'Subscriber')) {
                $accGrpErr = "Account type must be either Admin/Support/Subscriber";
                $errCount = $errCount + 1;
            }
        }

        if (!empty($_POST["acc_status"])) {
            $acc_status = check_input($_POST["acc_status"]);
        }

        if (!empty($_POST["gender"])) {
            $gender = check_input($_POST["gender"]);
        }

        if (!empty($_POST["acc_username"])) {
            $acc_username = check_input($_POST["acc_username"]);
        }else{
            $errCount = $errCount +1;
        }

        if (!empty($_POST["dob"])) {
            $dob = $_POST["dob"];
        }

        if($errCount > 0) {
            echo "<span class='error'>One or more error occurred!</span>";
        } else {
            if ($arra) {
                // $strJsonFileContents = file_get_contents("data.json");
                // $arra = json_decode($strJsonFileContents);
                // var_dump($arra);
                $user_found = false;
                $user_edited = false;
                $dataDB = null;
                foreach ($arra as $item) { //foreach element in $arr
                    if ($acc_username === $item['Username']) {
                        $user_found = true;
                        $dataDB['Name'] = $name;
                        $dataDB['Email'] = $email;
                        $dataDB['Gender'] = $gender;
                        $dataDB['dob'] = $dob;
                        $dataDB['acc_group'] = $acc_grp;
                        $dataDB['status'] = $acc_status;
                        $user_edited = true;

                    }
                }
                if ($user_edited){
                    $final_data = json_encode($arra);
                    if(updateAnyUser($acc_username, $dataDB)){
                        echo "<span style='color: green'>User Edited Successfully!</span>";
                    }
                }
            }
        }


    } else {
        /*
        $strJsonFileContents = file_get_contents("data.json");
        // var_dump($strJsonFileContents);
        $arra = json_decode($strJsonFileContents);
        // var_dump($arra);
        */

        foreach ($arra as $item) { //foreach element in $arr
            if ($_SESSION['uname'] === $item['Username']) {
                // do stuff
                $name = $item['Name'];
                $email = $item['Email'];
                $gender = $item['Gender'];
                $dob = $item['dob'];
            }
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