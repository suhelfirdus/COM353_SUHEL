<?php
include('../functions.php') ;
include 'admin_header.php' ;
$q = $_GET['person_id'];
//echo $q;
$QueryToRun="SELECT * FROM PERSON_DET_VIEW WHERE PERSON_ID=$q";
//echo $QueryToRun;
$screenData=getBulkData($QueryToRun);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Sign-in Page</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<!--<div class="jumbotron text-center">
    <h1>COVID-19 Tracking App Registration Page</h1>
    <p>new patients should register with their Medicare Card Number and Date of Birth</p>
</div> -->

<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <?php
            include 'admin_menu.php' ;
            ?>

        </div>


            <form role="form">
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary" name="add_newPerson_btn">
                        add new person
                    </button>

                    <div class="form-group">
                        <label for="person_id">
                            Person No
                        </label>
                        <input type="text" class="form-control" id="person_id"  value="<?php echo $screenData['person_id']?>" readonly/>
                    </div>

                <div class="form-group">
                    <label for="first_name">
                        First Name
                    </label>
                    <input type="text" class="form-control" id="first_name"  value="<?php echo $screenData['first_name']?>"/>
                </div>
                <div class="form-group">
                    <label for="last_name">
                        Password
                    </label>
                    <input type="text" class="form-control" id="last_name" value="<?php echo $screenData['last_name']?>"/>
                </div>
                    <div class="form-group">
                        <label for="DOB">
                            Date of Birth
                        </label>
                        <input type="test" class="form-control" id="DOB" value="<?php echo $screenData['dob']?>"/>
                    </div>
                    <div class="form-group">
                        <label for="medicare_number">
                            Medicare Number
                        </label>
                        <input type="text" class="form-control" id="medicare_number" value="<?php echo $screenData['medicare_number']?>"/>
                    </div>

                    <div class="form-group">
                        <label for="is_health_worker">
                            Health Worker??
                        </label>
                        <input type="text" class="form-control" id="is_health_worker" value="<?php echo $screenData['is_health_worker']?>"/>
                    </div>

                    <div class="form-group">
                        <label for="related_person_no">
                            Related Person No
                        </label>
                        <input type="text" class="form-control" id="related_person_no" value="<?php echo $screenData['related_person_no']?>"/>
                    </div>





                <button type="submit" class="btn btn-primary" name="update_newPerson_btn" >
                       Save Person
                </button>
                    <button type="submit" class="btn btn-primary" name="delete_newPerson_btn">
                        Delete Person
                    </button>
                </div>
                <!-- Second column-->
                <div class="col-md-4">



                    <div class="form-group">
                        <label for="email_address">
                            Email address
                        </label>
                        <input type="email" class="form-control" id="email_address" value="<?php echo $screenData['email_address']?>"/>
                    </div>
                    <div class="form-group">
                        <label for="phone_number">
                            Email address
                        </label>
                        <input type="text" class="form-control" id="phone_number" value="<?php echo $screenData['phone_number']?>"/>
                    </div>
                    <div class="form-group">
                        <label for="street_address">
                            Email address
                        </label>
                        <input type="text" class="form-control" id="street_address" value="<?php echo $screenData['street_address']?>"/>
                    </div>
                    <div class="form-group">
                        <label for="province">
                            Email address
                        </label>
                        <input type="text" class="form-control" id="province" value="<?php echo $screenData['province']?>"/>
                    </div>


                </div>

            </form>

        <div class="row">
            <div class="col-md-4">
                <?php
                //include 'admin_menu.php' ;
                ?>

            </div>
        <div class="col-md-4">
            <h3> Covid Test History</h3>
            <?php
            //$table_name = "diagnostic_view where person_id=".$screenData['person_id'];
            $table_name = "diagnostic_view";
            $whereClause="person_id=".$screenData['person_id'];
            displayTable($table_name);
            ?>
        </div>

        <div class="col-md-4">
        </div>
    </div>
    </div>
</div>

</body>
</html>
