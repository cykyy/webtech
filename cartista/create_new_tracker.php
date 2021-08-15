<?php
session_start();
include 'templates/nav2.php';
include 'templates/base2.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create New Tracker</title>
    <style>

        .make-it-center{
            margin: auto;
            width: 50%;
        }

        body{
            color: white;

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

    </style>
</head>
<body>

<?php
require_once 'controller/getUser.php';
require_once 'controller/tracker.php';
// define variables and set to empty values
$errCount = 0;

$purl = "";
$orderQty = 1;
$acc_username ="";
$pUrlErr = "";
$pOrdrQtyErr = "";

if (isset($_SESSION['uname']) && isset($_SESSION['ugroup'])) {
    if ($_SESSION['ugroup'] === 'Subscriber') {
        echo '<br><div style="text-align: center">' . $_SESSION['ugroup'] . ' is not allowed to perform this task!</div>';
        header('HTTP/1.0 405 Not Allowed', true, 405);
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["purl"])) {
        $pUrlErr = "URL is required!";
        $errCount = $errCount + 1;
    } else {
        $purl = $_POST["purl"];
    }
    if (empty($_POST["order_qty"])) {
        $pOrdrQtyErr = "Order Quantity is required!";
        $errCount = $errCount + 1;
    } else {
        $orderQty = $_POST["order_qty"];
    }

    if (!empty($_POST["acc_username"])) {
        $acc_username = check_input($_POST["acc_username"]);
    }else{
        $errCount = $errCount +1;
    }
    if ($errCount < 1){
        $arra = getAllUserAccount();
        foreach($arra as $item) { //foreach element in $arr
            if ($acc_username === $item['Username']) {
                    $user_found = true;
                    if (createNewTracker($purl, $acc_username, $orderQty)) {
                        echo "<br><div style='color: green; text-align: center'> Successfully submitted! </br></div>";
                        echo "<div style='color: green; text-align: center'> Whenever there's a change of stock status (eg In-Stock/Stock-Out) You will get notified.</br></div>";
                    }
                }
        }

    }

}

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$allUsers = getAllUserAccount()

?>

<div class="container">
    <h2 class="text-center">Add a stock tracker for an Account</h2>
    <form class="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="acc_username">Select an account:</label>
        <select name="acc_username" id="acc_username">
            <?php

            foreach ($allUsers as $item) { //foreach element in $arr
                if ($item['acc_group'] !== 'Admin' && $item['acc_group'] !== 'Support') {
                    echo "<option>" .$item['Username']. "</option>";
                }

            }

            ?>
        </select> <br><br>
        Enter Product URL: <input type="text" name="purl" value="<?php echo $purl;?>">
        <span class="error">* <?php echo $pUrlErr;?></span>
        Enter Order Quantity: <input type="number" name="order_qty" value="<?php echo $orderQty;?>">
        <span class="error">* <?php echo $pOrdrQtyErr;?></span>
        <br><br>

        <button type="submit" name="submit" value="Submit"> Submit </button>

    </form>

</div>


</body>

</html>