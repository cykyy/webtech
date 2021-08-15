<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>

<?php
require_once 'controller/updateProfile.php'
?>

        <div class="container">
            <form method="post" class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                Name: <input type="text" name="name" value="<?php echo $name;?>">
                <br><br>
                Email: <input type="text" name="email" value="<?php echo $email;?>">
                <br><br>
                <span>Gender: </span>
                <input type="radio" id="male" name="gender" value="male" <?php if ($gender === 'male'){ echo 'checked';}?> >
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female" <?php if ($gender === 'female'){ echo 'checked';}?> >
                <label for="female">Female</label>
                <input type="radio" id="other" name="gender" value="other" <?php if ($gender === 'other'){ echo 'checked';}?> >
                <label for="other">Other</label>
                <br><br>
                <span>Date of Birth: </span>
                <input type="date" name="dob" value="<?php echo $dob;?>"> <br><br>
                <br>
                <button type="submit" name="submit" value="Submit">Submit </button>
            </form>

</div>

</body>
</html>