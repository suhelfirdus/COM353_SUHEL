<?php
include '../UICommon/template.php' ;

?>
<body>
<!-- First Columns is always the menu -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <?php
            include '../admin/admin_menu.php';
            ?>
        </div>
        <!-- First Columns is always the menu ends-->

        <div class="col-md-4">
            <!-- Button to call a new Operation -->
            <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- Button to call a new Operation  ends -->
                <div class="form-group">
                <label for="searchparam">select a param:</label>
                <select name="searchparam" id="searchparam">
                    <option value="facility_id">Facility Id</option>
                    <option value="facility_name">Facility Name</option>
                    <option value="address">address</option>
                    <option value="web_address">website</option>
                    <option value="phone_number">Phone Number</option>
                    <option value="operating_zone">Operating Region</option>
                    <option value="method_of_acceptance">Method of Acceptance</option>
                    <option value="has_drive_through">Has Drive Through?</option>
                </select>
                </div>
                <div class="form-group">
                    <label for="searchvalue">
                        value
                    </label>
                    <input type="text" class="form-control" id="searchvalue"  name="searchvalue" />
                </div>

                <button type="submit" class="btn btn-primary" name="SEARCH_HEALTHCENTER" >
                    SEARCH
                </button>&NonBreakingSpace;
                <hr>
                <button type="submit" class="btn btn-primary" name="ADD_NEW_HEALTH_CENTER" >
                    ADD NEW HEALTH CENTER
                </button>
                <hr>

        </div>
        <!-- Second column-->
        <div class="col-md-4">


            <!--</form>-->
            <form>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
        </div>
    </div>

</body>
<?php
if (isset($_POST['SEARCH_HEALTHCENTER'])) {
    $searchparam=e($_POST['searchparam']);
    $searchvalue=e($_POST['searchvalue']);
    $query = "select * from publichealthcentres_det_view where ".$searchparam." like '".$searchvalue."%'";
    echo $query;
    global $db;
    $result = mysqli_query($db, $query);
    $fields_num = mysqli_field_count($db);
    while (($row = $result->fetch_assoc()) !== null) {
        $data[] = $row;
    }
    if ( @$data!==null) {
        @$colNames = array_keys(reset($data));
        echo "<row>";
        echo "<table class=table>";
        echo "<thead>";
        foreach ($colNames as $colName) {
            if ($colName != "pkey") {
                if ($colName != "screenname") {
                    echo "<th>$colName</th>";
                }
            }
        };
        echo "</thead>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($colNames as $colName) {
                if ($colName != "pkey") {
                    if ($colName != "screenname") {
                        echo "<td>" . $row[$colName] . "</td>";
                    }

                }
            }
            echo "<td><a href=" . @$row['screenname'] . "_view.php?" . @$row['pkey'] . ">view</a>";
            echo "</tr>";

            echo "</row>";
        }
    }
}
?>

</html>
