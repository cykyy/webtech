<?php
$username = htmlspecialchars($_GET["username"]);
require_once 'controller/getUser.php';
$arra = getUserAccount($username);
if (!$arra){
    echo "<span style='color: green'> Username available</span>";
}else if($arra["Username"] === $username){
    echo "<span style='color: red'> Username taken! Choose another one</span>";
} else{
    echo "<span style='color: green'> Username available</span>";
}
?>