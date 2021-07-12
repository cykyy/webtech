<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
    <?php 
        include "nav.php";
     ?>
   

 <form action="controller/createProduct.php" method="POST">
  <label for="name">Name:</label><br>
  <input type="text" id="name" name="name"><br>
  <label for="b_price">Buying Price:</label><br>
  <input type="text" id="b_price" name="b_price"><br>
  <label for="s_price">Selling Price:</label><br>
  <input type="text" id="s_price" name="s_price"><br>

  <input type="submit" name="createProduct" value="Create">
  <input type="reset"> 
</form> 

</body>
</html>

