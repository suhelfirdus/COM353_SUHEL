<?php
include '../UICommon/template.php';
include 'region_functions.php';

$q = $_GET['region_id'];
$fromdate = @$_GET['fromdate'];
$todate = @$_GET['todate'];
//echo $q;
$QueryToRun = "SELECT * FROM region_det_view WHERE REGION_ID=$q";
//echo $QueryToRun;
$screenData = getBulkData($QueryToRun);
?>
<head>
    <script>
        function getHistory(){
            alert('get history');
        }
    </script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-4">
                    <?php
                    include '../admin/admin_menu.php';
                    ?>
                </div>
                <div class="col-md-4">
                    <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <button type="submit" class="btn btn-primary" name="add_new_Region">
                            Add New Region
                        </button>
                        <hr>
                        <div class="form-group">
                            <label for="region_id">
                                Region Id
                            </label>
                            <input type="text" class="form-control" id="region_id" name="region_id"
                                   value="<?php echo $screenData['region_id'] ?>" readonly required/>

                        </div>
                        <div class="form-group">
                            <label for="region_name">
                                Region Name
                            </label>
                            <input type="text" class="form-control" id="region_name" name="region_name"
                                   value="<?php echo $screenData['region_name'] ?>" required/>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update_newRegion_btn">
                            Save Region
                        </button>
                        <button type="submit" class="btn btn-primary" name="delete_Region_btn">
                            Delete Region
                        </button>
                    </form>
                </div>
                <div class="col-md-4">
                    <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <button type="submit" class="btn btn-primary" name="ADD_NEW_CITY">
                            Add New City
                        </button>
                        <hr>

                        <?php
                        $query = "select pkey,screenname,city_name,province from cities_det_view where region_id=$screenData[region_id]";
                        //echo $query;
                        global $db;
                        $result = mysqli_query($db, $query);
                        $fields_num = mysqli_field_count($db);
                        while (($row = $result->fetch_assoc()) !== null) {
                            $data[] = $row;
                        }
                        if (@$data !== null) {
                            @$colNames = array_keys(reset($data));

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
                                echo "<td><a href=../cities/" . @$row['screenname'] . "_view.php?" . @$row['pkey'] . ">view</a>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
                        ?>
                    </form>
                </div>
            </div>
<hr>

                    <div class="row">
                        <div class="col-md-4">
                            <?php
                            $QueryToRun="SELECT * FROM regionwise_report_count WHERE region_id=$q";
                            $screenDataCount=getBulkData($QueryToRun);
                            ?>
                            <table class="table">
                                <tr>
                                    <th>Test Result Count</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>Positive Persons In this area</td>
                                    <td><?php echo (isset($screenDataCount['Positive_Count'])) ? $screenDataCount['Positive_Count'] : 0 ?></td>
                                </tr>
                                <tr>
                                    <td>Negative Persons In this area</td>
                                    <td><?php echo (isset($screenDataCount['Negative_Count'])) ? $screenDataCount['Negative_Count'] : 0 ?></td>
                                </tr>


                            </table>
                        </div>
                        <div class="col-md-4">
                        </div>
                        <div class="col-md-4">
                        </div>
                    </div>
       <hr>
            <div class="row">
                <div class="col-md-12">

                    <table class="table">
                        <tr><form>
                            <th>History of Alerts</th>
                                <td><input type="hidden" class="form-control" id="region_id" name="region_id" value="<?php echo $screenData['region_id'] ?>"></td>
                            <td><label for="fromdate">
                                    From Date
                                </label>
                            </td>
                                <td><input type="date" class="form-control" id="fromdate" name="fromdate"></td>
                            <td>
                                <label for="todate">
                                    To Date
                                </label>
                            </td>
                                <td><input type="date" class="form-control" id="todate" name="todate"></td>
                            <td><button type="submit" class="btn btn-primary" >FILTER</button></td>
                            </form> </tr>
                    </table>
                    <div id="MessageHist">
                    <?php
                    if ($fromdate!=''){
                        if ($todate!=''){
                            $table_name = "select alerts.alert_id,alerts.alert_date_time,alerts.is_active,alerts.alert_level_id,alerts.alert_description from
(select a.alert_id,a.alert_date_time,a.is_active,a.alert_level_id,b.alert_description,DATE(a.alert_date_time) as alert_date
from alert_system a,alert_category b where a.alert_level_id=b.alert_level_id and
a.region_id='$screenData[region_id]' ) alerts
where alerts.alert_date between '$fromdate' and '$todate';";
                        }
                    }else{
                        $table_name ="select a.alert_id,a.alert_date_time,a.is_active,a.alert_level_id,b.alert_description from alert_system a,alert_category b where a.alert_level_id=b.alert_level_id
                    and a.region_id='$screenData[region_id]'";
                    }
                   // echo $table_name;

                    //$table_name ="select a.alert_id,a.alert_date_time,a.is_active,a.alert_level_id,b.alert_description from alert_system a,alert_category b where a.alert_level_id=b.alert_level_id
                    //and a.region_id='$screenData[region_id]'";
                    //$table_name = "select alert_id,alert_desc,population,alert_date_time from alerts_view where region_id='$screenData[region_id]'";
                    $url="../COM353/alerts/alert_view.php?region_id=$screenData[region_id]";
                    displayTableByCols($table_name,$url)
                    ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

</body>
</html>
