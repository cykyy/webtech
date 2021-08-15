<?php
include 'templates/nav2.php';
include 'templates/base2.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="css/extras.css">
</head>
<body>

<?php
// define variables and set to empty values
$userErr = $passErr = "";
$username = $password = ""; 
$errCount = 0;

$email = "";
$emailErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "Email is required for this action!";
        $errCount = $errCount + 1;
    } else {
        $email = check_input($_POST["email"]);
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
            $email="";
            $errCount = $errCount + 1;
        }
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

            if ($email === $item->email){
                $user_found = true;
                // match. now check pw
                if ($item->password){
                    echo "<br><div style='color: green; text-align: center'>You are $item->name </br></div>";
                    echo "<div style='color: green; text-align: center'> Your Password is $item->password </br></div>";
                }else{
                    $passErr .= "Password Not Found!!";
                }
            }
        }
        if (!$user_found){
            echo $userErr .= "No account found!";
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


<div class="container"><h2 class="text-center" >FORGOT PASSWORD</h2>
<form method="post" class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  Enter Email: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>

    <button type="submit" name="submit" value="Submit">Submit </button>

</form>
</div>
</body>

</html>