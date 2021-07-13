<nav>
<?php
if (isset($_SESSION['uname'])) {
    echo '<span>Logged in as '.$_SESSION['uname'] .'</span> | ';
    echo '<span>Logout</span>';
    } else {
    echo '
  <a href="/webtech/Lab4/">Home</a> |
  <a href="/webtech/Lab4/login.php">Login</a> |
  <a href="/webtech/Lab4/registration.php">Registration</a>
</nav>';
}


