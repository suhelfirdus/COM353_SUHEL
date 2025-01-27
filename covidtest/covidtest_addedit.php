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
            include '../admin/admin_menu.php';
            ?>
        </div>
        <!-- First Columns is always the menu ends-->

        <div class="col-md-4">
            <!-- Button to call a new Operation -->

            <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <button type="submit" class="btn btn-primary" name="ADD_NEW_COVIDTEST">
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
                    <option value="NA">Result Not Available Yet</option>
                    <option value="Positive">Positive</option>
                    <option value="Negative">Negative</option>

                    </select>
                </div>

                <button type="submit" class="btn btn-primary" name="update_covidtest_btn" >
                    Save Test
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
<?php
function update_ui_covidtest($test_id)
{

    global $mysqli;
    //$person_id = e($_POST['person_id']);
    $person_id=e($_POST['person_id']);
    $test_date=e($_POST['test_date']);
    $test_center=e($_POST['test_center']);
    $tested_by=e($_POST['tested_by']);
    //$result_date=e($_POST['result_date']);
    echo "before";
    $result_date=(isset($_POST['result_date'])) ? $_POST['result_date'] : '0000-00-00';
    if ($_POST['result_date']==''){
        $result_date='0000-00-00';

    }
    $test_result=e($_POST['test_result']);

    $query = "UPDATE `diagnostic` SET `result_date`='$result_date' ,`person_id` = $person_id,`tested_by` =$tested_by,`performed_at`= '$test_center', `test_date` = '$test_date' ,`result` = '$test_result' WHERE `diagnostic`.`test_id` = $test_id";
    //$query = "UPDATE `Diagnostic` SET `person_id` = $person_id ,`test_date` = '$test_date',test_center` = '$test_center' WHERE `DIAGNOSTICS `.`test_id`=$test_id";
    echo  $query;
    if ($mysqli->query($query) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $query->error;
    }

    return $test_id;
}
?>

</html>

