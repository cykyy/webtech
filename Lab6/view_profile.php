<!DOCTYPE html>
<html>
<head>
    <title>View Profile</title>
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
session_start();
include 'templates/nav.php';
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    include 'templates/sidenav.php';

    echo "<h1> Welcome Mr. ".$_SESSION['uname']."</h1>";
    echo '
    <fieldset>
    <legend> <b>Profile:</b></legend>
    
    ';

    // db show goes here
    require_once 'controller/getUser.php';
    $arra = getUserAccount($_SESSION['uname']);
    if ($_SESSION['uname'] === $arra['Username']){
        echo '<img src="' . $arra['ppic_abs_path'] . '"width="150" height="150"> <br><a href="profile_picture.php">Change</a> <br>';
        echo '<br><div> Name: '. $arra['Name'] . '</div> <br>';
        echo '<div> Email: '. $arra['Email'] . '</div> <br>';
        echo '<div> Gender: '. $arra['Gender'] . '</div> <br>';
        echo '<div> Date of Birth: '. $arra['dob'] . '</div> <br>';
    }
    echo '<b><a href="edit_profile.php"> Edit Profile ' . '</a></b> <br><br>';
    echo '</fieldset>';

} else{
    header('Location: login.php');
}

?>

<br>
<br>
</body>
<?php include 'templates/footer.php';?>
</html>