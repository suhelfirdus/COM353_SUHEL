<?php

include('../config.php');

if (isset($_POST['ADD_NEW_COVIDTEST'])) {
    $test_id=add_test();
    echo "hello world".$test_id;
    $location ="/COM353/covidtest/covidtest_addedit.php?test_id=".$test_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['update_covidtest_btn'])) {
    $test_id = e($_POST['test_id']);
    echo $test_id;
    $test_id = update_ui_covidtest($test_id);
    header("Location: covidtest_view.php?test_id=".$test_id);
}

if (isset($_POST['edit_a_report_btn'])) {
    $test_id = e($_POST['test_id']);
    echo $test_id;
    $location ="/COM353/covidtest/covidtest_view.php?test_id=".$test_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
}

if (isset($_POST['edit_covidtest_report'])) {
    $test_id = e($_POST['test_id']);
    echo $test_id;
    $location ="/COM353/covidtest/covidtest_addedit.php?test_id=".$test_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
}





/*function add_test()
{
    global $mysqli;
    $date = date_create();
    echo date_timestamp_get($date);
    //$facility_id=generateRandomString();
    $query = "INSERT INTO diagnostic(test_id, performed_at, tested_by) values(null,'',0);";
    $mysqli->query($query);
    $test_id=$mysqli->insert_id;
    //$query = "INSERT INTO Address(person_id)VALUES('$person_id')";
    //$mysqli->query($query);
    $mysqli->close();
    return  $test_id;
} */

function getRelatedPerson(){
    global $db;
    $query = "SELECT Person_id,first_name,Last_name,phone_number,street_address from person_det_view";
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $regions = array();
    while ($row = $result->fetch_row()) {
        echo  "<option value=$row[0] >$row[0] - $row[1] $row[2] </option>";
        $regions[]=$row;
    }

    return $regions;

}

function getAllHealthCenters(){
    global $db;
    $query = "select facility_id,facility_name,address,web_address,phone_number from publichealthcentres_det_view";
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $regions = array();
    while ($row = $result->fetch_row()) {
        echo  "<option value=$row[0] >$row[0] - $row[1] - $row[2] - $row[2]  -   $row[2] </option>";
        $regions[]=$row;
    }

    return $regions;

}












