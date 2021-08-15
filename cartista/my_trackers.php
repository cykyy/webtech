<style>
    body{
        color: white;
    }
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;

    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }



    tr:nth-child(even) {
        background-color: #1d3858;
    }
    a{
        color: white;
    }
</style>
<?php
session_start();
include 'templates/nav2.php';?>
<?php include 'templates/base2.php';

if (!isset($_SESSION['uname'])) {
    header('Location: login.php');
}

require_once 'controller/tracker.php';
$arra = getAllTrackers();

echo '
    <h2 class="text-center">Tracker URL List</h2> 
<h3 style="text-align: center"><a href="./create_my_tracker.php"> Create New Tracker </a></h3> 
    <table class="table">
        <tr>
            <th>Username</th>
            <th>URL</th>
            <th>Remote Status</th>
            <th>To Order</th>
            <th>Ordered</th>
        </tr>
    ';
foreach($arra as $item) { //foreach element in $arr
    if ($_SESSION['ugroup'] === 'Subscriber') {
        if ($_SESSION['uname'] === $item['Username']) {
            echo "
            <tr>
                <td>" .$item['Username']. "</td>
                <td>" .$item['URI']. "</td>
                <td>" .$item['RemoteStatus']. "</td>
                <td>" .$item['OrderQty']. "</td>
                <td>" .$item['Ordered']. "</td>
            </tr>
            ";
        }
    }
}
echo '
    </table>
';

function which_group($arra) {
    foreach($arra as $item) {
        if ($_SESSION['uname']==$item->username){
            // match
            if ($item->acc_group === 'Admin'){
                return 'Admin';
            } elseif ($item->acc_group === 'Support'){
                return 'Support';
            } else {
                return 'Subscriber';
            }
        }
    }
    return false;
}
?>
<!--
<br><br>
<h3 style="text-align: center"><a href="/cartista/create_new_user.php"> Add New Account </a></h3>
-->