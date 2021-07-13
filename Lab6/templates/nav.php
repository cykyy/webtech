<nav>
<?php
if (isset($_SESSION['uname'])) {
    echo '<span>Logged in as '.$_SESSION['uname'] .'</span> | ';
    echo '<a href="logout.php">Logout</a>';
} else {
    echo '
  <a href="/webtech/Lab4/">Home</a> |
  <a href="/webtech/Lab4/login.php">Login</a> |
  <a href="/webtech/Lab4/registration.php">Registration</a>
</nav>';
}


