<!DOCTYPE html>
<html>
<head>
    <title>Update Profile Picture</title>
    <style>

        .make-it-center{
            margin: auto;
            width: 50%;
        }

        body{
            background: #eeeaea;
            margin: auto;
            width: 50%;
            border: 1px solid #3e3c3c;
            padding: 20px;

        }

        .lefterr{
            margin-left: -10%;
        }

        .required:after {
            content:"*";
            color: red;
        }
        .error{
            color: red;
        }

        /* The sidebar menu */
        .sidenav {
            height: 100%; /* Full-height: remove this if you want "auto" height */
            width: 220px; /* Set the width of the sidebar */
            position: fixed; /* Fixed Sidebar (stay in place on scroll) */
            z-index: 1; /* Stay on top */
            top: 0; /* Stay at the top */
            left: 0;
            background-color: #111; /* Black */
            overflow-x: hidden; /* Disable horizontal scroll */
            padding-top: 20px;
        }

        /* The navigation menu links */
        .sidenav a {
            padding: 6px 8px 6px 16px;
            text-decoration: none;
            font-size: 25px;
            color: #818181;
            display: block;
        }

        /* When you mouse over the navigation links, change their color */
        .sidenav a:hover {
            color: #f1f1f1;
        }

    </style>
</head>
<body>

<?php
include 'templates/sidenav.php';
session_start();
include 'templates/nav.php';
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
            $target_dir = "uploads/";
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
                        $imgErr .= " Sorry, image already exists.";
                        $uploadOk = 0;
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
<br>
<fieldset>
        <legend>Profile Picture</legend>
    <img src="<?php echo $abs_path;?>" width="150" height="150"> <br>  <br>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
            <input type="file" id="image_to_up" name="image_to_up"><br>
            <span class="error"> <?php echo $imgErr;?></span> <br>

            <input type="submit" value="Upload Image" name="submit">

        </form><br>

</fieldset><br>

</body>
<?php include 'templates/footer.php';?>
</html>