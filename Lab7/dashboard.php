<?php
session_start();
?>
<link rel="stylesheet" type="text/css" href="css/nav.css">
<div class="topnav">
    <a class="active" href="./index.php">Home</a>

    <?php
    if (!isset($_SESSION['uname'])) {
        if ("test"!=='Subscriber') {
            $sg = "";
            echo "
            <div class='dropdown'>
                    <button class='dropbtn'>$sg Panel
            ";
            echo '
                  <!--i class="fa fa-caret-down"></i-->
                  <i class=""></i>
                    </button>
                    <div class="dropdown-content">
                      <a href="./dashboard.php">Dashboard</a>
                      <a href="./trackers.php">Trackers</a>
                      <a href="./accounts.php">Accounts</a>
                      <a href="./view_profile.php">View Profile</a>
                      <a href="./edit_profile.php">Edit Profile</a>
                      <a href="./profile_picture.php">Change Profile Picture</a>
                      <a href="./change_password.php">Change Password</a>
                      <a href="./logout.php">Logout</a>
                    </div>
                  </div>
            ';
        } else {
            echo '
            <div class="dropdown">
                <button class="dropbtn">User Panel
                  <i class="fa fa-caret-down"></i>
                </button>
                <div class="dropdown-content">
                  <a href="./dashboard.php">Dashboard</a>
                  <a href="./my_trackers.php">Trackers</a>
                  <a href="./view_profile.php">View Profile</a>
                  <a href="./edit_profile.php">Edit Profile</a>
                  <a href="./change_password.php">Change Password</a>
                  <a href="./logout.php">Logout</a>
                </div>
              </div>
       <a href="./logout.php">Logout</a>
       <a href="#contact">Contact</a>
       <a href="#about">About</a>
      ';
        }
    } else {
        echo '
       <a href="./login.php">Login</a>
       <a href="./contact.php">Contact</a>
       <a href="./privacy-policy.php">Privacy Policy</a>
       <a href="./about.php">About</a>
      ';
    }
    ?>

</div>
<?php
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
    // header('Location: login.php');
}
?>
<link rel="stylesheet" type="text/css" href="css/dashboard.css">
<div class="color-white text-center margin-solve">
    This page demonstrates the nav dropdown menu. To test, please hover over the Panel text if you are on a computer
    device or click on the Panel button if you are on a mobile device.
</div>
