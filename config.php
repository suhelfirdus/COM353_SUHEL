
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "main_projectv1";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli ->connect_error) {
    die("Connection failed: " . $mysqli ->connect_error);
}
//echo "Connected successfully";
?>
