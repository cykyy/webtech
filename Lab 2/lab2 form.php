<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$nameErr = $emailErr = $degreeErr = $genderErr = "";
$name = $email = $gender = "";
$dob = $successmsg = "";
$dobdd = $dobmm = $dobyy = ""; 
$errCount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$ssc = $_POST["ssc"];
$hsc = $_POST["hsc"];
$bsc = $_POST["bsc"];
$msc = $_POST["msc"];
$degArr = array();

if (isset($ssc)) {
	// code...
	array_push($degArr, $ssc);
}
if (isset($hsc)) {
	array_push($degArr, $hsc);
}
if (isset($bsc)) {
	array_push($degArr, $bsc);
}
if (isset($msc)) {
	array_push($degArr, $msc);
}

if (sizeof($degArr) < 2) {
	$degreeErr = "At least two degree required!";
	$errCount = $errCount + 1;	
}


  if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $errCount = $errCount + 1;	
  } else {
    $name = test_input($_POST["name"]);
    $wcount = str_word_count($name);
    if ($wcount <2 ) {
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
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
    $errCount = $errCount + 1;	
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
      $email="";
      $errCount = $errCount + 1;	
    }
  }

  if (empty($_POST["dobdd"]) && empty($_POST["dobmm"]) && empty($_POST["dobyy"])) {
    $dobErr = "Dob is required";
    $errCount = $errCount + 1;	
  } else {
    $dobdd = test_input($_POST["dobdd"]);
    $dobmm = test_input($_POST["dobmm"]);
    $dobyy = test_input($_POST["dobyy"]);

    $dob = $dobdd . "/" . $dobdd . "/" . $dobyy;

    if ($dobdd < 1 || $dobdd > 31) {
    	// code...
    	$dobErr = "DOB date incorrect! ";
    	$errCount = $errCount + 1;	
    }

    if ($dobmm < 1 || $dobmm > 12) {
    	// code...
    	$dobErr .= "DOB month incorrect! ";
    	$errCount = $errCount + 1;	
    } 

    if ($dobyy < 1953 || $dobyy > 1998) {
    	// code...
    	$dobErr .= "DOB year incorrect!";
    	$errCount = $errCount + 1;	
    }
    
  }


  if (empty($_POST['bgrp'])) {
  	$bgrpErr = "Must select a blood group";
  	$errCount = $errCount + 1;	
  } else {
  	$bgrp = test_input($_POST["bgrp"]);
  }


  if (empty($_POST["gender"])) {
    $genderErr = "Gender is required";
    $errCount = $errCount + 1;	
  } else {
    $gender = test_input($_POST["gender"]);
  }

  if ($errCount < 1) {
	$successmsg = "Successfully submitted the form without any error.";
}


if ($successmsg) {
	echo $successmsg;
} else {
	echo '<span class="error">One or more error occurred!</span>';
}

}


function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  Name: <input type="text" name="name" value="<?php echo $name;?>">
  <span class="error">* <?php echo $nameErr;?></span>
  <br><br>
  E-mail: <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error">* <?php echo $emailErr;?></span>
  <br><br>


	Date Of Birth: <br>
	dd <input type="text" size="5" name="dobdd" value="<?php echo $dobdd;?>"> mm <input type="text" size="5" name="dobmm" value="<?php echo $dobmm;?>"> 
	yy <input type="text" name="dobyy" size="5" value="<?php echo $dobyy;?>">
  <span class="error">* <?php echo $dobErr;?></span>
  <br><br>


  Gender:
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">Female
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">Male
  <input type="radio" name="gender" <?php if (isset($gender) && $gender=="other") echo "checked";?> value="other">Other  
  <span class="error">* <?php echo $genderErr;?></span>
  <br><br>

  Degree:
	<input type="checkbox" id="ssc" name="ssc" value="SSC">
  <label for="ssc"> SSC</label>
  <input type="checkbox" id="hsc" name="hsc" value="HSC">
  <label for="hsc"> HSC</label>
  <input type="checkbox" id="bsc" name="bsc" value="BSc">
  <label for="bssc"> BSc</label>
  <input type="checkbox" id="vehicle3" name="msc" value="MSc">
  <label for="msc"> MSc</label>
  <span class="error"><?php echo $degreeErr;?></span>
  <br><br>


  <label for="cars">Blood Group:</label>
  <select name="bgrp" id="bgrp">
  	<option value="<?php echo $bgrp;?>" selected> <?php echo $bgrp;?></option>
    <option value="O+">O+</option>
    <option value="A+">A+</option>
    <option value="B+">B+</option>
  </select>
  <span class="error"><?php echo $bgrpErr;?></span>
  <br><br>

  <input type="submit" name="submit" value="Submit">  
</form>

<?php
echo "<br>";
echo "<h2>Your Input:</h2>";
echo $name;
echo "<br>";
echo $email;
echo "<br>";
echo $dob;
echo "<br>";
echo $gender;
echo "<br>";
echo $ssc, $hsc;
echo "<br>";
echo $bgrp;
?>

</body>
</html>