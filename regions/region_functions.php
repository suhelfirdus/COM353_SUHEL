<?php

include('../config.php');

if (isset($_POST['add_new_Region'])) {
    $region_id=add_new_region();
    echo "hello world".$region_id;
    $location ="/COM353/regions/regions_view.php?region_id=".$region_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['update_newRegion_btn'])) {

    $region_id = e($_POST['region_id']);
    $region_id = update_region($region_id);
    header("Location: regions_record.php");
}

if (isset($_POST['delete_newRegion_btn'])) {
    $region_id=e($_POST['region_id']);
    $region_id = delete_region($region_id);
    echo "delete";
    header("Location: regions_record.php");

}
function add_new_region()
{
    global $mysqli;
    $query = "INSERT INTO Region(region_id)VALUES(null)";
    $mysqli->query($query);
    $region_id=$mysqli->insert_id;
    $mysqli->close();
    return  $region_id;
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





