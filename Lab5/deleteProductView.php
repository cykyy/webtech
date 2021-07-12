<?php
include "nav.php";
require_once 'controller/productInfo.php';

$product = fetchProduct($_GET['id']);
echo '<p><b>Delete Product</b></p>';
echo '<p>Name: ' . $product['Name'] . '</p>';
echo '<p>Buying Price: ' . $product['Name'] . '</p>';
echo '<p>Selling: ' . $product['Name'] . '</p>';

if ($product['display']){
    $dis = 'yes';
} else{
    $dis = 'no';
}

echo '<p>Displayable: ' . $dis . '</p>';

?>
<td>
<a href="controller/deleteProduct.php?id=<?php echo $product['ID'] ?>" onclick="return confirm('Are you sure want to delete this ?')">Delete</a></td>

