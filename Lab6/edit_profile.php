<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
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
require_once 'controller/updateUser.php';

include 'templates/nav.php';
?>

<br>
<fieldset>
    <legend> <b>Profile:</b></legend>
        <div class="donor-info">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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
                <input type="submit" name="submit" value="Submit">
            </form>

</div>
</fieldset>
</body>
<?php include 'templates/footer.php';?>
</html>