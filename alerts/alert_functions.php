<?php

include('../config.php');


if (isset($_POST['set_new_alert_init'])) {

    $region_name = e($_POST['region_name']);

    $location ="/COM353/alerts/alert_view.php?region_name=".$region_name;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}

if (isset($_POST['set_new_alert_save'])) {

    $saveData=set_new_alert_save();
    echo "hello world";
    //$location ="/COM353/alerts/alert_view.php?region_name=".$saveData;
    //header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
    header("Location: alert_record.php");
}

function set_new_alert_save()
{

    echo "hello world";
    global $mysqli;
    $region_id = e($_POST['region_id']);
    $region_name = e($_POST['region_name2']);
    $current_alert = e($_POST['current_active_alert']);
    $current_active_alert = e($_POST['current_active_alert']);
    $change_alert_to = e($_POST['change_alert_to']);
    $notify_people = e($_POST['notify_people']);
    $active="N";
    $newStatus="Y";

    echo "$region_id ".$region_id;
    echo "$region_name".$region_name;
    echo "$change_alert_to" .$change_alert_to;
    echo "$notify_people" .$notify_people;


    $query="UPDATE ALERT_SYSTEM SET IS_ACTIVE='$active' WHERE REGION_ID=$region_id";
    $queryInsert="INSERT INTO ALERT_SYSTEM(REGION_ID,ALERT_TYPE,IS_ACTIVE,NOTIFY_PEOPLE) VALUES($region_id,'$change_alert_to','$newStatus','$notify_people')";

    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }

  if ($mysqli->query($queryInsert) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $region_name;

}


function update_region($region_id)
{
    global $mysqli;
    $region_id = e($_POST['region_id']);
    $region_name = e($_POST['region_name']);
    $current_alert = e($_POST['current_active_alert']);
    $query = "UPDATE `REGION` SET `region_name` = '$region_name', `current_active_alert` = '$current_alert' WHERE `REGION`.`region_id` = $region_id";

    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $region_id;
}
function delete_region($region_id)
{
    global $mysqli;
    $region_id = e($_POST['region_id']);
    $query ="DELETE FROM `REGION` WHERE `region_id` = $region_id";
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $region_id;
}







