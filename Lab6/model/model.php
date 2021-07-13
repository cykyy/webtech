<?php 

require_once 'db_connect.php';

function registerUser($data){
	$conn = db_conn();
    $selectQuery = "INSERT into user_info (Name, Email, Username, Password, Gender, dob, ppic_abs_path)
VALUES (:name, :email, :username, :password, :gender, :dob, :ppic_abs_path)";
    try{
        $stmt = $conn->prepare($selectQuery);
        $stmt->execute([
        	':name' => $data['name'],
        	':email' => $data['email'],
        	':username' => $data['username'],
        	':password' => $data['password'],
        	':gender' => $data['gender'],
        	':dob' => $data['dob'],
        	':ppic_abs_path' => $data['ppic_abs_path']
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