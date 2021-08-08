<?php

require_once ('../model/model.php');
$res = getTrackersFromDB();
if($res){
    echo "<span style='color: green'>Here's all your trackers:</span><br><br>";
    echo '
    <table style="width:100%">
              <tr>
                <th>Trackers</th>
              </tr>
    ';
    //echo var_dump($res);
    foreach ($res as $values) {
        //echo $values['URI'], "<br>";
        echo '
              <tr>
                <td>' . $values["URI"]. '</td>
              </tr>
        ';
    }
    echo '</table>';
}

?>