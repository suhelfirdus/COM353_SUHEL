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
                    <option value="city_id">City Id</option>
                    <option value="city_name">City Name</option>
                    <option value="region_id">Region ID</option>
                    <option value="region_name">Region Name</option>
                    <option value="province">Province</option>
                </select>
                </div>
                <div class="form-group">
                    <label for="searchvalue">
                        value
                    </label>
                    <input type="text" class="form-control" id="searchvalue"  name="searchvalue" />
                </div>

                <button type="submit" class="btn btn-primary" name="SEARCH_PERSON" >
                    SEARCH
                </button>&NonBreakingSpace;
                <hr>
                <button type="submit" class="btn btn-primary" name="add_new_city" >
                    ADD NEW CITY
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
if (isset($_POST['SEARCH_PERSON'])) {
    $searchparam=e($_POST['searchparam']);
    $searchvalue=e($_POST['searchvalue']);
    $query = "select * from cities_det_view where ".$searchparam." like '".$searchvalue."%'";
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
        echo "<table>";
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
