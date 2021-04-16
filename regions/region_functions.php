<?php

include('../config.php');



if (isset($_POST['ADD_NEW_CITY'])) {

    $city_id=add_new_city();
    $location ="/COM353/cities/cities_view.php?city_id=".$city_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}

function add_new_city()
{
    global $mysqli;
    $query = "INSERT INTO city(city_id)VALUES(null)";
    $mysqli->query($query);
    $city_id=$mysqli->insert_id;
    $mysqli->close();
    return  $city_id;
}


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

if (isset($_POST['delete_Region_btn'])) {
    $region_id=e($_POST['region_id']);
    $region_id = delete_region($region_id);
    echo "delete";
    header("Location: regions_record.php");

}
function add_new_region()
{
    global $mysqli;
    $query = "INSERT INTO region(region_id)VALUES(null)";
    $mysqli->query($query);
    $region_id=$mysqli->insert_id;
    $mysqli->close();
    return  $region_id;
}


function delete_region($region_id)
{
    global $mysqli;
    $region_id = e($_POST['region_id']);
    $query ="DELETE FROM `region` WHERE `region_id` = $region_id";
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $region_id;
}





