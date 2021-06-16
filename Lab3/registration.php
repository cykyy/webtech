<?php
// define variables and set to empty values
$nameErr = $emailErr = $degreeErr = $genderErr = $userErr = $passErr = $confrmPassErr = "";
$name = $email = $gender = $username = $password = $cnfrmPass = "";
$dob = $successmsg = "";
$dobdd = $dobmm = $dobyy = ""; 
$errCount = 0;  
 $message = '';  
 $error = '';  
 if(isset($_POST["submit"]))  {  


    if (empty($_POST["name"])) {
    $nameErr = "Name is required";
    $errCount = $errCount + 1;     
     } else {
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

    if (empty($_POST["email"])) {
    $emailErr = "Email is required";
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


     if (empty($_POST["username"])) {
         $userErr = "Username is required";
         $errCount = $errCount + 1;     
       } else {
         $username = $_POST["username"];

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
          $cnfrmPass = check_input($_POST["cnfrmPass"]);

          if (empty($cnfrmPass)) {
               // code...
               $confrmPassErr = "Confirm password is required";
               $errCount = $errCount + 1;  
          } else {
               if ($password != $cnfrmPass) {
                    // code...
                    $confrmPassErr = "Confirm password is dosen't match with paassword!";
                    $errCount = $errCount + 1;
               }
          }

     
          if (strlen($password) < 8 ) {
               // code...
               $passErr = "Minimum 8 characters required";
               $errCount = $errCount + 1;    
              }

         if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?!.* )(?=.*[\d%$#@]).+$/", $password)) {
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

          }



      if(empty($_POST["name"]))  
      {  
           $error = "<label class='text-danger'>Enter Name</label>";  
      }
      else if(empty($_POST["email"]))  
      {  
           $error = "<label class='text-danger'>Enter an e-mail</label>";  
      }  
      else if(empty($_POST["un"]))  
      {  
           $error = "<label class='text-danger'>Enter a username</label>";  
      }  
      else if(empty($_POST["pass"]))  
      {  
           $error = "<label class='text-danger'>Enter a password</label>";  
      }
      else if(empty($_POST["Cpass"]))  
      {  
           $error = "<label class='text-danger'>Confirm password field cannot be empty</label>";  
      } 
      else if(empty($_POST["gender"]))  
      {  
           $error = "<label class='text-danger'>Gender cannot be empty</label>";  
      } 
       
      else  
      {  
           if(file_exists('data.json'))  
           {  
                $current_data = file_get_contents('data.json');  
                $array_data = json_decode($current_data, true);  
                $extra = array(  
                     'name'               =>     $_POST['name'],  
                     'e-mail'          =>     $_POST["email"],  
                     'username'     =>     $_POST["un"],  
                     'gender'     =>     $_POST["gender"],  
                     'dob'     =>     $_POST["dob"]  
                );  
                $array_data[] = $extra;  
                $final_data = json_encode($array_data);  
                if(file_put_contents('data.json', $final_data))  
                {  
                     $message = "<label class='text-success'>File Appended Success fully</p>";  
                }  
           }  
           else  
           {  
                $error = 'JSON File not exits';  
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
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title></title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <style>

        .make-it-center{
          margin: auto;
          width: 75%;
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
      </head>  
      <body>  
           <br />  
           <div class="container" style="width:500px;">  
                <h3 align="">Append Data to JSON File</h3><br />                 
                <form method="post">  
                     <?php   
                     if(isset($error))  
                     {  
                          echo $error;  
                     }  
                     ?>  
                     <br />  
                     <label>Name</label>  <span class="error">* <?php echo $nameErr;?></span>
                     <input type="text" name="name" class="form-control" /> <br/>
                     <label>E-mail</label> <span class="error">* <?php echo $emailErr;?></span>
                     <input type="text" name = "email" class="form-control" /><br />
                     <label>User Name</label>  <span class="error">* <?php echo $userErr;?></span>
                     <input type="text" name = "username" class="form-control" /><br />
                     <label>Password</label>  <span class="error">* <?php echo $passErr;?></span>
                     <input type="password" name = "password" class="form-control" /><br />
                     <label>Confirm Password</label>  <span class="error">* <?php echo $confrmPassErr;?></span>
                     <input type="password" name = "cnfrmPass" class="form-control" /><br />

                    <fieldset>
                    <legend>Gender</legend>  <span class="error">* <?php echo $genderErr;?></span>
                    <input type="radio" id="male" name="gender" value="male">
                     <label for="male">Male</label>                     
                     <input type="radio" id="female" name="gender" value="female">
                     <label for="female">Female</label>
                     <input type="radio" id="other" name="gender" value="other">
                     <label for="other">Other</label><br>

                     <legend>Date of Birth:</legend>  <span class="error">* <?php echo $dobErr;?></span>
                     <input type="date" name="dob"> <br><br>
                    </fieldset> 
                     
                     <input type="submit" name="submit" value="Append" class="btn btn-info" /><br />                      
                     <?php  
                     if(isset($message))  
                     {  
                          echo $message;  
                     }  
                     ?>  
                </form>  
           </div>  
           <br />  
      </body>  
 </html>  