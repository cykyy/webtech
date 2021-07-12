<?php  
require_once 'controller/ProductInfo.php';

$product = fetchProduct($_GET['id']);
    include "nav.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<table>
	<tr>
		<th>Name</th>
		<th>Buying Price</th>
		<th>Selling Price</th>
	</tr>
	<tr>
		<td><a href="showProduct.php?id=<?php echo $product['ID'] ?>"><?php echo $product['Name'] ?></a></td>
		<td><?php echo $product['Buying_Price'] ?></td>
		<td><?php echo $product['Selling_Price'] ?></td>
	</tr>

</table>


</body>
</html>