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
    //header("Location: covidtest_view.php?test_id=".$test_id);
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
        echo  "<option value=$row[0] >$row[1]</option>";
        $regions[]=$row;
    }

    return $regions;

}


function displaysSymptoms($table_name, $id){
    global $mysqli;

    $query = "SELECT COUNT(*) AS RowCnt FROM $table_name";
    $result = mysqli_query($mysqli, $query);

    if($result != false) {

        $query = "SELECT  `person_id`         AS      `ID`,`date_reported`     AS      `DATE REPORTED`, `time_reported`     AS      `TIME REPORTED`,
                    `symptoms`          AS      `SYMPTOM`,  
                    `body_temp`         AS      `BODY TEMPERATURE`
       
                FROM {$table_name} 
                ";

        $result = mysqli_query($mysqli, $query);


        //$fields_num = mysqli_field_count($mysqli);

        while (($row = $result->fetch_assoc()) !== null) {
            $data[] = $row;
        }

        if (@$data !== null) {
            @$colNames = array_keys(reset($data));

            echo "<table class='table'>";
            echo "<thead>";

            foreach ($colNames as $colName) {
                if ($colName != "person_id") {
                    echo "<th>$colName</th>";
                }
            }



            echo "</thead>";
            foreach ($data as $row) {
                echo "<tr>";
                foreach ($colNames as $colName) {
                    if ($colName != "person_id") {
                        echo "<td>" . $row[$colName] . "</td>";
                    }
                }

                echo "</tr>";
            }
        }

        mysqli_free_result($result);
        $mysqli->close();
    }else{
        echo "Nothing to display";
    }
}

function getHealthWorkerNameById($hwid){
    global $mysqli;
    $query = "SELECT first_name, last_name FROM person WHERE person_id = '$hwid'";
    if($mysqli->query($query) == true) {
        $result = $mysqli->query($query);
        $row = $result->fetch_assoc();
        return $row['first_name']." ".$row['last_name'];
    } else{
        $mysqli->error(error_get_last());
    }
    $mysqli->close();
}












