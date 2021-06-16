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
        .form{

        }

        .make-it-center{
          margin: auto;
          width: 75%;
        }

        .error{
        	color: red;
        }

        .lefterr{
            margin-left: -10%;
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
$curPassErr = $newPassErr = $retypePassErr = "";
$username = $password = ""; 
$currPass = $newPass = $retypePass = "";
$errCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

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

        if (empty($retypePass)){
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
      
      if (strlen($currPass) <8 ) {
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
        } else{
          echo "Successfully changed password!";
        }
      }

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