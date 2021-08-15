// for updating any account from admin/support panel
function populate_user_info() {
    var username = document.getElementById("acc_username").value
    //alert('all good '+username)
    if (!username) {
        document.getElementById("result").innerHTML = 'Username cant be found!';
    } else {
        document.getElementById("result").innerHTML = '';
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                //document.getElementById("result").innerHTML = this.responseText;
                //alert(this.responseText)
                const myObj = JSON.parse(this.responseText);
                document.getElementById("name").value = myObj.Name;
                document.getElementById("email").value = myObj.Email;

                if (myObj.Gender === 'male'){
                    document.edit_any_acc.gender[0].checked=true;
                } else if (myObj.Gender === 'female'){
                    document.edit_any_acc.gender[1].checked=true;
                } else {
                    document.edit_any_acc.gender[2].checked=true;
                }
                document.getElementById("dob").value = myObj.dob;

                if (myObj.acc_group === 'Support'){
                    document.getElementById('acc_grp').getElementsByTagName('option')[1].selected = true;
                } else if (myObj.acc_group === 'Subscriber'){
                    document.getElementById('acc_grp').getElementsByTagName('option')[2].selected = true;
                }

                if (myObj.status === 'Active'){
                    document.getElementById('acc_status').getElementsByTagName('option')[1].selected = true;
                } else {
                    document.getElementById('acc_status').getElementsByTagName('option')[2].selected = true;
                }

            }
        }
        xmlhttp.open("GET", "controller/getUserInfoAjax.php?username="+username, true);
        xmlhttp.send();
    }
}