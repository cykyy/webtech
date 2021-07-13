<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
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
require_once 'controller/updatePassword.php';
include 'templates/sidenav.php';
include 'templates/nav.php';

?>



<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Current Password: <input type="password" name="current_pass">
    <span class="error">* <?php echo $curPassErr;?></span>
    <br><br>
    New Password: <input type="password" name="new_password">
    <span class="error">* <?php echo $newPassErr;?></span>
    <br>
    Retype New Password: <input type="password" name="retype_password">
    <span class="error">* <?php echo $retypePassErr;?></span>
    <br><br>

    <input type="submit" name="submit" value="Submit">

</form>



<br>
</body>
<?php include 'templates/footer.php';?>
</html>