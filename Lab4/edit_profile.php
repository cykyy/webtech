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
session_start();
include 'templates/nav.php';
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    $name = $email = $gender = $dob = '';
    $err = '';
    include 'templates/sidenav.php';

    echo "<h1>Edit Profile </h1>";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //$name = $email = $gender = $dob = '';
        $errCount = 0;
        if (!empty($_POST["name"])) {
            $name = check_input($_POST["name"]);
            $wcount = str_word_count($name);
            if ($wcount < 2 ) {
                // code...
                $nameErr = "Minimum 2 words required";
                $errCount = $errCount + 1;
            }

            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z]/", $name)) {
                $nameErr = "Name must start with a letter!";
                $name ="";
                $errCount = $errCount + 1;
            }

            if (!preg_match("/^[a-zA-Z_\-. ]*$/",$name)) {
                $nameErr = "Only letters, period and white space allowed";
                $name="";
                $errCount = $errCount + 1;
            }
        }

        if (!empty($_POST["email"])) {
            $email = check_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $email="";
                $errCount = $errCount + 1;
            }
        }

        if (!empty($_POST["gender"])) {
            $gender = check_input($_POST["gender"]);
        }

        if (!empty($_POST["dob"])) {
            $dob = $_POST["dob"];
        }

        if($errCount > 0) {
            echo "<span class='error'>One or more error occurred!</span>";
        } else {
            if (file_exists('data.json')) {
                $strJsonFileContents = file_get_contents("data.json");
                $arra = json_decode($strJsonFileContents);
                // var_dump($arra);
                $user_found = false;
                $user_edited = false;
                foreach ($arra as $item) { //foreach element in $arr
                    if ($_SESSION['uname'] === $item->username) {
                        $user_found = true;
                        if (!($name === $item->name)) {
                            $item->name = $name;
                            $user_edited = true;
                        }
                        if (!($email === $item->email)) {
                            $item->email = $email;
                            $user_edited = true;
                        }
                        if (!($gender === $item->gender)) {
                            $item->gender = $gender;
                            $user_edited = true;
                        }
                        if (!($dob === $item->dob)) {
                            $item->dob = $dob;
                            $user_edited = true;
                        }
                    }
                }
                if ($user_edited){
                    $final_data = json_encode($arra);
                    if(file_put_contents('data.json', $final_data)){
                        echo "<span style='color: green'>User Edited Successfully!</span>";
                    }
                }
            }
        }


    } else {

        $strJsonFileContents = file_get_contents("data.json");
        // var_dump($strJsonFileContents);
        $arra = json_decode($strJsonFileContents);
        // var_dump($arra);

        foreach ($arra as $item) { //foreach element in $arr
            if ($_SESSION['uname'] === $item->username) {
                // do stuff
                $name = $item->name;
                $email = $item->email;
                $gender = $item->gender;
                $dob = $item->dob;
            }
        }
    }

} else{
    header('Location: login.php');
}
function check_input($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
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