<?php
include '../UICommon/template.php' ;
include('covidtest_functions.php');
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
                    <option value="person_id">Person Id</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="medicare_number">Medicare Number</option>
                    <option value="facility_id">Facilty Id</option>
                    <option value="facility_name">Facility Name</option>
                    <option value="street_address">Street Address</option>
                    <option value="is_health_worker">Health Worker</option>
                    <option value="city_name">City Name</option>
                    <option value="region_name">Region Name</option>
                    <option value="result_date">Result Date</option>
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
                <button type="submit" class="btn btn-primary" name="ADD_NEW_COVIDTEST" >
                    ADD NEW COVIDTEST
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
    $query = "select pkey,screenname,test_id,  first_name, last_name, dob, email_address,person_phone_number, test_date, result_date, result from diagnostic_det_view where ".$searchparam." like '".$searchvalue."%' order by result desc";
    //echo $query;
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

function add_test()
{
    global $db;
    $date = date_create();
    echo date_timestamp_get($date);
    //$facility_id=generateRandomString();
    $query = "INSERT INTO diagnostic(test_id, performed_at, tested_by) values(null,'',0);";
    $db->query($query);
    $test_id=$db->insert_id;
    $db->close();
    return  $test_id;
}

?>

</html>
