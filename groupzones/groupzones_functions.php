<?php

include('../config.php');



if (isset($_POST['add_new_groupzones'])) {

    $zone_id = add_new_groupzones();
    $location ="/COM353/groupzones/groupzones_view.php?zone_id=".$zone_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}

if (isset($_POST['delete_zone'])) {

    $zone_id = add_new_groupzones();

}

function add_new_groupzones()
{
    global $mysqli;
    $query = "INSERT INTO group_zones(zone_id)VALUES(null)";
    $mysqli->query($query);
    $region_id=$mysqli->insert_id;
    $mysqli->close();
    return  $region_id;
}



if (isset($_POST['save_zone'])) {

    $zone_id = e($_POST['zone_id']);
    $city_id= update_zone($zone_id);
    //header("Location: cities_record.php");
}



function delete_zone($zone_id)
{
    print_r($_POST);
    global $mysqli;
    $region_id = e($_POST['zone_id']);
    $query ="DELETE FROM `group_zones` WHERE `zone_id` = $zone_id";
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $region_id;
}







