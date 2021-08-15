<?php
require_once ('model/model.php');

function getAllTrackers(){
    return getAllTrackersFromDB();
}

function createNewTracker($uri, $username, $orderQty){
    return createTrackerDB($uri, $username, $orderQty);
}

?>
