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
    <h1 style="text-align: center">Cartista About</h1>
<p style="text-align: center">

    Cartista is all about purchasing the hot products before it goes out of stock. Please stay with us for more amazing features.

</p>

<?php
if (!isset($_SESSION['uname'])) {
}
?>