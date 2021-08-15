<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
</head>
<body>

<?php
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    require_once 'controller/getUser.php';
    if (getUserAccount($_SESSION['uname'])['acc_group'] === 'Subscriber') {

        echo "<h1 class='text-center'> Your Payment Information</h1>";
        echo '
    <fieldset>
    <legend> <b>Payment Settings:</b></legend>
    
    ';


        require_once 'controller/payment.php';
        $item = getUserPaymentInfo($_SESSION['uname']);

        //var_dump($item);
        $cvv = $c_name = $c_number = $exp_month = $exp_year = $address = $post_code = '';
        if (isset($item['card_name'])) {
            $c_name = $item['card_name'];
        }
        if (isset($item['card_number'])) {
            $c_number = $item['card_number'];
        }
        if (isset($item['card_cvv'])) {
            $cvv = $item['card_cvv'];
        }
        if (isset($item['expiration_month'])) {
            $exp_month = $item['expiration_month'];
        }
        if (isset($item['expiration_year'])) {
            $exp_year = $item['expiration_year'];
        }
        if (isset($item['address'])) {
            $address = $item['address'];
        }
        if (isset($item['post_code'])) {
            $post_code = $item['post_code'];
        }

        echo '<br><div> Card Holder Name: ' . $c_name . '</div> <br>';
        echo '<div> Card Number: ' . $c_number . '</div> <br>';
        echo '<div> Card Cvv: ' . $cvv . '</div> <br>';
        echo '<div> Expiration Month: ' . $exp_month . '</div> <br>';
        echo '<div> Expiration Year: ' . $exp_year . '</div> <br>';
        echo '<div> Address: ' . $address . '</div> <br>';
        echo '<div> Post Code: ' . $post_code . '</div> <br>';


        echo '<b><a href="edit_payment.php"> Edit Payment Settings ' . '</a></b> <br><br>';
        echo '</fieldset>';
    } else {
        header('Location: dashboard.php');
    }

} else{
    header('Location: login.php');
}

?>

<br>
<br>
</body>
</html>