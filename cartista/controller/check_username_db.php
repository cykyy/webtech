<?php
$username = htmlspecialchars($_GET["username"]);
require_once '../model/model.php';
$arra = getUser($username);
if (!$arra){
    echo "<span style='color: green'> Username available</span>";
}else if($arra["Username"] === $username){
    echo "<span style='color: red'> Username taken! Choose another one</span>";
} else{
    echo "<span style='color: green'> Username available</span>";
}
?>