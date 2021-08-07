<?php
// define variables and set to empty values
$errCount = 0;
$purl = "";
$pUrlErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["purl"])) {
        $pUrlErr = "URL is required!";
        $errCount = $errCount + 1;
    } else {
        $purl = $_POST["purl"];
    }

    if ($errCount < 1){
        $userRes = getUserAccount($_SESSION['uname']);

        $strJsonFileContents = file_get_contents("data.json");
        $arra = json_decode($strJsonFileContents);
        if ($userRes) {
            $user_found = true;

        }
        $user_found = false;
        $user_edited = false;
        foreach($arra as $item) { //foreach element in $arr
            if ($_SESSION['uname'] === $item->username){
                $user_found = true;
                if (isset($item->trackers)){
                    array_push($item->trackers, $purl);
                    $user_edited = true;
                } else{
                    $item->trackers = array($purl);
                    $user_edited = true;
                }
            }
        }
        if ($user_edited){
            $final_data = json_encode($arra);
            if(file_put_contents('data.json', $final_data)){
                echo "<br><div style='color: green; text-align: center'> Successfully submitted! </br></div>";
                echo "<div style='color: green; text-align: center'> Whenever there's a change of stock status (eg In-Stock/Stock-Out) You will get notified.</br></div>";

            }
        }
    }

    if ($errCount < 1){

        $strJsonFileContents = file_get_contents("data.json");
        $arra = json_decode($strJsonFileContents);
        $user_found = false;
        $user_edited = false;
        foreach($arra as $item) { //foreach element in $arr
            if ($_SESSION['uname'] === $item->username){
                $user_found = true;
                if (isset($item->trackers)){
                    array_push($item->trackers, $purl);
                    $user_edited = true;
                } else{
                    $item->trackers = array($purl);
                    $user_edited = true;
                }
            }
        }
        if ($user_edited){
            $final_data = json_encode($arra);
            if(file_put_contents('data.json', $final_data)){
                echo "<br><div style='color: green; text-align: center'> Successfully submitted! </br></div>";
                echo "<div style='color: green; text-align: center'> Whenever there's a change of stock status (eg In-Stock/Stock-Out) You will get notified.</br></div>";

            }
        }
    }
}

function check_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>