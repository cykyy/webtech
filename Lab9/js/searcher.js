function search(){
    var inserted = document.getElementById('searcher').value
    if (inserted !== ""){
        //alert("test")
        showTrackersSearch(inserted)
    } else {
        document.getElementById('search_res').innerHTML = '';
    }
}

function showTrackersSearch(val){
    //alert('all good');
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            //resp_txt = this.responseText;
            //alert(this.responseText);
            document.getElementById("search_res").innerHTML = this.responseText;
        }
    }
    xmlhttp.open("GET", "controller/getTrackersSearch.php?q="+val, true);
    xmlhttp.send();
}