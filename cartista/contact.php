<?php
session_start();
include 'templates/nav2.php'; ?>
<?php include 'templates/base2.php';
?>
    <br> <br>
    <h1 class="text-center">Cartista Contact</h1>

<div class="text-center">
    Have a question in mind? Start with saying hi to us...
<div>mail: hi@cartista.com</div>
</div>

<?php
if (!isset($_SESSION['uname'])) {
}
?>