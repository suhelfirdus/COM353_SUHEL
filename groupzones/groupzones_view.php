<?php
include '../UICommon/template.php' ;
include 'groupzones_functions.php' ;
//$q = $_GET['city_id'];
$q =(isset($_GET['zone_id'])) ? $_GET['zone_id'] : $_SESSION["zone_id"];
//echo $q;
$QueryToRun="SELECT * FROM group_zones_det_view WHERE zone_id=$q";
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
                    <button type="submit" class="btn btn-primary" name="add_new_groupzones">
                        Add New Group Zone
                    </button>
                    <!-- Button to call a new Operation  ends -->

                    <div class="form-group">
                     <label for="zone_id">
                            Zone Id
                        </label>
                        <input type="text" class="form-control" id="zone_id"  name="zone_id" value="<?php echo @$screenData['zone_id']?>" readonly required/>
                    </div>

                        <div class="form-group">
                        <label for="zone_name">
                            Zone Name
                        </label>
                        <input type="text" class="form-control" id="zone_name"  name="zone_name" value="<?php echo @$screenData['zone_name']?>" required/>

                </div>
                        <button type="submit" class="btn btn-primary" name="save_zone" >
                            Save
                        </button>
                        <button type="submit" class="btn btn-primary" name="delete_zone">
                            Delete
                        </button>
<hr>




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

function update_zone($zone_id)
{
    global $mysqli;
    //print_r($_POST);
    $zone_id = e($_POST['zone_id']);
    $zone_name = e($_POST['zone_name']);

    $query = "UPDATE `group_zones` SET `zone_name` = '$zone_name'  WHERE `group_zones`.`zone_id` = $zone_id";
    //echo $query;
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }

    $_SESSION["zone_id"]=$zone_id;
    return $zone_id;
}
?>

</html>

