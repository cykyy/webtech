<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';

if (!isset($_SESSION['uname'])) {
    header('Location: login.php');
}
?>

<html>
<head>
    <title>All Accounts</title>
    <link rel="stylesheet" type="text/css" href="assets/css/views.css">
</head>

<?php
require_once 'controller/getUser.php';
/*
$strJsonFileContents = file_get_contents("data.json");
// var_dump($strJsonFileContents);

$arra = json_decode($strJsonFileContents);
$is_ad = which_group($arra);
*/

$arra = getAllUserAccount();
$is_ad = which_group_v2($arra);

echo '
    <h2 class="text-center">Accounts List</h2> 
<h3 class="text-center"><a href="./create_new_user.php"> Create New Account </a>  |  <a href="./edit_any_account.php">Edit an Account</a></h3> 
    <table class="table">
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Password</th>
            <th>Email</th>
            <th>Group</th>
            <th>Status</th>
        </tr>
    ';
// var_dump($arra);
foreach($arra as $item) { //foreach element in $arr
    if ($_SESSION['ugroup'] === 'Admin' || $_SESSION['ugroup'] === 'Support') {
        if ($_SESSION['ugroup'] === 'Support'){
            if ($item['acc_group'] !== 'Subscriber'){
                continue;
            }
        } else if ($_SESSION['ugroup'] === 'Admin'){
            if ($item['acc_group'] === 'Admin'){
                continue;
            }
        }

        echo "
        <tr>
            <td>" .$item['Name']. "</td>
            <td>" .$item['Username']. "</td>
            <td>" .$item['Password']. "</td>
            <td>" .$item['Email']. "</td>
            <td>" .$item['acc_group']. "</td>
            <td>" .$item['status']. "</td>
        </tr>
        ";
    }
}
echo '
    </table>
';

function which_group($arra) {
    foreach($arra as $item) {
        if ($_SESSION['uname']==$item->username){
            // match
            if ($item->acc_group === 'Admin'){
                return 'Admin';
            } elseif ($item->acc_group === 'Support'){
                return 'Support';
            } else {
                return 'Subscriber';
            }
        }
    }
    return false;
}

function which_group_v2($arra) {
    foreach($arra as $item) {
        if ($_SESSION['uname']==$item['Username']){
            // match
            if ($item['acc_group'] === 'Admin'){
                return 'Admin';
            } elseif ($item['acc_group'] === 'Support'){
                return 'Support';
            } else {
                return 'Subscriber';
            }
        }
    }
    return false;
}
?>
<!--
<br><br>
<h3 style="text-align: center"><a href="/cartista/create_new_user.php"> Add New Account </a></h3>
-->

</html>