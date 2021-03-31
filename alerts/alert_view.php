<?php
include '../UICommon/template.php' ;
include 'alert_functions.php' ;
$q = $_GET['region_name'];
//echo $q;

$QueryToRun="SELECT * FROM alerts_view WHERE REGION_NAME='$q'";
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
                   <div class="form-group">
                            <label for="region_name">
                                Select a Region
                            </label>
                       <!--<input type="text" class="form-control" id="region_name"  name="region_name" value="<?php echo $screenData['region_name']?>"/> -->
                       //isset(screendata['region_name'])) ? echo screedata['region_name'] : "";
                       <select name="region_name" id="region_name" >
                           <?php echo $region=getRegions();
                           ?>
                       </select>

                    </div>
                    <button type="submit" class="btn btn-primary" name="set_new_alert">
                        Set New Alert
                    </button>
                    <!-- Button to call a new Operation  ends -->

                    <div class="form-group">
                        <label for="region_name2">
                            Region Name
                        </label>
                        <input type="text" class="form-control" id="region_name2"  name="region_name2" value="<?php echo $screenData['region_name']?>" readonly required/>

                    </div>

                        <div class="form-group">
                            <label for="current_active_alert">
                                Current Active Alert
                            </label>
                            <input type="text" class="form-control" id="current_active_alert"  name="region_name2" value="<?php echo $screenData['current_active_alert']?>" readonly required/>

                        </div>

                        <div class="form-group">
                            <label for="alert_date_time">
                               Current Active Alert Issued Date
                            </label>
                            <input type="date" class="form-control" id="alert_date_time"  name="alert_date_time" value="<?php echo $screenData['alert_date_time']?>" readonly required/>

                        </div>

                        <div class="form-group">
                            <label for="population">
                                Population in this Region
                            </label>
                            <input type="text" class="form-control" id="population"  name="population"  readonly required/>

                        </div>

                        <div class="form-group">
                            <label for="change_alert_to">
                                Set a New Alert
                            </label>
                            <input type="text" class="form-control" id="change_alert_to"  name="change_alert_to" " required/>

                        </div>



                   <!-- <div class="form-group">
                        <label for="region_name">
                            Region Name
                        </label>
                        <input type="text" class="form-control" id="region_name" name="region_name" value="<?php echo $screenData['region_name']?>" required/>
                    </div>

                    <div class="form-group">
                        <label for="current_active_alert">
                            Current Active Alert
                        </label>
                        <input type="text" class="form-control" id="current_active_alert" name="current_active_alert"  value="<?php echo $screenData['current_active_alert']?>" required/>
                    </div> -->


                    <button type="submit" class="btn btn-primary" name="update_newRegion_btn" >
                        Save <?php echo $screenData['screenname'] ?>
                    </button>
                    <button type="submit" class="btn btn-primary" name="delete_newRegion_btn">
                        Delete <?php echo $screenData['screenname'] ?>
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

