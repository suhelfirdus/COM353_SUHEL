<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
$q = $_GET['q'];
global $db;
$sql="SELECT * FROM city WHERE region_id = '".$q."'";
$result = mysqli_query($db, $sql);
while($row = mysqli_fetch_array($result)) {
    echo "<div class=form-group><label class=control-label col-sm-2 for=city_id >  Current Alert</label><div class=col-sm-10><input type=text name=city_id id=city_id readonly value=" . $row['city_id'] ."></div></div>";
}
//$mysqli->close();
?>
</body>
</html>
