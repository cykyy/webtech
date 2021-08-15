<?php
session_start();
include 'templates/nav2.php';
include 'templates/base2.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>

<?php
require_once 'controller/getUser.php';
require_once 'controller/tracker.php';
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
        $user_found = false;
        $item = getUserAccount($_SESSION['uname']);
        if ($item){
            if ($_SESSION['uname'] === $item['Username']) {
                $user_found = true;
            }
        }
        if ($user_found) {
            if (createNewTracker($_POST["purl"], $_SESSION['uname'], $_POST['order_qty'])) {
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
    <div class="container">
        <h2 class="text-center">Track New Product Stock</h2>
        <form class="form" method="post" name="add_tracker" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Enter Product URL: <input type="text" onkeyup="checkTextInput()" name="purl" value="<?php echo $purl;?>">
            Order Quantity: <input type="text" name="order_qty" value=1>
            <span class="error">* <?php echo $pUrlErr;?></span>
            <div id="result"></div>
            <br><br>

            <button type="submit" id="sub_btn" disabled name="submit" value="Submit">Submit</button>

        </form>
    </div>
</body>
</html>