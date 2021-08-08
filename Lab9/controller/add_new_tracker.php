<?php
require_once '../model/model.php';
if(isset($_POST["uri"])) {
    $uri_post = $_POST["uri"];
    } else{
    return ;
}
if(createTracker($uri_post)){
    echo "<span style='color: green'>Tracker inserted to the database Successfully!</span><br>";
}

?>
