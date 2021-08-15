<?php

// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$abs_path = '';
$imgErr = '';
$errCount = 0;

if (isset($_SESSION['uname'])) {
    require_once 'controller/getUser.php';
    require_once 'controller/updateProfilePic.php';
    $arra = getUserAccount($_SESSION['uname']);

    echo "<h1>Change Profile Picture</h1>";

    if ($arra){
        if ($_SESSION['uname'] === $arra['Username']){
            $abs_path = $arra['ppic_abs_path'];
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["submit"])) {
            $target_dir = "media/uploads/";
            $target_file = $target_dir . basename($_FILES["image_to_up"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $mime_type_arr = array('jpg', 'png', 'jpeg');
            if (in_array($imageFileType, $mime_type_arr)) {
                // code...
                if ($_FILES["image_to_up"]["size"] > 4000000) {
                    $imgErr .= " Sorry, your file is larger than 4MB";
                    $uploadOk = 0;
                } else {
                    // Check if file already exists
                    if (file_exists($target_file)) {
                        $imgErr .= "Image already exists. Request processing...";
                        $uploadOk = 0;
                        $abs_path = $target_file;
                        if(updateProfilePic($_SESSION['uname'], $abs_path)){
                            echo "<span style='color: green'>Profile Picture Updated Successfully!</span>";
                        }
                    } else {
                        if (move_uploaded_file($_FILES["image_to_up"]["tmp_name"], $target_file)) {
                            // echo "<span style='color:green;'>"."The image ". htmlspecialchars( basename( $_FILES["image_to_up"]["name"])). " has been uploaded.</span>";
                            $abs_path = $target_file;

                            if(updateProfilePic($_SESSION['uname'], $abs_path)){
                                echo "<span style='color: green'>Profile Picture Updated Successfully!</span>";
                            }

                        } else {
                            $imgErr .= "Sorry, there was an error uploading your file.";
                        }
                        //echo "<br>abs path ".$target_file;
                        //echo "<br> Image file type " . $imageFileType . "<br>";
                    }
                }
            } else {
                $imgErr .= " Sorry, only JPG, JPEG & PNG files are allowed";
                $uploadOk = 0;
            }
        }
    }

} else{
    header('Location: login.php');
}
?>