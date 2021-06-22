<!DOCTYPE html>
<html>
<?php include 'templates/head.html';?>
<body>
<?php include 'templates/nav.php';?>
<br>
<br>

<?php

session_start();

if (isset($_SESSION['uname'])) {
    session_destroy();
    header("location:login.php");

}

else{
    header("location:login.php");
}

?>
<br>
<br>
</body>
<?php include 'templates/footer.php';?>
</html>