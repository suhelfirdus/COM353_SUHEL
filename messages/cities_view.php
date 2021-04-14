<?php
include '../UICommon/template.php' ;
include 'cities_functions.php' ;
$q = $_GET['city_id'];
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

                        <div class="form-group">
                            <label for="province_name">
                                Province Name
                            </label>
                            <select name="province_name" id="province_name" >
                                <option value='<?php echo $screenData['province']?>'><?php echo $screenData['province']?></option>
                                <option value="0"> -- Select Province -- </option>
                                <option value="AB">Alberta</option>
                                <option value="BC">British Columbia</option>
                                <option value="MB">Manitoba</option>
                                <option value="NB">New Brunswick</option>
                                <option value="NL">Newfoundland and Labrador</option>
                                <option value="NS">Nova Scotia</option>
                                <option value="ON">Ontario</option>
                                <option value="PE">Prince Edward Island</option>
                                <option value="QC">Quebec</option>
                                <option value="SK">Saskatchewan</option>
                                <option value="NT">Northwest Territories</option>
                                <option value="NU">Nunavut</option>
                                <option value="YT">Yukon</option>
                            </select>

                        </div>

                        <button type="submit" class="btn btn-primary" name="save_city" >
                            Save
                        </button>
                        <button type="submit" class="btn btn-primary" name="delete_city">
                            Delete
                        </button>




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

function update_city($city_id)
{
    global $db;
    print_r($_POST);
    $city_id = e($_POST['city_id']);
    $city_name = e($_POST['city_name']);
    $region_name = e($_POST['region_name']);
    $province_name = e($_POST['province_name']);


    $query = "UPDATE `city` SET `city_name` = '$city_name',`province`='$province_name' WHERE `city`.`city_id` = $city_id";

    if ($db->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $query = "UPDATE `city` SET `region_id` = (select region_id from region where region_name='$region_name') WHERE `city`.`city_id` = $city_id";
    echo $query;
    if ($db->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $db->close();
    return $city_id;
}
?>

</html>

