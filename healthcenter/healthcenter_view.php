<?php
include '../UICommon/template.php' ;
include 'healthcenter_functions.php' ;
$q = $_GET['facility_id'];
//echo $q;
$QueryToRun="SELECT * FROM publichealthcentres_det_view WHERE facility_id='$q'";

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
                    <button type="submit" class="btn btn-primary" name="add_new_Public_health_center">
                        Add New Public Health Center
                    </button>
                    <!-- Button to call a new Operation  ends -->

                    <div class="form-group">
                        <label for="facility_id">
                            Facility Id
                        </label>
                        <input type="text" class="form-control" id="facility_id"  name="facility_id" value="<?php echo $screenData['facility_id']?>"/>

                    </div>
                    <div class="form-group">
                        <label for="facility_name">
                            Facility Name
                        </label>
                        <input type="text" class="form-control" id="facility_name" name="facility_name" value="<?php echo $screenData['facility_name']?>"/>
                    </div>

                    <div class="form-group">
                        <label for="address">
                            Address
                        </label>
                        <input type="text" class="form-control" id="address" name="address"  value="<?php echo $screenData['address']?>"/>
                    </div>

                        <div class="form-group">
                            <label for="web_address">
                                Web Address
                            </label>
                            <input type="text" class="form-control" id="web_address" name="web_address"  value="<?php echo $screenData['web_address']?>"/>
                        </div>


                        <div class="form-group">
                            <label for="phone_number">
                                Phone Number
                            </label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number"  value="<?php echo $screenData['phone_number']?>"/>
                        </div>

                        <div class="form-group">
                            <label for="type">
                                Type
                            </label>
                            <input type="text" class="form-control" id="type" name="type"  value="<?php echo $screenData['type']?>"/>
                        </div>

                        <div class="form-group">
                            <label for="operating_zone">
                                Operating Zone
                            </label>
                            <input type="text" class="form-control" id="operating_zone" name="operating_zone"  value="<?php echo $screenData['operating_zone']?>"/>
                        </div>

                        <div class="form-group">
                            <label for="method_of_acceptance">
                                Method of Acceptance
                            </label>
                        <select id="method_of_acceptance" name="method_of_acceptance" >
                            <option value="All"<?=$screenData['method_of_acceptance'] == 'All' ? ' selected="selected"' : '';?>>All</option>
                            <option value="Walk In"<?=$screenData['method_of_acceptance'] == 'Walk In' ? ' selected="selected"' : '';?>>Walk In</option>
                            <option value="Appointment Only"<?=$screenData['method_of_acceptance'] == 'Appointment Only' ? ' selected="selected"' : '';?>>Appointment Only</option>
                            <option value="Urgent Care"<?=$screenData['method_of_acceptance'] == 'Urgent Care' ? ' selected="selected"' : '';?>>Urgent Care</option>
                        </select>
                        </div>
                        <div class="form-group">
                            <label for="has_drive_through">
                                Method of Acceptance
                            </label>
                            <select id="has_drive_through" name="has_drive_through" >
                                <option value="X"<?=$screenData['has_drive_through'] == '' ? ' selected="selected"' : '';?>> </option>
                                <option value="Y"<?=$screenData['has_drive_through'] == 'Y' ? ' selected="selected"' : '';?>>Yes</option>
                                <option value="N"<?=$screenData['has_drive_through'] == 'N' ? ' selected="selected"' : '';?>>No</option>
                            </select>
                        </div>
                        <!--<div class="form-group">
                            <label for="method_of_acceptance">
                                Method of Acceptance
                            </label>
                            <input type="text" class="form-control" id="method_of_acceptance" name="method_of_acceptance"  value="<?php echo $screenData['method_of_acceptance']?>"/>
                        </div> -->

                       <!-- <div class="form-group">
                            <label for="has_drive_through">
                                Drive Through?
                            </label>
                            <input type="text" class="form-control" id="has_drive_through" name="has_drive_through"  value="<?php echo $screenData['has_drive_through']?>"/>
                        </div> -->






                    <button type="submit" class="btn btn-primary" name="update_Public_health_center" >
                        Save Public Health Center
                    </button>
                    <button type="submit" class="btn btn-primary" name="delete_Public_health_center">
                        Delete Public Health Center
                    </button>
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

</html>

