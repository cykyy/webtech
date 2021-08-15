function isValidUrl(string) {
    if (string.includes('http:') || string.includes('https:')){
        return true;
    } else {
        return false;
    }
}

function checkTextInput(){
    let purl = document.forms["add_tracker"]["purl"].value;
    // alert('ercerv');
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