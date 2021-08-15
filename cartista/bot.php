<?php
// $html = file_get_html('http://www.google.com/');


function getRemoteHtml($URI){
    $url = $URI;
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}

function check_stock($URI){
    $DOM = new DOMDocument;
    $DOM->loadHTML(getRemoteHtml($URI));
    $resp = $DOM->getElementById('stock')->nodeValue;
    echo $resp;
    if (str_contains($resp, 'In')) {
        echo '::innnn';
        return true;
    } else {
        echo '::outttt';
        return false;
    }
}

function place_an_order($product_url, $qty){

}


$resp = check_stock('http://127.0.0.1:8000/product/2/item-2/');
echo $resp;

//create array of data to be posted
$post_data['name'] = 'Name';
$post_data['email'] = 'em@w.com';
$post_data['postal_code'] = '1000';
$post_data['address'] = 'Dhaka';

//traverse array and prepare data for posting (key1=value1)
foreach ( $post_data as $key => $value) {
    $post_items[] = $key . '=' . $value;
}

//create the final string to be posted using implode()
$post_string = implode ('&', $post_items);

//we also need to add a question mark at the beginning of the string
$post_string = '?' . $post_string;

//we are going to need the length of the data string
$data_length = strlen($post_string);

//let's open the connection
$connection = fsockopen('www.domainname.com', 80);

//sending the data
fputs($connection, "POST  /target_url.php  HTTP/1.1\r\n");
fputs($connection, "Host:  www.domainname.com \r\n");
fputs($connection,
    "Content-Type: application/x-www-form-urlencoded\r\n");
fputs($connection, "Content-Length: $data_length\r\n");
fputs($connection, "Connection: close\r\n\r\n");
fputs($connection, $post_string);

//closing the connection
fclose($connection);


?>