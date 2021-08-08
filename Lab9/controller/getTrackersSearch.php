<?php

require_once ('../model/model.php');
$res = getTrackersFromDB();
$inserted_dt = $_GET["q"];
if ($inserted_dt) {
    if ($res) {
        //echo var_dump($res);
        foreach ($res as $values) {
            if (str_contains($values['URI'], $inserted_dt)) {
                echo $values['URI'], "<br>";
            }
            // echo $values['URI'], "<br>";
        }
        echo '</table>';
    }
}

?>