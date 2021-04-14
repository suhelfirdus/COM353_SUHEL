<?php

include('../config.php');

if (isset($_POST['add_new_city'])) {
    $city_id=add_new_region();
    echo "hello world".$city_id;
    $location ="/COM353/cities/cities_view.php?city_id=".$city_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['save_city'])) {

    $city_id = e($_POST['city_id']);
    $city_id= update_city($city_id);
    header("Location: cities_record.php");
}

if (isset($_POST['delete_city'])) {
    $city_id=e($_POST['city_id']);
    $region_id = delete_city($city_id);
    echo "delete";
    header("Location: cities_record.php");

}
function add_new_region()
{
    global $mysqli;
    $query = "INSERT INTO city(city_id)VALUES(null)";
    $mysqli->query($query);
    $region_id=$mysqli->insert_id;
    $mysqli->close();
    return  $region_id;
}


function delete_city($city_id)
{
    print_r($_POST);
    global $mysqli;
    $region_id = e($_POST['city_id']);
    $query ="DELETE FROM `city` WHERE `city_id` = $city_id";
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $region_id;
}







