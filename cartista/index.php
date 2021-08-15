<?php
session_start();
include 'templates/nav2.php'; ?>
<?php include 'templates/base2.php';
?>
<style>
    body{
        color: white;
    }
    .make-it-center{
        margin: auto;
        width: 50%;
    }
</style>
<br> <br>
<h1 style="text-align: center">Thanks for visiting Cartista. An app to track products stock.</h1>
<?php
if (!isset($_SESSION['uname'])) {
    echo '<p style="text-align: center">Please login to use the app</p>';
    }
?>