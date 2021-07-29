<?php
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
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
<div class="container">
    <h2 class="text-center">Change Password</h2>
    <br>
    <form method="post" class="form" name="cng_pws_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Current Password: <input type="password" onkeyup="checkTextInput()" name="current_pass">
        <span class="error">* </span>
        <br><br>
        New Password: <input type="password" onkeyup="checkTextInput()" name="new_password">
        <span class="error">* </span>
        <br>
        Retype New Password: <input type="password" onkeyup="checkTextInput()" name="retype_password">
        <span class="error">* </span>
        <div id="result"></div>
        <br><br>

        <button type="submit" id="sub_btn" name="submit" disabled value="Submit"> Submit </button>

    </form>
</div>

<br>
</body>
</html>