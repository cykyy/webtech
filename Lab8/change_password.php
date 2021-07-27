<?php
require_once 'controller/updatePassword.php';
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';

?>

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


    </style>
    <script>
        function checkTextInput(){
            let currPass = document.forms["cng_pws_form"]["current_pass"].value;
            let newPass = document.forms["cng_pws_form"]["new_password"].value;
            let rePass = document.forms["cng_pws_form"]["retype_password"].value;
            document.getElementById("sub_btn").disabled = !(currPass !== "" && newPass !== "" && rePass !== "");
            if (rePass !== "") {
                if (newPass !== rePass) {
                    document.getElementById("result").innerHTML = "New password and Retype password does not matches!";
                    document.getElementById("result").style.color = 'red';
                    document.getElementById("sub_btn").disabled = true;
                } else {
                    document.getElementById("result").innerHTML = '';
                    document.getElementById("sub_btn").disabled = false;
                }
            }

        }
    </script>
</head>
<body>

<br>
<div class="donor-info make-it-center">
<div class="container" style="width:500px;">
    <h2>Change Password</h2>
    <br>
    <form method="post" name="cng_pws_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Current Password: <input type="password" onkeyup="checkTextInput()" name="current_pass">
        <span class="error">* <?php echo $curPassErr;?></span>
        <br><br>
        New Password: <input type="password" onkeyup="checkTextInput()" name="new_password">
        <span class="error">* <?php echo $newPassErr;?></span>
        <br>
        Retype New Password: <input type="password" onkeyup="checkTextInput()" name="retype_password">
        <span class="error">* <?php echo $retypePassErr;?></span>
        <div id="result"></div>
        <br><br>

        <input type="submit" id="sub_btn" name="submit" disabled value="Submit">

    </form>
</div>
</div>

<br>
</body>
</html>