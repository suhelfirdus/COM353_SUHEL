<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
include('../config.php');
$q = $_GET['q'];
global $db;
$sql="select * from cityzipcodes where city_id='$q'";
//echo $sql;
$result = mysqli_query($db, $sql);
echo "<label for=zip_id>Zip .</label>";
echo "<select name='zip_id' id='zip_id' onchange='setZipValue(this.value)' required>";
echo "<option value='0'> ---Select Zip-- </option>";
while($row = mysqli_fetch_array($result)) {
    echo  "<option value='$row[1]'>$row[1]</option>";
}
echo "</select>";

?>
</body>
</html>