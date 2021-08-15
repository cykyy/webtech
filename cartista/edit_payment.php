<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>

<?php
require_once 'controller/updatePaymentIncludes.php';
require_once 'controller/getUser.php';
if (getUserAccount($_SESSION['uname'])['acc_group'] !== 'Subscriber') {
    header('Location: dashboard.php');
}
?>
        <div class="container">
            <div class="error"><?php echo $err; ?></div>
            <form method="post" class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                Card Holder Name: <input type="text" name="card_name" value="<?php echo $card_name;?>">
                <br><br>
                Card Number: <input type="text" name="card_number" value="<?php echo $card_number;?>">
                <br><br>
                Card Cvv: <input type="text" name="card_cvv" value="<?php echo $card_cvv;?>">
                <br><br>
                Expiration Month: <input type="number" name="exp_month" value="<?php echo $exp_month;?>">
                <br><br>
                Expiration Year: <input type="number" name="exp_year" value="<?php echo $exp_year;?>">
                <br><br>
                Address: <input type="text" name="address" value="<?php echo $address;?>">
                <br><br>
                Post Code: <input type="text" name="post_code" value="<?php echo $post_code;?>">
                <br><br>
                <button type="submit" name="submit" value="Submit">Submit </button>
            </form>

</div>

</body>
</html>