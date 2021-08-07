<?php
session_start();
include 'templates/nav2.php';
include 'templates/base2.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create a tracker</title>
</head>
<body>

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

<script>
    function isValidUrl(string) {
        if (string.includes('http:') || string.includes('https:')){
            return true;
        } else {
            return false;
        }
    }

    function checkTextInput(){
        let purl = document.forms["add_tracker"]["purl"].value;
        if (purl !== "") {
            let res = isValidUrl(purl)
            // alert(typeof (res));
            if (res) {
                document.getElementById("sub_btn").disabled = false;
                document.getElementById("result").innerHTML = "";
            } else {
                document.getElementById("result").innerHTML = "Not a valid URL";
                document.getElementById("result").style.color = "red";
                document.getElementById("sub_btn").disabled = true;
            }
        }
    }
</script>

<div class="donor-info make-it-center">
    <h2>Track New Product Stock</h2>
    <form method="post" name="add_tracker" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Enter Product URL: <input type="text" onkeyup="checkTextInput()" name="purl" value="<?php echo $purl;?>">
        <span class="error">* <?php echo $pUrlErr;?></span>
        <div id="result"></div>
        <br><br>

        <input type="submit" id="sub_btn" disabled name="submit" value="Submit">

    </form>

</div>

</body>

</html>