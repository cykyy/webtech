<?php 

require_once 'controller/productInfo.php';
$product = fetchProduct($_GET['id']);

include "nav.php";

 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

 <form action="controller/updateProduct.php" method="POST">
  <label for="name">Name:</label><br>
  <input value="<?php echo $product['Name'] ?>" type="text" id="name" name="name"><br>
  <label for="b_price">Buying Price:</label><br>
  <input value="<?php echo $product['Buying_Price'] ?>" type="text" id="b_price" name="b_price"><br>
  <label for="s_price">Selling Price:</label><br>
  <input value="<?php echo $product['Selling_Price'] ?>" type="text" id="s_price" name="s_price"><br>

  <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">

  <input type="submit" name="updateProduct" value="Update">
  <input type="reset"> 
</form> 

</body>
</html>

