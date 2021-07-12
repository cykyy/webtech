<?php  
require_once 'controller/productInfo.php';

$products = fetchAllProducts();

    include "nav.php";

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<style>
    table {
        border-collapse: collapse;
        width: 30%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

</style>

<table>
	<thead>
		<tr>
			<th>Name</th>
			<th>Profit</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($products as $i => $product): ?>
        <?php
            if ($product['display'] == 0){
                continue;
            }
            $b_price = $product['Buying_Price'];
            $s_price = $product['Selling_Price'];
            $profit = $s_price - $b_price;
        ?>
			<tr>
				<td><a href="showProduct.php?id=<?php echo $product['ID'] ?>"><?php echo $product['Name'] ?></a></td>
				<td><?php echo $profit ?></td>
				<td><a href="editProduct.php?id=<?php echo $product['ID'] ?>">Edit</a>&nbsp<a href="deleteProductView.php?id=<?php echo $product['ID'] ?>">Delete</a></td>
			</tr>
		<?php endforeach; ?>

	</tbody>
</table>
</body>
</html>