<?php
include '../UICommon/template.php' ;
include 'emptest_functions.php' ;
$q = $_GET['test_id'];
//echo $q;
$QueryToRun="SELECT * FROM diagnostic_det_view WHERE test_id=$q";
//echo $QueryToRun;
$screenData=getBulkData($QueryToRun);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Sign-in Page</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>


<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <!-- First Columns is always the menu starts-->
    <div class="container-fluid">
        <div class="row">

            <!-- First Columns is always the menu ends-->
            <div class="col-md-2">
                <?php
                include '../admin/admin_menu.php';
                ?>
            </div>
            <!-- First Columns is always the menu ends-->

            <div class="form-group">
                <label for="test_id">
                    <!-- Test Id-->
                </label>
                <input type="hidden" class="form-control" id="test_id"  name="test_id"  value="<?php echo $screenData['test_id']?>" readonly/>
            </div>

            <!-- Second Columns starts-->
            <div class="col-md-4">
                <table class="table">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col" style="text-transform: uppercase">Employee Details</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th scope="row">Person ID</th>
                        <td><?php echo (isset($screenData['person_id'])) ? $screenData['person_id'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">First Name</th>
                        <td><?php echo (isset($screenData['first_name'])) ? $screenData['first_name'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Last Name</th>
                        <td><?php echo (isset($screenData['last_name'])) ? $screenData['last_name'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Date Of Birth</th>
                        <td><?php echo (isset($screenData['DOB'])) ? $screenData['DOB'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Medicare Number</th>
                        <td><?php echo (isset($screenData['medicare_number'])) ? $screenData['medicare_number'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Street Address</th>
                        <td><?php echo (isset($screenData['street_address'])) ? $screenData['street_address'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Province</th>
                        <td><?php echo (isset($screenData['province'])) ? $screenData['province'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Postal Code</th>
                        <td><?php echo (isset($screenData['postal_code'])) ? $screenData['postal_code'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Phone Number</th>
                        <td><?php echo (isset($screenData['ph_phone_number'])) ? $screenData['ph_phone_number'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td><?php echo (isset($screenData['email_address'])) ? $screenData['email_address'] : null ?></td>
                    </tr>
                    <tr>
                        <th scope="row">Region Name</th>
                        <td><?php echo (isset($screenData['region_name'])) ? $screenData['region_name'] : null ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- Second Columns ends-->

            <!-- Third column starts-->
            <div class="col-md-4"">
            <table class="table">
                <tr>
                    <th style="text-transform: uppercase">Test Center Details</th>
                    <th></th>
                </tr>
                <tr>
                    <td>Test Center Id</td>
                    <td><?php echo (isset($screenData['facility_id'])) ? $screenData['facility_id'] : null ?></td>
                </tr>
                <tr>
                    <td>Facility Name</td>
                    <td><?php echo (isset($screenData['facility_name'])) ? $screenData['facility_name'] : null ?></td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td><?php echo (isset($screenData['address'])) ? $screenData['address'] : null ?></td>
                </tr>
                <tr>
                    <td>Website</td>
                    <td><?php echo (isset($screenData['web_address'])) ? $screenData['web_address'] : null ?></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td><?php echo (isset($screenData['ph_phone_number'])) ? $screenData['ph_phone_number'] : null ?></td>
                </tr>
                <tr>
                    <td>Type</td>
                    <td><?php echo (isset($screenData['type'])) ? $screenData['type'] : null ?></td>
                </tr>
                <tr>
                    <td>Method of Acceptance</td>
                    <td><?php echo (isset($screenData['method_of_acceptance'])) ? $screenData['method_of_acceptance'] : null ?></td>
                </tr>
                <tr>
                    <td>Drive Through? </td>
                    <td><?php echo (isset($screenData['has_drive_through'])) ? $screenData['has_drive_through'] : null ?></td>
                </tr>
            </table>

            <table class="table">
                <tr>
                    <th style="text-transform: uppercase">Covid test Details</th>
                    <th></th>
                </tr>
                <tr>
                    <td>Test Id</td>
                    <td><?php echo (isset($screenData['person_id'])) ? $screenData['test_id'] : null ?></td>
                </tr>
                <tr>
                    <td>Testing Date</td>
                    <td><?php echo (isset($screenData['test_date'])) ? $screenData['test_date'] : null ?></td>
                </tr>
                <tr>
                    <td>Tested By Person ID</td>
                    <td><?php echo (isset($screenData['tested_by'])) ? $screenData['tested_by'] : null ?></td>
                </tr>
                <tr>
                    <td>Tested By Person Name</td>
                    <td><?php echo (isset($screenData['tested_by'])) ? getHealthWorkerNameById($screenData['tested_by']) : null ?></td>
                </tr>
                <tr>
                    <td>Result Date</td>
                    <td><?php echo (isset($screenData['result_date'])) ? $screenData['result_date'] : null ?></td>
                </tr>
                <tr>
                    <td>Result</td>
                    <td><?php echo (isset($screenData['result'])) ? $screenData['result'] : null ?></td>
                </tr>
            </table>

        </div>
        <!-- Third column ends-->
    </div>
</form>

<hr>
<div style="margin-top: 30px">
    <h4>
        People Who worked in the facility <?php echo  $screenData['facility_name']?> With <?php echo  $screenData['first_name']?> in 14 days window
    </h4>
    <table class="table">
        <?php
        global $db;
        $query = "select DATE_ADD('$screenData[test_date]', INTERVAL -14 DAY) as priordate";
        if($db->query($query) == true) {
            $result = $db->query($query);
            $row = $result->fetch_assoc();
            $fourdays=$row['priordate'];
        } else{
            $db->error(error_get_last());
        }
        $db->close();
        //echo $fourdays ;
        global $db;
        $query = "select * from
(select p.person_id,first_name,p.last_name,p.phone_number,p.email_address,w.schedule_date,w.facility_id from person_det_view p,
work_schedule  w where w.person_id=p.person_id) a
where a.schedule_date between '$fourdays' and '$screenData[test_date]'";

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
                //echo "<td><a href=emptest_view.php?test_id=". @$row['test_id'] . ">view</a>";
                echo "</tr>";

                echo "</row>";
            }
        }

        ?>
    </table>
</div>

</body>

</html>
