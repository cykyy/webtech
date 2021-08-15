<?php
$username = htmlspecialchars($_GET["username"]);
require_once '../model/model.php';
$myObj = '';
$arra = getUser($username);;
if ($arra){
    $myJSON = json_encode($arra)."\n";
    echo $myJSON;
}else{
    $arr = array('response' => '404');
    echo json_encode($arra)."\n";
}
?>