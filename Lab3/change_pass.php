<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lab 3 Change Pasasword Form</title>
	<style>
        body{
            background: #eeeaea;
          margin: auto;
          width: 20%;
            
          border: 1px solid #3e3c3c;
          padding: 20px;

        }

        .make-it-center{
          margin: auto;
          width: 75%;
        }

        .error{
        	color: red;
        }

        .required:after {
          content:"*";
          color: red;
        }
    </style>
</head>
<body>

<?php
// define variables and set to empty values
$curPassErr = $newPassErr = $retypePassErr = $userErr = "";
$username = "";
$currPass = $newPass = $retypePass = "";
$errCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["username"])) {
        $userErr = "Username is required to change password";
        $errCount = $errCount + 1;
    } else {
        $username = $_POST["username"];

        if (empty($_POST["current_pass"])) {
            $curPassErr = "Current password is required to change password";
            $errCount = $errCount + 1;
        } else {
            $currPass = check_input($_POST["current_pass"]);

            $newPass = check_input($_POST["new_password"]);
            $retypePass = check_input($_POST["retype_password"]);

            if (empty($newPass)) {
                // code...
                $newPassErr = "New password is required to change password";
                $errCount = $errCount + 1;
            }

            if (empty($retypePass)) {
                $retypePassErr = "You must retype your new password!";
                $errCount = $errCount + 1;
            }

            if ($newPass === $currPass) {
                // validation for the new password
                $newPassErr .= " New Password should not be same as the Current Password";
                $errCount = $errCount + 1;
            } else {

            }

            if ($newPass !== $retypePass) {
                // code...
                $retypePassErr .= " Retype password don't match with new password!";
                $errCount = $errCount + 1;
            }

            if (strlen($currPass) < 8) {
                // code...
                $curPassErr .= " Current password cannot be less than 8 characters. Error!";
                $errCount = $errCount + 1;
            }

            // Change Password Code
            if ($errCount <= 0) {
                if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[\d%$#@]).+$/", $newPass)) {
                    /*
                      ^ starts the string
                    (?=.*[a-z]) Atleast a lower case letter
                    (?=.*[A-Z]) Atleast an upper case letter
                    (?!.* ) no space
                    (?=.*\d%$#@) Atleast a digit and atleast one of the specified characters.
                    .{8,16} between 8 to 16 characters
                      */
                    $newPassErr = "New Password must contain atleast a digit, a lower case and an upper case letter, atleast one of the [%$#@] and no space.";
                    $errCount = $errCount + 1;
                } else {
                    //echo "Successfully changed password!";
                }
            }

        }
    }

    if ($errCount < 1){

        $strJsonFileContents = file_get_contents("data.json");
        // var_dump($strJsonFileContents);

        $arra = json_decode($strJsonFileContents);
        // var_dump($arra);
        $user_found = false;
        $pass_change = false;
        foreach($arra as $item) { //foreach element in $arr
            //echo "<br>";
            //echo "username: ".$item->username;
            //echo "<br>";
            //echo "password: ".$item->password;
            //echo "<br>";

            if ($username === $item->username){
                $user_found = true;
                // match. now check pw
                if ($currPass === $item->password){
                    // password also matched! now change password...
                    echo "<br>";
                    echo "Thanks for approving the password change Mr. $item->name! Request processing...";
                    // change password code here...
                    $item->password = $newPass;
                    echo "<br>";
                    $pass_change = true;

                }else{
                    $curPassErr .= "Password Wrong!";
                }
            }
        }

        if ($pass_change){
            $final_data = json_encode($arra);
            if(file_put_contents('data.json', $final_data)){
                echo "<span style='color: green'>Password Changed Successfully!</span>";
            }
        }

        if (!$user_found){
            echo $userErr .= "No account found!";
        }


        //exit;

    }

}


  function check_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<div class="donor-info make-it-center">
<h2>Chanage Password</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Username: <input type="text" name="username" value="<?php echo $username;?>">
    <span class="error">* <?php echo $userErr;?></span>
    <br>
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

</div>


</body>
</html>