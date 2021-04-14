<?php
$servername = "qfc353.encs.concordia.ca";
$username = "qfc353_4";
$password = "lmmm4444";
$dbname = "qfc353_4";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli ->connect_error) {
    die("Connection failed: " . $mysqli ->connect_error);
}
//echo "Connected successfully";
?>