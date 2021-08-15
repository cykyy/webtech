<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <script src="assets/js/actions.js"></script>
</head>
<body>

<?php require_once 'controller/editAnyAccountIncludes.php'?>
<br>
<fieldset class="text-center">
    <legend> <b>Profile:</b></legend>
    <div>
        <form method="post" name="edit_any_acc" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <label for="acc_username">Select an account:</label>
            <select name="acc_username" id="acc_username" onchange="populate_user_info()">
                <option selected></option>
            <?php
            foreach ($arra as $item) { //foreach element in $arr
                if ($item['acc_group'] !== 'Admin' && $item['acc_group'] !== 'Support') {
                    echo "<option>". $item['Username'] ."</option>";
                }
            }

            ?>
            </select> <br><br>
            <div id="result"></div>
            New Name: <input type="text" name="name" id="name" value="">
            <br><br>
            New Email: <input type="text" name="email" id="email" value="">
            <br><br>
            <span>Gender: </span>
            <input type="radio" id="male" name="gender" value="male" >
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>
            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
            <br><br>
            <span>Date of Birth: </span>
            <input type="date" name="dob" id="dob"> <br><br>
            <br>

            <label for="acc_grp">Change Account Type:</label>
            <select name="acc_grp" id="acc_grp">
                <option value="">Select</option>
                <option value="Support">Support</option>
                <option value="Subscriber">Subscriber</option>
            </select> <br><br>

            <label for="acc_status">Change Account Status:</label>
            <select name="acc_status" id="acc_status">
                <option value="">Select</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select> <br><br>

            <input type="submit" name="submit" value="Submit">
        </form>

    </div>
</fieldset>
</body>
</html>