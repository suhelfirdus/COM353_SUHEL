<?php
include '../UICommon/template.php' ;
include 'region_functions.php' ;
$q = $_GET['region_id'];
//echo $q;
$QueryToRun="SELECT * FROM region_det_view WHERE REGION_ID=$q";
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
                <button type="submit" class="btn btn-primary" name="add_new_Region">
                    Add New Region
                </button>
                <!-- Button to call a new Operation  ends -->

                <div class="form-group">
                    <label for="region_id">
                        Region Id
                    </label>
                    <input type="text" class="form-control" id="region_id"  name="region_id" value="<?php echo $screenData['region_id']?>" readonly required/>

                </div>
                <div class="form-group">
                    <label for="region_name">
                        Region Name
                    </label>
                    <input type="text" class="form-control" id="region_name" name="region_name" value="<?php echo $screenData['region_name']?>" required/>
                </div>
                <button type="submit" class="btn btn-primary" name="update_newRegion_btn" >
                    Save Region
                </button>
                <button type="submit" class="btn btn-primary" name="delete_Region_btn">
                    Delete Region
                </button>
        </div>
        <hr>

         <div class="col-md-12">
            <span class="badge badge-default">cities</span>
            <table class="table">
                <?php
                //echo "<b>Related Persons</b>";
                $table_name = "cities_det_view where region_id='$screenData[region_id]'";
                displayTable($table_name);
                ?>

        </table>

    </div>

        <!-- Second column-->
        <div class="col-md-4">


            <!--</form>-->
            <form>


       <div class="row">
                    <div class="col-md-4">
                        <div class="col-md-4">


                        </div>
                    </div>
                    <div class="col-md-4">

                    </div>
                </div>
        </div>
    </div>

</body>

</html>
