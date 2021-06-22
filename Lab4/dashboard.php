<!DOCTYPE html>
<html>
<?php include 'templates/head.html';?>
<body>

<div class="sidenav">
    <a href="#">Dashboard</a>
    <a href="view_profile.php">View Profile</a>
    <a href="#">Edit Profile</a>
    <a href="#">Change Profile Picture</a>
    <a href="#">Change Password</a>
    <a href="logout.php">Logout</a>
</div>

<?php
session_start();
include 'templates/nav.php';
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    echo "<h1> Welcome ".$_SESSION['uname']."</h1>";

} else{
    header('Location: login.php');
}

?>

<br>
<br>
</body>
<?php include 'templates/footer.php';?>
</html>