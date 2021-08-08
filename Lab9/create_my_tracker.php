<?php
session_start();
include 'templates/nav2.php';
include 'templates/base2.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create a tracker</title>
    <style>
        table, th, td {
            border: 1px solid #00cd04;
            border-collapse: collapse;
        }
    </style>
</head>
<body>

<script>
    function isValidUrl(string) {
        if (string.includes('http:') || string.includes('https:')){
            return true;
        } else {
            return false;
        }
    }

    function checkTextInput(){
        //alert('test');
        let purl = document.getElementById("uri").value;
        if (purl !== "") {
            let res = isValidUrl(purl)
            //alert(typeof (res));
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
<div class="text-center">
    <h1>Add New Tracker</h1>
    <input type="text" id="uri" onkeyup="checkTextInput()">
    <button type="button" disabled id="sub_btn" onclick="addTrackerDb()">Submit</button>
    <button type="button" id="show_all_records" onclick="showTrackers()">Show Trackers</button>

    <p id="result"></p>
    <div id="result2"></div>
</div>

<script>
    function addTrackerDb() {
        var uri = document.getElementById("uri").value
        if (uri !== "") {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("result").innerHTML = this.responseText;
                    document.getElementById("uri").value = "";
                    //document.getElementById("result2").value = "";
                    document.getElementById("sub_btn").disabled = true;
                    showTrackers();
                }
            };
            xhttp.open("POST", "controller/add_new_tracker.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("uri=" + uri);
        }
    }
</script>
<script>
    function showTrackers(){
        //alert('all good');
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("result2").innerHTML = this.responseText;
            }
        }
        xmlhttp.open("GET", "controller/getTrackers.php", true);
        xmlhttp.send();
    }
</script>


</body>

</html>