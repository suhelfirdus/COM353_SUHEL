<?php
include '../UICommon/template.php' ;
include 'person_functions.php' ;
$q =(isset($_GET['person_id'])) ? $_GET['person_id'] : $_SESSION["person_id"];
$QueryToRun="SELECT * FROM person_det_view WHERE person_id='$q'";
$screenData=getBulkData($QueryToRun);
?>
<head>
    <script>
        function enableHealthFacilty() {
            //alert(document.getElementById('is_health_worker').value)

            if(document.getElementById('is_health_worker').value=="Yes"){
                document.getElementById('health_facility').disabled=false;
            }
            if(document.getElementById('is_health_worker').value=="No"){
                document.getElementById('health_facility').disabled=true;
                document.getElementById('health_facility').innerText='';
            }
        }


    </script>
    <script>
        function setValue() {
            //alert('hello    1'+document.getElementById('zip_id').value);
            //alert(document.getElementById('city_id').value);
            document.getElementById('city_code').value=document.getElementById('city_id').value;
            document.getElementById('new_postal').value=document.getElementById('zip_id').value;

           //alert(document.getElementById('new_postal').value);
        }





        function showCities(str) {

            alert(str);
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                        //alert(this.responseText);
                    }
                };

                xmlhttp.open("GET","person_ajax.php?q="+str,true);
                xmlhttp.send();
            }
        }


        function showZip(str) {

            alert(str);
            if (str == "") {
                document.getElementById("txtZip").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtZip").innerHTML = this.responseText;
                        //alert(this.responseText);
                    }
                };

                xmlhttp.open("GET","getzip_ajax.php?q="+str,true);
                xmlhttp.send();
            }
        }


    </script>
</head>
<body>



<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <?php
            include '../admin/admin_menu.php' ;
            ?>

        </div>

        <div class="col-md-4">
            <form class="form-horizontal" method="post" onsubmit="setValue()" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <button type="submit" class="btn btn-primary" name="add_new_person">
                    Add New person
                </button>

                <div class="form-group">
                    <label for="person_id">
                        Person No
                    </label>


                    <input type="text" class="form-control" id="person_id"  name="person_id"  value="<?php echo $screenData['person_id']?>" readonly/>
                </div>

                <div class="form-group">
                    <label for="first_name">
                        First Name
                    </label>
                    <input type="text" class="form-control" id="first_name"  name ="first_name" value="<?php echo $screenData['first_name']?>" required/>
                </div>
                <div class="form-group">
                    <label for="last_name">
                        Last Name
                    </label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo $screenData['last_name']?>" required/>
                </div>

                <div class="form-group">
                    <label for="gender">
                        Gender
                    </label>
                    <select name="gender" id="gender">
                        <option value=<?php echo $screenData['gender']?>><?php echo $screenData['gender']?></option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Unknown">Unknown</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="citizenship">
                        Citizenship
                    </label>
                    <input type="text" class="form-control" id="citizenship" name="citizenship" value="<?php echo @$screenData['citizenship']?>" required/>
                </div>

                <div class="form-group">
                    <label for="fathers_name">
                        Father's Name
                    </label>
                    <input type="text" class="form-control" id="fathers_name" name="fathers_name" value="<?php echo @$screenData['fathers_name']?>" required/>
                </div>

                <div class="form-group">
                    <label for="mothers_name">
                        Mother's Name
                    </label>
                    <input type="text" class="form-control" id="fathers_name" name="mothers_name" value="<?php echo @$screenData['mothers_name']?>" required/>
                </div>


                <div class="form-group">
                    <label for="DOB">
                        Date of Birth
                    </label>
                    <input type="date" class="form-control" id="dob" name ="dob" value="<?php echo $screenData['date_of_birth']?>" required/>
                </div>
                <div class="form-group">
                    <label for="medicare_number">
                        Medicare Number
                    </label>
                    <input type="text" class="form-control" id="medicare_number" name ="medicare_number" value="<?php echo $screenData['medicare_number']?>"required/>
                </div>

                <div class="form-group">
                    <label for="is_health_worker">
                        Health Worker??
                    </label>
                    <select name="is_health_worker" id="is_health_worker" required onchange="enableHealthFacilty()">
                        <option value=<?php echo $screenData['is_health_worker']?>><?php echo $screenData['is_health_worker']?></option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </div>
                <!--<div class="form-group">
                        <label for="health_facility">
                            Health Facilty
                        </label>
                        <input type="text" class="form-control" id="health_facility" name ="health_facility" value="<?php echo @$screenData['health_facility']?>" disabled/>
                    </div> -->

                <div class="form-group">
                    <label for="health_facility">
                        Health Facility
                    </label>

                    <select name="health_facility" id="health_facility" disabled>
                        <?php echo  "<option value=$screenData[health_facility_id]>$screenData[facility_name]</option>" ?>
                        <?php echo $region=getHealthFacilities();
                        ?>
                    </select>
                </div>



                <!--<div class="form-group">
                    <label for="related_person_no">
                        Related Person No
                    </label>
                    <select name="related_person_no" id="related_person_no" required>
                        <?php echo  "<option value=$screenData[related_person_no]>$screenData[related_person_no]</option>"?>
                        <?php echo $allpersons=getRelatedPerson();
                        ?>
                    </select>
                </div> -->


                <button type="submit" class="btn btn-primary" name="update_person_btn" >
                    Save Person
                </button>
                <button type="submit" class="btn btn-primary" name="delete_person">
                    Delete Person
                </button>
        </div>
        <!-- Second column-->
        <div class="col-md-4">


            <div class="form-group">
                <label for="email_address">
                    Email address
                </label>
                <input type="email" class="form-control" id="email_address" name="email_address" value="<?php echo $screenData['email_address']?>" required/>
            </div>
            <div class="form-group">
                <label for="phone_number">
                    Phone Number
                </label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $screenData['phone_number']?>" required/>
            </div>
            <div class="form-group">
                <label for="street_address">
                    Street Address
                </label>
                <input type="text" class="form-control" id="street_address" name="street_address"  value="<?php echo $screenData['street_address']?>" required/>
            </div>

            <div class="form-group">
                <label for="region_name">
                    Select a Region
                </label>
                <!--<input type="text" class="form-control" id="region_name"  name="region_name" value="<?php echo $screenData['region_name']?>" /> -->

                <select name="region_name" id="region_name" onchange="showCities(this.value)" required>
                    <?php echo  "<option value=$screenData[region_name]>$screenData[region_name]</option>"?>
                    <?php echo $region=getRegions();
                    ?>
                </select>
            </div>

            <div id="txtHint">
                <label for="city_id">
                    City
                </label>
                <select name="city_name" id="city_name"  onchange="showZip(this.value)" required>
                    <?php echo  "<option value=$screenData[city_id]>$screenData[city_name]</option>"?>
                    <option value='0'> ---Select City-- </option>
                </select>
            </div>


            <div class="form-group">

                <input type="hidden" class="form-control" id="city_code" name="city_code" value="<?php echo $screenData['city_id']?>" required/>

            </div>

            <div class="form-group">

                <input type="hidden" class="form-control" name ="new_postal" id="new_postal" value="<?php echo $screenData['postal_code']?>" required/>
            </div>

            <div id="txtZip">
                <label for="zip_id">
                    Postal Code
                </label>
                <select name="zip_id" id="zip_id" required>
                    <?php echo  "<option value=$screenData[postal_code]>$screenData[postal_code]</option>"?>
                    <option value='0'> ---Select Zip-- </option>
                </select>
            </div>


            <!--<div class="form-group">
                <label for="province">
                    Province
                </label>
                <input type="text" class="form-control" id="province" name="province" required/>
            </div>-->
        </div>

        </form>






        <div class="col-md-12">
            <span class="badge badge-default">TEST HISTORY</span>
            <table class="table">
                <?php
                //echo "<b>Test History</b>";
                //displayTableByCols
               // select test_id,performed_at,tested_by,test_date,result_date,result from diagnostic_det_view order by result_date
                $table_name = "select pkey,screenname,test_id,performed_at,tested_by,test_date,result_date,result from diagnostic_det_view where person_id='$screenData[person_id]'";
                $url='covidtest';
                //displayTable($table_name);
                displayTableByCols($table_name,$url);
                ?>

            </table>
        </div>


        <div class="col-md-12">
            <span class="badge badge-default">MESSAGES HISTORY</span>
            <table class="table">
                <?php
                //echo "<b>Message History</b>";
                $table_name = "messages WHERE person_id='$screenData[person_id]'";
                displayTable($table_name);
                ?>

            </table>
        </div>


    </div>


</body>
<?php
function update_ui_person($person_id)
{

    global $mysqli;
    $_SESSION["person_id"]=$person_id;
    //$person_id = e($_POST['person_id']);
    $first_name=e($_POST['first_name']);
    $last_name=e($_POST['last_name']);
    $dob=e($_POST['dob']);
    $is_health_worker=e($_POST['is_health_worker']);
    //$related_person_no=e($_POST['related_person_no']);
    $medicare_no=e($_POST['medicare_number']);

    $gender=e($_POST['gender']);
    $citizenship=e($_POST['citizenship']);
    //$fatherno=e($_POST['fathers_no']);
    $fatherno=(isset($_POST['fathers_name'])) ? $_POST['fathers_name'] : 0;
    $motherno=(isset($_POST['mothers_name'])) ? $_POST['mothers_name'] : 0;
   // echo  $fatherno ;
   // echo  $motherno;

    //$motherno=e($_POST['mothers_no']);
    $successFlag='Y';
    if ($is_health_worker=='No')
    {
        $health_facility_id='';
    }
    else{
        $health_facility_id=e($_POST['health_facility']);
    }




    //$query = "UPDATE `person` SET `first_name` = '$first_name', `last_name` = '$last_name' ,`dob` = '$dob' ,`medicare_number` = '$medicare_no',`is_health_worker` = '$is_health_worker' ,`related_person_no` = '$related_person_no'   WHERE `person`.`person_id` = $person_id";
    $query = "UPDATE `person` SET `mothers_name`='$motherno',`fathers_name`='$fatherno', `citizenship`='$citizenship',`gender`='$gender', `health_facility_id`='$health_facility_id', `dob` = '$dob',`is_health_worker` = '$is_health_worker',`first_name` = '$first_name',`last_name` = '$last_name',`medicare_number` = '$medicare_no' WHERE `person`.`person_id` = $person_id";
    //echo  $query;
    if ($mysqli->query($query) === TRUE) {

        $successFlag='Y';
    } else {

        $successFlag='N';
    }
    //echo"address update";
    $email_address = e($_POST['email_address']);
    $phone_number = e($_POST['phone_number']);
    $street_address = e($_POST['street_address']);
    //$province = e($_POST['province']);
    $region_name = e($_POST['region_name']);
    //print_r($_POST);
    $city_id = e($_POST['city_code']);
    $postal_code = e($_POST['new_postal']);
    //$postal_code = e($_POST['zip_id']);
    echo $postal_code;

    //$query = "UPDATE `address` SET `email_address` = '$email_address', `phone_number` = '$phone_number' ,`street_address` = '$street_address' ,`is_health_worker` = '$is_health_worker' ,`province` = '$province'   WHERE `address`.`person_id` = '$person_id'";
    $query = "UPDATE `address` SET  `city_id` = '$city_id' ,   `postal_code` = '$postal_code',`street_address` = '$street_address',`phone_number` = '$phone_number',`email_address` = '$email_address' where `address`.`person_id` = $person_id";


    if ($mysqli->query($query) === TRUE) {
        $successFlag='Y';
    } else {
        $successFlag='N';
    }

    $queryUpd ="update address set region_id=(select region_id from region where region_name='$region_name') where person_id=$person_id";
   if ($mysqli->query($queryUpd) === TRUE) {
        $successFlag='Y';
    } else {
       $successFlag='N';
    }
    $mysqli->close();
    if ($successFlag=='Y'){
        echo "<script>alert('Person Saved Successfully')</script>";
    }else{
        echo "<script>alert('Error Saving')</script>";
    }

    return $person_id;
}
?>

</html>
