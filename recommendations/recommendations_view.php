<?php
include '../UICommon/template.php' ;
include 'recommendations_functions.php' ;
//$q = $_GET['rec_id'];
//echo $q;
$q =(isset($_GET['rec_id'])) ? $_GET['region_id'] : $_SESSION["rec_id"];
$QueryToRun="SELECT * FROM recommendations WHERE rec_id=$q";
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
                    <button type="submit" class="btn btn-primary" name="add_new_recommendation">
                        Add New Recommendation
                    </button>
                    <!-- Button to call a new Operation  ends -->

                    <div class="form-group">
                        <label for="rec_id">
                            Recommendation Id
                        </label>
                        <input type="text" class="form-control" id="rec_id"  name="rec_id" value="<?php echo $screenData['rec_id']?>" readonly required/>

                    </div>
                    <div class="form-group">
                        <label for="rec_name">
                            Recommendation Name
                        </label>
                        <input type="text" class="form-control" id="rec_name" name="rec_name" value="<?php echo $screenData['rec_name']?>" required/>
                    </div>

                        <div class="form-group">
                            <label for="rec_date">
                                Recommendation Date
                            </label>
                            <input type="date" class="form-control" id="rec_date" name="rec_date" value="<?php echo $screenData['rec_date']?>" required/>
                        </div>

                        <div class="form-group">
                            <label for="rec_text">
                                Recommendation Text
                            </label>
                        <textarea id="rec_text" name="rec_text" rows="10" cols="55">
                          <?php echo $screenData['rec_text']?>
                        </textarea>
                        </div>


                    <button type="submit" class="btn btn-primary" name="update_recommendation_btn" >
                        Save
                    </button>
                    <button type="submit" class="btn btn-primary" name="delete_recommendations_btn">
                        Delete
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

?>

</html>

