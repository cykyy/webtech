<?php
session_start();
include 'templates/nav2.php';
?>
<?php include 'templates/base2.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Profile Picture</title>
</head>
<body>

<?php
require_once 'controller/profilePicUpdateCodes.php'
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
</html>