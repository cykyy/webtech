<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Lab 3 Login Form</title>
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
$userErr = $passErr = "";
$username = $password = ""; 
$errCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (empty($_POST["username"])) {
	    $userErr = "Username is required";
	    $errCount = $errCount + 1;	
	  } else {
	    $username = check_input($_POST["username"]);

	    if (strlen($username) <2 ) {
	    	// code...
	    	$userErr = "Minimum 2 characters required";
	    	$errCount = $errCount + 1;	
	    }

	    // check if name only contains letters and whitespace
	    if (!preg_match("/^[a-zA-Z_\-.]*$/", $username)) {
	    	$userErr = "Username can contain alpha numeric characters, period, dash or underscore only!";
	    	$username ="";
	    	$errCount = $errCount + 1;	
	    }

	  }

  if (empty($_POST["password"])) {
    $passErr = "Password is required";
    $errCount = $errCount + 1;	
  } else {
    $password = check_input($_POST["password"]);
  }

  	if (strlen($password) <8 ) {
	    	// code...
	    	$passErr = "Minimum 8 characters required";
	    	$errCount = $errCount + 1;	
	    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[%$#@]).+$/", $password)) {
    	/*
    	^ starts the string
		(?=.*[a-z]) Atleast a lower case letter
		(?=.*[A-Z]) Atleast an upper case letter
		(?!.* ) no space
		(?=.*\d%$#@) Atleast a digit and atleast one of the specified characters.
		.{8,16} between 8 to 16 characters
    	*/
	    	$passErr .= " Password must contain atleast a digit, a lower case and an upper case letter, atleast one of the [%$#@] and no space.";
	    	$password ="";
	    	$errCount = $errCount + 1;	
	    }

    if ($errCount < 1){

        $strJsonFileContents = file_get_contents("data.json");
        // var_dump($strJsonFileContents);

        $arra = json_decode($strJsonFileContents);
        // var_dump($arra);
        $user_found = false;
        foreach($arra as $item) { //foreach element in $arr
            //echo "<br>";
            //echo "username: ".$item->username;
            //echo "<br>";
            //echo "password: ".$item->password;
            //echo "<br>";

            if ($username === $item->username){
                $user_found = true;
                // match. now check pw
                if ($password === $item->password){
                    echo "Thanks for logging Mr. $item->name ... success!!";
                    header('Refresh: 3; Location: dashboard.php');
                    exit;
                }else{
                    $passErr .= "Password Wrong!";
                }
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
<h2>Login</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Username: <input type="text" name="username" value="<?php echo $username;?>">
  <span class="error">* <?php echo $userErr;?></span>
  <br><br>
  Password: <input type="password" name="password" value="<?php echo $password;?>">
  <span class="error">* <?php echo $passErr;?></span>
  <br><br>
  <input type="checkbox" id="rmbm" name="rmbm" value="True">
  <label for="rmbm"> Remember Me</label><br><br>

<input type="submit" name="submit" value="Submit">  
<span>Forgot Password?</span>

</form>

</div>


</body>
</html>