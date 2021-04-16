<?php
include '../UICommon/template.php' ;
include 'cities_functions.php' ;
//$q = $_GET['city_id'];
$q =(isset($_GET['city_id'])) ? $_GET['city_id'] : $_SESSION["city_id"];
//echo $q;
$QueryToRun="SELECT * FROM cities_det_view WHERE city_id=$q";
//echo $QueryToRun;
$screenData=getBulkData($QueryToRun);
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
                    <button type="submit" class="btn btn-primary" name="add_new_city">
                        Add New City
                    </button>
                    <!-- Button to call a new Operation  ends -->

                    <div class="form-group">
                     <label for="city_id">
                            City Id
                        </label>
                        <input type="text" class="form-control" id="city_id"  name="city_id" value="<?php echo $screenData['city_id']?>" readonly required/>
                    </div>

                        <div class="form-group">
                        <label for="city_name">
                            City Name
                        </label>
                        <input type="text" class="form-control" id="city_name"  name="city_name" value="<?php echo $screenData['city_name']?>" required/>

                </div>

                        <div class="form-group">
                            <label for="region_name">
                                Region Name
                            </label>
                            <select name="region_name" id="region_name" >
                               <option value='<?php echo $screenData['region_name']?>'><?php echo $screenData['region_name']?></option>
                                <option value="0"> -- Select Region -- </option>
                                <?php echo $region=getRegions();
                                ?>
                            </select>
                        </div>



                        <button type="submit" class="btn btn-primary" name="save_city" >
                            Save
                        </button>
                        <button type="submit" class="btn btn-primary" name="delete_city">
                            Delete
                        </button>
<hr>
                        <div class="form-group">
                            <label for="zip_code">
                                Postal Code
                            </label>
                            <input type="text"  class="form-control" id="zip_code"  name="zip_code" size="10"/>
                        </div>
                            <button type="submit" class="btn btn-primary" name="SAVE_POSTAL">
                                Save Zip Code
                            </button>
                        </div>
<hr>


            <!--</form>-->
<form>
    <div class="col-md-4">
        <?php

        $query = "select postal_code from cityzipcodes where city_id=$q";
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
                echo "</tr>";
                echo "</row>";
            }
        }

        ?>
    </div>
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

function update_city($city_id)
{
    global $mysqli;
    //print_r($_POST);
    $city_id = e($_POST['city_id']);
    $city_name = e($_POST['city_name']);
    $region_name = e($_POST['region_name']);



    $query = "UPDATE `city` SET `city_name` = '$city_name'  WHERE `city`.`city_id` = $city_id";

    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $query = "UPDATE `city` SET `region_id` = (select region_id from region where region_name='$region_name') WHERE `city`.`city_id` = $city_id";
    //echo $query;
    if ($mysqli->query($query) === TRUE) {
        echo " ";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    $_SESSION["city_id"]=$city_id;
    return $city_id;
}
?>
<?php

?>

</html>

