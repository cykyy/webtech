<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>LAB 3 Image Upload Form</title>
	<style>
        body{
            background: #eeeaea;
          margin: auto;
          width: 40%;
            
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
$imgErr = "";
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image_to_up"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  $mime_type_arr = array('jpg', 'png', 'jpeg');
  if (in_array($imageFileType, $mime_type_arr)) {
  	// code...
      echo $_FILES["image_to_up"]["size"];
  	if ($_FILES["image_to_up"]["size"] > 4000000) {
	  $imgErr .= " Sorry, your file is larger than 4MB";
	  $uploadOk = 0;
	} else {
		// Check if file already exists
		if (file_exists($target_file)) {
		  $imgErr .= " Sorry, image already exists.";
		  $uploadOk = 0;
		} else{
			if (move_uploaded_file($_FILES["image_to_up"]["tmp_name"], $target_file)) {
			    echo "<span style='color:green;'>"."The image ". htmlspecialchars( basename( $_FILES["image_to_up"]["name"])). " has been uploaded.</span>";
			  } else {
			    $imgErr .= "Sorry, there was an error uploading your file.";
			  }
			echo "<br>abs path ".$target_file;
			echo "<br> Image file type " . $imageFileType . "<br>";
		}
	}
  } else {
  	$imgErr .= " Sorry, only JPG, JPEG & PNG files are allowed";
	$uploadOk = 0;
  }
}
?>

<div class="make-it-center">
<h2>Profile Picture</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">  
  <input type="file" id="image_to_up" name="image_to_up"><br>
  <span class="error"> <?php echo $imgErr;?></span> <br><br>

  <input type="submit" value="Upload Image" name="submit">
  
</form>
</div>

</body>
</html>