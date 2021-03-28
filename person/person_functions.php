<?php

include('../config.php');

if (isset($_POST['add_new_person'])) {
    $person_id=add_person();
    echo "hello world".$person_id;
    $location ="/COM353/person/person_view.php?person_id=".$person_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['update_person'])) {

    $person_id = e($_POST['person_id']);
    $person_id = update_person(person_id);
    header("Location: person_record.php");
}

if (isset($_POST['delete_person'])) {
    $person_id = e($_POST['person_id']);
    $person_id = delete_facility($person_id );
    echo "delete";
    header("Location: person_record.php");

}
function add_person()
{
    global $mysqli;
    $date = date_create();
    echo date_timestamp_get($date);
    //$facility_id=generateRandomString();
    $query = "INSERT INTO person(person_id)VALUES(null)";
    $mysqli->query($query);
    $person_id=$mysqli->insert_id;
    $query = "INSERT INTO Address(person_id)VALUES('$person_id')";
    $mysqli->query($query);

    $mysqli->close();
    return  $person_id;
}

function update_person($person_id)
{
    global $mysqli;
    $person_id = e($_POST['person_id']);
    //$facility_name = e($_POST['facility_name']);
    //$address= e($_POST['address']);
    $web_address=e($_POST['web_address']);
    $phone_number=e($_POST['phone_number']);
    $type=e($_POST['type']);
    $operating_zone=e($_POST['operating_zone']);
    $method_of_acceptance=e($_POST['method_of_acceptance']);
    $has_drive_through=e($_POST['has_drive_through']);

    $query = "UPDATE `PUBLICHEALTHCENTER` SET `facility_name` = '$facility_name', `address` = '$address' ,`web_address` = '$web_address' ,`phone_number` = '$phone_number' ,`type` = '$type' , `operating_zone` = '$operating_zone' ,  `method_of_acceptance` = '$method_of_acceptance' , `has_drive_through` = '$has_drive_through'  WHERE `PUBLICHEALTHCENTER`.`facility_id` = '$facility_id'";

    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $facility_id;
}
function delete_facility($facility_id)
{
    global $mysqli;
    $facility_id = e($_POST['facility_id']);
    $query ="DELETE FROM `PUBLICHEALTHCENTER` WHERE `facility_id` = '$facility_id'";
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $region_id;
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





