<?php

include('../config.php');

if (isset($_POST['add_new_Public_health_center'])) {
    $facility_id=add_new_facility();
    echo "hello world".$facility_id;
    $location ="/COM353/healthcenter/healthcenter_view.php?facility_id=".$facility_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['update_Public_health_center'])) {

    $facility_id = e($_POST['facility_id']);
    $facility_id = update_facility($facility_id);
    $successflag='SUCCESS';
    $location ="/COM353/healthcenter/healthcenter_view.php?facility_id=".$facility_id."&Successflag=".$successflag;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
}

if (isset($_POST['delete_Public_health_center'])) {
    $facility_id = e($_POST['facility_id']);
    $region_id = delete_facility($facility_id);
    echo "delete";
    header("Location: healthcenter_record.php");

}
function add_new_facility()
{
    global $db;
    $date = date_create();
    echo date_timestamp_get($date);
    $facility_id=generateRandomString();
    $query = "INSERT INTO publichealthcenter(facility_id)VALUES('$facility_id')";
    $db->query($query);
    //$facility_id=$mysqli->insert_id;
    $db->close();
    return  $facility_id;
}


function delete_facility($facility_id)
{
    global $db;
    $facility_id = e($_POST['facility_id']);
    $query ="DELETE FROM `publichealthcenter` WHERE `facility_id` = '$facility_id'";
    if ($db->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $db->close();
    return $facility_id;
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function update_facility($facility_id)
{
    global $db;
    $facility_id = e($_POST['facility_id']);
    $facility_name = e($_POST['facility_name']);
    $address= e($_POST['address']);
    $web_address=e($_POST['web_address']);
    $phone_number=e($_POST['phone_number']);
    $type=e($_POST['type']);
    $operating_zone=e($_POST['operating_zone']);
    $method_of_acceptance=e($_POST['method_of_acceptance']);
    $has_drive_through=e($_POST['has_drive_through']);



    //$query = "UPDATE `publichealthcenter` SET `facility_name` = '$facility_name', `address` = '$address' ,`web_address` = '$web_address' ,`phone_number` = '$phone_number' ,`type` = '$type' , `operating_zone` = '$operating_zone' ,  `method_of_acceptance` = '$method_of_acceptance' , `has_drive_through` = '$has_drive_through'  WHERE `publichealthcenter`.`facility_id` = '$facility_id'";
    $query = "UPDATE `publichealthcenter` SET  `operating_zone` = '$operating_zone' , `web_address` = '$web_address',`has_drive_through` = '$has_drive_through' ,`method_of_acceptance` = '$method_of_acceptance',`type` = '$type' ,`phone_number` = '$phone_number' , `facility_name` = '$facility_name', `address` = '$address'  WHERE `publichealthcenter`.`facility_id` = '$facility_id'";
    echo $query;
    if ($db->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $db->close();
    return $facility_id;
}




