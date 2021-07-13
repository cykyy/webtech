<?php
require_once 'model/model.php';
function updateProfilePic($username, $abs_path){
    if (updateProfilePictureAbsPath($username, $abs_path)){
        return true;
    } else{
        return false;
    }
}
?>