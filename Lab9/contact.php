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
    <h1 style="text-align: center">Cartista Contact</h1>

<div style="text-align: center">
    Have a question in mind? Start with saying hi to us...
<div>mail: hi@cartista.com</div>
</div>

<?php
if (!isset($_SESSION['uname'])) {
}
?>