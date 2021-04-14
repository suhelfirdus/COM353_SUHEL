<!DOCTYPE html>
<html>
<head>

</head>
<body>

<?php
//$q = intval($_GET['q']);
$q = $_GET['q'];
//echo $q;

$con = mysqli_connect('localhost','root','','main_projectv1');
if (!$con) {
    die('Could not connect: ' . mysqli_error($con));
}

mysqli_select_db($con,"main_projectv1");
$sql="SELECT * FROM REGION WHERE region_name = '".$q."'";
//echo $sql;
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_array($result)) {
    echo "<div class=form-group><label class=control-label col-sm-2 for=current_alert >  Current Alert</label><div class=col-sm-10><input type=text name=current_alert id=current_alert readonly value=" . $row['current_active_alert'] ."></div></div>";
}
mysqli_close($con);
?>
</body>
</html>