<?php
session_start();
include 'templates/nav2.php';
?>
<?php include 'templates/base2.php';
?>
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
            color: white;

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
require_once 'model/model.php';
require_once 'controller/getUser.php';
// include 'templates/nav.php';
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = "";
$errCount = 0;

if (isset($_SESSION['uname'])) {
    $name = $email = $gender = $dob = '';
    $err = '';

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
            $user_found = true;
            $user_edited = false;
            $dataDB = null;
            $userRes = getUserAccount($_SESSION['uname']);
            if ($userRes) {
                $user_found = true;
                if ($_SESSION['uname'] === $userRes['Username']) {
                    $user_found = true;
                    $dataDB['name'] = $name;
                    $dataDB['email'] = $email;
                    $dataDB['gender'] = $gender;
                    $dataDB['dob'] = $dob;
                    $user_edited = true;
                }
                if ($user_edited){
                    if(updateUser($_SESSION['uname'], $dataDB)){
                        echo "<span style='color: green'>User Edited Successfully!</span>";
                    }
                }
            }
        }


    } else {
        $userRes = getUserAccount($_SESSION['uname']);
        if ($_SESSION['uname'] === $userRes['Username']){
            // do stuff
            $name = $userRes['Name'];
            $email = $userRes['Email'];
            $gender = $userRes['Gender'];
            $dob = $userRes['dob'];
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
<script>

    function checkTextInput(){
        let name = document.forms["update_profile"]["name"].value;
        let email = document.forms["update_profile"]["email"].value;
        let gender = document.forms["update_profile"]["gender"].value;
        let dob = document.forms["update_profile"]["dob"].value;
        document.getElementById("sub_btn").disabled = !(name !== "" && email !== "" && gender !== "" && dob !== "");
    }

    function WordCount(str) {
        return str.split(" ").length;
    }

    function nameChecker(){
        let name = document.forms["update_profile"]["name"].value;
        let wcount = WordCount(name);
        checkTextInput()
        if (wcount < 2 ) {
            // code...
            // alert("Minimum 2 words required");
            document.getElementById("sub_btn").disabled = true;
            document.getElementById("result").innerHTML = "Minimum 2 words required";
        } else {
            document.getElementById("result").innerHTML = '';
        }

    }

</script>
<br>
<fieldset>
    <legend> <b>Profile:</b></legend>
        <div class="donor-info">
            <form method="post" name="update_profile" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                Name: <input type="text" onkeyup="nameChecker()" name="name" value="<?php echo $name;?>">
                <div id="result"></div>
                <br><br>

                Email: <input type="text" onkeyup="checkTextInput()" name="email" value="<?php echo $email;?>">
                <br><br>

                <span>Gender: </span>
                <input type="radio" id="male" name="gender" oninput="checkTextInput()" value="male" <?php if ($gender === 'male'){ echo 'checked';}?> >
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" oninput="checkTextInput()" value="female" <?php if ($gender === 'female'){ echo 'checked';}?> >
                <label for="female">Female</label>
                <input type="radio" id="other" name="gender" oninput="checkTextInput()" value="other" <?php if ($gender === 'other'){ echo 'checked';}?> >
                <label for="other">Other</label>
                <br><br>
                <span>Date of Birth: </span>
                <input type="date" name="dob" oninput="checkTextInput()" value="<?php echo $dob;?>"> <br><br>
                <br>
                <input type="submit" id="sub_btn" name="submit" value="Submit">
            </form>

</div>
</fieldset>
</body>
</html>