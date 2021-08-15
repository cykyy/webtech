<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <script>
        // for updating any account from admin/support panel
        function populate_user_info() {
            var username = document.getElementById("acc_username").value
            if (!username) {
                document.getElementById("result").innerHTML = 'Username cant be found!';
            } else {
                document.getElementById("result").innerHTML = '';
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
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
    </script>
</head>
<body>

<?php require_once 'controller/editAnyAccountIncludes.php'?>
<br>
<fieldset class="text-center">
    <legend> <b>Profile:</b></legend>
    <div>
        <form method="post" name="edit_any_acc" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

            <label for="acc_username">Select an account:</label>
            <select name="acc_username" id="acc_username" onchange="populate_user_info()">
                <option selected></option>
            <?php
            foreach ($arra as $item) { //foreach element in $arr
                if ($item['acc_group'] !== 'Admin' && $item['acc_group'] !== 'Support') {
                    echo "<option>". $item['Username'] ."</option>";
                }
            }

            ?>
            </select> <br><br>
            <div id="result"></div>
            New Name: <input type="text" name="name" id="name" value="">
            <br><br>
            New Email: <input type="text" name="email" id="email" value="">
            <br><br>
            <span>Gender: </span>
            <input type="radio" id="male" name="gender" value="male" >
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="female">
            <label for="female">Female</label>
            <input type="radio" id="other" name="gender" value="other">
            <label for="other">Other</label>
            <br><br>
            <span>Date of Birth: </span>
            <input type="date" name="dob" id="dob"> <br><br>
            <br>

            <label for="acc_grp">Change Account Type:</label>
            <select name="acc_grp" id="acc_grp">
                <option value="">Select</option>
                <option value="Support">Support</option>
                <option value="Subscriber">Subscriber</option>
            </select> <br><br>

            <label for="acc_status">Change Account Status:</label>
            <select name="acc_status" id="acc_status">
                <option value="">Select</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
            </select> <br><br>

            <input type="submit" name="submit" value="Submit">
        </form>

    </div>
</fieldset>
</body>
</html>