<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
include('../config.php');
$q = $_GET['q'];
global $mysqli;
$sql="select * from city where region_id=(select region_id from region where region_name='$q')";
//echo $sql;
$result = mysqli_query($mysqli, $sql);
   echo "<label for=city_id>City .</label>";
   echo "<select name='city_id' id='city_id' onselect='setValue(this.value)' required>";
   echo "<option value='0'> ---Select City-- </option>";
        while($row = mysqli_fetch_array($result)) {
        echo  "<option value=$row[0]>$row[0]  $row[1]</option>";
        }
   echo "</select>";

?>
</body>
</html>


