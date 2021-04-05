<?php
include '../UICommon/template.php' ;
include 'cities_functions.php' ;
$q = $_GET['city_id'];
//echo $q;
$QueryToRun="SELECT * FROM cities_view WHERE city_id=$q";
//echo $QueryToRun;
$screenData=getBulkData($QueryToRun);
?>
<body>



<!-- First Columns is always the menu -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <?php
                include '../admin/admin_menu.php' ;
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
                            <select>
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

                        <button type="submit" class="btn btn-primary" name="set_new_alert_save" >
                            Save
                        </button>
                        <button type="submit" class="btn btn-primary" name="delete_newRegion_btn">
                            Cancel
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

</html>

