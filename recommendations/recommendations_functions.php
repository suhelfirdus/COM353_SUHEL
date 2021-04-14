<?php

include('../config.php');

if (isset($_POST['add_new_recommendation'])) {
    $rec_id=add_new_recommendations();
    echo "hello world".$rec_id;
    $location ="/COM353/recommendations/recommendations_view.php?rec_id=".$rec_id;
    header("Location: " . "http://" . $_SERVER['HTTP_HOST'] . $location);

}
if (isset($_POST['update_recommendation_btn'])) {

    $rec_id = e($_POST['rec_id']);
    $rec_id = update_region($rec_id);
    $_SESSION["rec_id"]=$rec_id;
    //header("Location: recommendations_record.php");
}

if (isset($_POST['delete_recommendations_btn'])) {
    $rec_id=e($_POST['rec_id']);
    $rec_id = delete_recommendations($rec_id);
    header("Location: recommendations_record.php");

}
function add_new_recommendations()
{
    global $mysqli;
    $query = "INSERT INTO recommendations(rec_id)VALUES(null)";
    $mysqli->query($query);
    $rec_id=$mysqli->insert_id;
    $mysqli->close();
    return  $rec_id;
}



function update_region($rec_id)
{
    global $mysqli;
    $rec_id = e($_POST['rec_id']);
    $rec_name = e($_POST['rec_name']);
    $rec_date = e($_POST['rec_date']);
    $rec_text = e($_POST['rec_text']);
    $query = "UPDATE `recommendations` SET `rec_name` = '$rec_name',`rec_date` = '$rec_date',`rec_text` = '$rec_text'  WHERE `recommendations`.`rec_id` = $rec_id";
    //echo  $query;
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $rec_id;
}

function delete_recommendations($rec_id)
{
    global $mysqli;
    $rec_id = e($_POST['rec_id']);
    $query ="DELETE FROM `recommendations` WHERE `rec_id` = $rec_id";
    echo $query;
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    return $rec_id;
}



