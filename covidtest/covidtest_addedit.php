<?php
include '../UICommon/template.php' ;
include 'covidtest_functions.php' ;
$q = $_GET['test_id'];
//echo $q;
$QueryToRun="SELECT * FROM diagnostic WHERE test_id=$q";
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
                <button type="submit" class="btn btn-primary" name="add_new_covidtest">
                    Add New Test
                </button>
                <!-- Button to call a new Operation  ends -->
                <!-- Second column-->
                <div class="form-group">
                    <label for="test_id">
                        Test Id
                    </label>
                    <input type="text" class="form-control" id="test_id"  name="test_id" value="<?php echo (isset($screenData['test_id'])) ? $screenData['test_id'] : null ?>" readonly required/>

                </div>

                <div class="form-group">
                    <label for="person_id">
                        Person No/Name
                    </label>
                    <select name="person_id" id="person_id" value="<?php echo (isset($screenData['person_id'])) ? $screenData['person_id'] : null ?>"  required/>
                    <?php echo $allpersons=getRelatedPerson();
                    ?>
                    </select>
                </div>




                <div class="form-group">
                    <label for="test_date">
                        Test Date
                    </label>
                    <input type="date" class="form-control" id="test_date"  name="test_date" value="<?php echo (isset($screenData['test_date'])) ? $screenData['test_date'] : null ?>"  required/>

                </div>

                <div class="form-group">
                    <label for="test_center">
                        Test Center No/Name
                    </label>
                    <select name="test_center" id="test_center" required/>
                    <?php echo $alltestcenters=getAllHealthCenters();
                    ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="tested_by">
                        Test Performed By
                    </label>
                    <select name="tested_by" id="tested_by">
                        <?php echo $allpersons=getRelatedPerson();
                        ?>

                    </select>
                </div>

                <div class="form-group">
                    <label for="result_date">
                        Result Date
                    </label>
                    <input type="date" class="form-control" id="result_date"  name="result_date" value="<?php echo (isset($screenData['result_date'])) ? $screenData['result_date'] : null ?>" />

                </div>

                <div class="form-group">
                    <label for="result">
                        Result
                    </label>

                    <select id="test_result" name="test_result" value="<?php echo (isset($screenData['test_result'])) ? $screenData['test_result'] : null ?>" />
                    <option value="Not Avl">Result Not Available Yet</option>
                    <option value="Positive">Positive</option>
                    <option value="Negative">Negative</option>

                    </select>
                </div>

                <button type="submit" class="btn btn-primary" name="update_covidtest_btn" >
                    Save Test
                </button>
                <button type="submit" class="btn btn-primary" name="delete_covidtest">
                    Delete Test
                </button>



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

