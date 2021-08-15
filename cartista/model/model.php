<?php 

require_once 'db_connect.php';

function registerUser($data){
    if (!isset($data['acc_group'])){
        $_acc_group = 'Subscriber';
    } else{
        $_acc_group = $data['acc_group'];
    }
	$conn = db_conn();
    $selectQuery = "INSERT into user_info (Name, Email, Username, Password, Gender, acc_group, dob, status, ppic_abs_path)
VALUES (:Name, :Email, :Username, :Password, :Gender, :acc_group, :dob, :status, :ppic_abs_path)";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
        	':Name' => $data['name'],
        	':Email' => $data['email'],
        	':Username' => $data['username'],
        	':Password' => $data['password'],
        	':Gender' => $data['gender'],
        	':acc_group' => $_acc_group,
        	':dob' => $data['dob'],
        	':status' => 'Active',
        	':ppic_abs_path' => $data['ppic_abs_path']
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}

function createTrackerDB($uri, $username, $orderQty){
    $conn = db_conn();
    $selectQuery = "INSERT into trackers (URI, Username, OrderQty)
VALUES (:uri, :username, :orderQty)";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
            ':uri' => $uri,
            ':username' => $username,
            ':orderQty' => $orderQty
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}

function getPaymentInfo($username){
    $conn = db_conn();
    $selectQuery = "SELECT * FROM user_payment_info where Username = ?";
    try {
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([$username]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function createPaymentInfo($username, $data){
    $conn = db_conn();
    $selectQuery = "INSERT into user_payment_info (Username, card_name, card_number, card_cvv, expiration_month, expiration_year, address, post_code)
VALUES (:Username, :card_name, :card_number, :card_cvv, :expiration_month, :expiration_year, :address, :post_code)";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
            ':Username' => $username,
            ':card_name' => $data['card_name'],
            ':card_number' => $data['card_number'],
            ':card_cvv' => $data['card_cvv'],
            ':expiration_month' => $data['exp_month'],
            ':expiration_year' => $data['exp_year'],
            ':address' => $data['address'],
            ':post_code' => $data['post_code']
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}

function updateUserPaymentInfo($username, $data){
    $conn = db_conn();
    $selectQuery = "UPDATE user_payment_info set card_name = ?, card_number = ?, card_cvv = ?, expiration_month = ?, expiration_year = ?, address = ?, post_code = ? where Username = ?";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
            $data['card_name'],
            $data['card_number'],
            $data['card_cvv'],
            $data['exp_month'],
            $data['exp_year'],
            $data['address'],
            $data['post_code'],
            $username
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}

function getUser($username){
    $conn = db_conn();
    $selectQuery = "SELECT * FROM user_info where Username = ?";
    try {
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([$username]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

function getAllUser(){
    $conn = db_conn();
    $selectQuery = "SELECT * FROM user_info";
    try {
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $row;
}

function getAllTrackersFromDB(){
    $conn = db_conn();
    $selectQuery = "SELECT * FROM trackers";
    try {
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $row;
}

function getUserByEmail($email){
    $conn = db_conn();
    $selectQuery = "SELECT * FROM user_info where Email = ?";

    try {
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([$email]);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row;
}


function updateUser($username, $data){
    $conn = db_conn();
    $selectQuery = "UPDATE user_info set Name = ?, Email = ?, Gender = ?, dob = ? where Username = ?";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
            $data['Name'], $data['Email'], $data['Gender'], $data['dob'], $username
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}

// for ajax request and updating any account from admin & supoort account
function updateAnyUser($username, $data){
    $conn = db_conn();
    $selectQuery = "UPDATE user_info set Name = ?, Email = ?, Gender = ?, dob = ?, status = ?, acc_group = ? where Username = ?";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
            $data['Name'], $data['Email'], $data['Gender'], $data['dob'], $data['status'], $data['acc_group'], $username
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}

function updatePassword($username, $newPassword){
    $conn = db_conn();
    $selectQuery = "UPDATE user_info set Password = ? where Username = ?";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
            $newPassword, $username
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}

function updateProfilePictureAbsPath($username, $absPath){
    $conn = db_conn();
    $selectQuery = "UPDATE user_info set ppic_abs_path = ? where Username = ?";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
            $absPath, $username
        ]);
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    $conn = null;
    return true;
}