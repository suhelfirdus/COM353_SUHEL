<?php

include('../config.php');

if (isset($_POST['ADD_NEW_ALERT'])) {
    $region_name = e($_POST['region_name']);
    $location ="/COM353/alerts/alert_view.php?region_name=".$region_name;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
}





if (isset($_POST['set_new_alert_save'])) {

    $saveData=set_new_alert_save();
    //echo "hello world";
    //$location ="/COM353/alerts/alert_view.php?region_name=".$saveData;
    //header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
    //header("Location: alert_record_search.php");
}
function getNextAlert($region_name){
    global $db;
    $query = "SELECT alert_level_id,alert_description from next_available_alert where region_name='$region_name'";
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $regions = array();
    while ($row = $result->fetch_row()) {
        echo  "<option value=$row[0]>$row[1]</option>";
        $regions[]=$row;
    }

    return $regions;

}

function getEmailTemplate(){
    global $db;
    $query = "SELECT rec_id,rec_name from recommendations";
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $regions = array();
    while ($row = $result->fetch_row()) {
        echo  "<option value=$row[0]>$row[1]</option>";
        $regions[]=$row;
    }

    return $regions;

}
?>






