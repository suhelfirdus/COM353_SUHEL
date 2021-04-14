<?php
include '../UICommon/template.php' ;
include 'alert_functions.php' ;
//$q = $_GET['region_id'];
$q =(isset($_GET['region_id'])) ? $_GET['region_id'] : $_SESSION["region_id"];
//echo $q;

$QueryToRun="SELECT * FROM alerts_view WHERE region_id='$q'";
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
                <div class="form-group">
                    <label for="region_name">
                        Select a Region
                    </label>
                    <!--<input type="text" class="form-control" id="region_name"  name="region_name" value="<?php echo (isset($screenData['region_id'])) ? $screenData['region_id'] : null ?>"/> -->

                    <select name="region_name" id="region_name" >
                        <?php echo $region=getRegions();
                        ?>
                    </select>

                </div>
                <button type="submit" class="btn btn-primary" name="set_new_alert_init">
                    SEARCH
                </button>
                <!-- Button to call a new Operation  ends -->

                <div class="form-group">

                    <input type="hidden" class="form-control" id="region_id"  name="region_id" value="<?php echo (isset($screenData['region_id'])) ? $screenData['region_id'] : null ?>"/>

                </div>


                <div class="form-group">
                    <label for="region_name2">
                        Region Name
                    </label>
                    <input type="text" class="form-control" id="region_name2"  name="region_name2" value="<?php echo (isset($screenData['region_name'])) ? $screenData['region_name'] : null ?>" readonly required/>

                </div>

                <div class="form-group">
                    <label for="current_active_alert">
                        Current Active Alert
                    </label>

                    <input type="text" class="form-control" id="current_active_alert"  name="current_active_alert" value="<?php echo (isset($screenData['alert_desc'])) ? $screenData['alert_desc'] : null?>" readonly required/>

                </div>

                <div class="form-group">
                    <label for="alert_date_time">
                        Current Active Alert Issued Date
                    </label>
                    <input type="text" class="form-control" id="alert_date_time"  name="alert_date_time" value="<?php echo (isset($screenData['alert_date_time'])) ? $screenData['alert_date_time'] : null?>" readonly required/>

                </div>

                <div class="form-group">
                    <label for="population">
                        Population in this Region
                    </label>
                    <input type="text" class="form-control" id="population"  name="population"  value="<?php echo (isset($screenData['population'])) ? $screenData['population'] : null?>" readonly required/>

                </div>

              <!--  <div class="form-group">
                    <label for="change_alert_to">
                        Set a New Alert
                    </label>
                    <input type="text" class="form-control" id="change_alert_to"  name="change_alert_to" " />

                </div> -->

                <div class="form-group">
                    <label for="notify_people">
                        Notify People About New Alert
                    </label>
                    <select name="notify_people" id="notify_people">
                        <option value="Y">Yes</option>
                        <option value="N">No</option>
                    </select>

                </div>

                <div class="form-group">
                    <label for="email_template">
                        Recommendation Email Template
                    </label>
                    <select name="email_template" id="email_template">
                        <?php echo getEmailTemplate();?>
                    </select>

                </div>


                <div class="form-group">
                    <label for="change_alert_to">
                        Select Next Alert
                    </label>
                    <!--<input type="text" class="form-control" id="region_name"  name="region_name" value="<?php echo (isset($screenData['region_id'])) ? $screenData['region_id'] : null ?>"/> -->

                    <select name="change_alert_to" id="change_alert_to" >
                        <?php echo getNextAlert($screenData['region_name']);
                        ?>
                    </select>

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


                <button type="submit" class="btn btn-primary" name="set_new_alert_save" >
                    Save
                </button>
                <button type="submit" class="btn btn-primary" name="delete_alert">
                    Cancel
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
<?php
function set_new_alert_save()
{


    global $mysqli;
    $region_id = e($_POST['region_id']);
    $region_name = e($_POST['region_name2']);
    $current_alert = e($_POST['current_active_alert']);
    $current_active_alert = e($_POST['current_active_alert']);
    $change_alert_to = e($_POST['change_alert_to']);
    $notify_people = e($_POST['notify_people']);
    $email_rec = e($_POST['email_template']);
    $active="N";
    $newstatus="Y";

    //echo "$region_id ".$region_id;
    //echo "$region_name".$region_name;
    //echo "$change_alert_to" .$change_alert_to;
    //echo "$notify_people" .$notify_people;



    $query="update alert_system set is_active='$active' where region_id='$region_id'";
    $queryinsert="insert into alert_system(region_id,alert_level_id,is_active,notify_people,email_rec_id,alert_type) values($region_id,'$change_alert_to','$newstatus','$notify_people','$email_rec','GENERAL')";
    //echo  $queryinsert;
    if ($mysqli->query($query) === TRUE) {
        echo "<b>Record updated successfully</b>";
    } else {
        echo "Error updating record: " . $query->error;
    }

    if ($mysqli->query($queryinsert) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }
    $mysqli->close();
    $_SESSION["region_id"]=$region_id;
    return $region_name;

}
?>

</html>

