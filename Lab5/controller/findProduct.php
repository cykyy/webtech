<?php

require_once '../model/model.php';

if (isset($_POST['findproduct'])) {
	
		echo $_POST['p_name'];

    try {

        $allSearchedProduct = searchProduct($_POST['p_name']);
    	require_once '../showSearchedProduct.php';

    } catch (Exception $ex) {
    	echo $ex->getMessage();
    }
}

