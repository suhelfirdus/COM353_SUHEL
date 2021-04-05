<?php

include('../config.php');

if (isset($_POST['add_new_person'])) {
    $person_id=add_person();
    echo "hello world".$person_id;
    $location ="/COM353/person/person_view.php?person_id=".$person_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['update_person_btn'])) {
    $person_id = e($_POST['person_id']);
    echo $person_id;
    $person_id = update_ui_person($person_id);
    $location ="/COM353/person/person_view.php?person_id=".$person_id;
    $location ="/COM353/person/person_view.php?person_id=".$person_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}

if (isset($_POST['delete_person'])) {
    $person_id = e($_POST['person_id']);
    $person_id = delete_person($person_id);
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
    $query = "INSERT INTO address(person_id)VALUES('$person_id')";
    $mysqli->query($query);

    $mysqli->close();
    return  $person_id;
}


function delete_person($person_id)
{
    global $mysqli;
    $facility_id = e($_POST['person_id']);
    $query ="DELETE FROM `person` WHERE `person_id` = $person_id";
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    //return $person_id;
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

function getRelatedPerson(){
    global $db;
    $query = "SELECT person_id,first_name,Last_name,phone_number,street_address from person_det_view";
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $regions = array();
    while ($row = $result->fetch_row()) {
        echo  "<option value=$row[0] >$row[0] - $row[1] $row[2] </option>";
        $regions[]=$row;
    }

    return $regions;

}












