<?php
session_start();
include 'templates/nav2.php';
include 'templates/base2.php';
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    $ug = $_SESSION['ugroup'];
    echo "
    <h1 style='text-align: center; color: white'> Welcome to Cartista $ug Panel</h1>
    ";

}else{
    header('Location: login.php');
}

?>

