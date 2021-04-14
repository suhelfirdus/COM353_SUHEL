<?php
include '../UICommon/template.php' ;
include 'emptest_functions.php' ;
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
                    <div class="form-group">
                        <label for="health_facility">
                            Health Facility
                        </label>

                        <select name="health_facility" id="health_facility" >

                            <?php echo $region=getHealthFacilities();
                            ?>
                        </select>
                    </div>

                <label for="searchparam">Search Employee By:</label>
                <select name="searchparam" id="searchparam">
                    <option value="person_id">Person Id</option>
                    <option value="first_name">Employee First Name</option>
                    <option value="last_name">Employee last Name</option>
                    <option value="result_date">Test Result Date</option>

                </select>

                </div>
                <div class="form-group">
                    <label for="searchvalue">
                        value
                    </label>
                    <input type="text" class="form-control" id="searchvalue"  name="searchvalue" />
                </div>

                <button type="submit" class="btn btn-primary" name="SEARCH_EMPLOYEE" >
                    SEARCH
                </button>&NonBreakingSpace;
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
    <table>
        <tr><th> Employee who are tested positive</th></tr>
    </table>
</body>
<?php
if (isset($_POST['SEARCH_EMPLOYEE'])) {
    $searchparam=e($_POST['searchparam']);
    $searchvalue=e($_POST['searchvalue']);
    //echo "Employees who were tested Positive for Covid-19";
    //echo e($_POST['health_facility']);
    $healthfacilty=e($_POST['health_facility']);
    //echo $searchparam;
    //echo $searchvalue;

    $query ="select * from(
select p.health_facility_id,p.person_id,p.first_name,p.last_name,d.result_date ,d.result,d.test_id
from person p, diagnostic d where is_health_worker='Yes' and
p.person_id=d.person_id and d.result='Positive') a where a.health_facility_id=$healthfacilty and a.".$searchparam." like '".$searchvalue."%'";



   // $query = "select * from region_det_view where ".$searchparam." like '".$searchvalue."%'";
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
            echo "<td><a href=emptest_view.php?test_id=". @$row['test_id'] . ">view</a>";
            echo "</tr>";

            echo "</row>";
        }
    }
}
?>

</html>
