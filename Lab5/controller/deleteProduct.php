<?php 

require_once '../model/model.php';

if (deleteProduct($_GET['id'])) {
    header('Location: ../showAllProducts.php');
}

 ?>