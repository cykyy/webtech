<?php
require_once 'controller/payment.php';
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    $card_name = $card_number = $card_cvv = $exp_month = $exp_year = $address = $post_code = '';
    $err = '';

    echo "<h1 class='text-center'>Edit Payment Info </h1>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //$name = $email = $gender = $dob = '';
        $errCount = 0;
        if (!empty($_POST["card_name"])) {
            $card_name = check_input($_POST["card_name"]);
            $wcount = str_word_count($card_name);
            if ($wcount < 2 ) {
                // code...
                $err .= "Minimum 2 words required<br>";
                $errCount = $errCount + 1;
            }

            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z]/", $card_name)) {
                $err .= "Name must start with a letter!<br>";
                $name ="";
                $errCount = $errCount + 1;
            }

            if (!preg_match("/^[a-zA-Z_\-. ]*$/",$card_name)) {
                $err .= "Only letters, period and white space allowed <br>";
                $name="";
                $errCount = $errCount + 1;
            }
        }

        if (!empty($_POST["card_number"])) {
            $card_number = check_input($_POST["card_number"]);
        } else {
            $err .= "Card number cannot be empty <br>";
        }

        if (!empty($_POST["card_cvv"])) {
            $card_cvv = check_input($_POST["card_cvv"]);
        } else {
            $err .= "Card Cvv cannot be empty <br>";
        }

        if (!empty($_POST["exp_month"])) {
            $exp_month = $_POST["exp_month"];
        } else {
            $err .= "Expiry month cannot be empty <br>";
        }

        if (!empty($_POST["exp_year"])) {
            $exp_year = $_POST["exp_year"];
        } else {
            $err .= "Expiry year cannot be empty <br>";
        }

        if (!empty($_POST["address"])) {
            $address = $_POST["address"];
        } else {
            $err .= "Address cannot be empty <br>";
        }

        if (!empty($_POST["post_code"])) {
            $post_code = $_POST["post_code"];
        } else {
            $err .= "Postal code cannot be empty <br>";
        }

        if($errCount > 0) {
            echo "<span class='error'>One or more error occurred!</span>";
        } else {
            $user_edited = false;
            $dataDB = null;
            $userRes = getUserPaymentInfo($_SESSION['uname']);
            $dataDB['card_name'] = $card_name;
            $dataDB['card_number'] = $card_number;
            $dataDB['card_cvv'] = $card_cvv;
            $dataDB['exp_month'] = $exp_month;
            $dataDB['exp_year'] = $exp_year;
            $dataDB['address'] = $address;
            $dataDB['post_code'] = $post_code;
            if ($userRes) {
                if(updateUserPaymentInfo($_SESSION['uname'], $dataDB)){
                    echo "<span style='color: green'>User Payment Info Edited Successfully!</span>";
                }
            } else {
                if(createPaymentInfo($_SESSION['uname'], $dataDB)){
                    echo "<span style='color: green'>User Payment Info Edited Successfully!</span>";
                }
            }
        }


    } else {
        $userRes = getUserPaymentInfo($_SESSION['uname']);
        //var_dump($userRes);
        if ($userRes){
            $card_name = $userRes['card_name'];
            $card_number = $userRes['card_number'];
            $card_cvv = $userRes['card_cvv'];
            $exp_month = $userRes['expiration_month'];
            $exp_year = $userRes['expiration_year'];
            $address = $userRes['address'];
            $post_code = $userRes['post_code'];
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