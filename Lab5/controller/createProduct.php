<?php  
require_once '../model/model.php';


if (isset($_POST['createProduct'])) {
	$data['name'] = $_POST['name'];
	$data['b_price'] = $_POST['b_price'];
	$data['s_price'] = $_POST['s_price'];

	echo 'printing?';

  if (addProduct($data)) {
  	echo 'Product successfully added!! <a href="../showAllProducts.php">Go Back</a> ';
  }
} else {
	echo 'You are not allowed to access this page.';
}

?>