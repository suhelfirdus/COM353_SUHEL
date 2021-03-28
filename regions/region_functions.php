<?php
if (isset($_POST['add_new_Region'])) {
    //echo "hello";
    $region_id=add_new_region();
    echo "hello world".$region_id;
    $location ="/COM353/regions/regions_view.php?region_id=".$region_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);
    //echo "hello world";
}


function add_new_region()
{
    //global $host,$db_user,$db_pass,$db_name;
    $mysqli = new mysqli('localhost', 'root', '', 'main_projectv1');
    $query = "INSERT INTO Region(region_id)VALUES(null)";
    $mysqli->query($query);
    $region_id=$mysqli->insert_id;
    $mysqli->close();

    return  $region_id;
}


if (isset($_POST['update_newRegion_btn'])) {
    echo "hello";
    $region_id = e($_POST['region_id']);
    $region_id = update_region($region_id);
    echo "redirecting";
    header("Location: regions_record.php");
}

function update_region($region_id)
{
    $region_id = e($_POST['region_id']);
    echo "updating : " . $region_id;
    $region_name = e($_POST['region_name']);
    echo "updating :" . $region_name;
    $current_alert = e($_POST['current_active_alert']);
    echo "updating : " . $current_alert;

    $mysqli = new mysqli('localhost', 'root', '', 'main_projectv1');
    //$query = "UPDATE  Region SET REGION_NAME =".$region_name." ,CURRENT_ACTIVE_ALERT=".$region_name." WHERE REGION_ID= $region_id";
    $query = "UPDATE `REGION` SET `region_name` = '$region_name', `current_active_alert` = '$region_name' WHERE `REGION`.`region_id` = $region_id";

    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }

    //$mysqli->query($query);
    //$mysqli->close();
    echo "updated";
    return $region_id;
}





