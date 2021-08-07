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
            $data['name'], $data['email'], $data['gender'], $data['dob'], $username
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