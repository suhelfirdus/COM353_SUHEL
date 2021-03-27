<?php
include('../functions.php') ?>
<!--<?php include('admin_menu.php') ?> -->
<!DOCTYPE html>
<html>
<head>

    <title>New User Registration</title>
    <meta charset="UTF-8">
    <title>Signed-in Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Sign-in Page</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <script>
        function showRegion(str) {

            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };

                xmlhttp.open("GET","admin_ajax_functions.php?q="+str,true);
                xmlhttp.send();
            }
        }
    </script>

    
</head>
<body>
   <!-- <div class="jumbotron text-center">
        <h1>COVID-19 Tracking App Registration Page</h1>
        <p>new patients should register with their Medicare Card Number and Date of Birth</p>
    </div> -->


    <form class="col-12 col-md-9" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="alert alert-warning" role="alert">
            <?php echo display_error(); ?>
        </div>

        
        <centre><div class="form-group">
            <label class="control-label col-sm-2" for="user_type" >Region Name</label>
            <div class="col-sm-10">
                <select name="region_names" id="region_names"  onchange="showRegion(this.value)" >
                    <?php echo $region=getRegions();
                    ?>
                </select>
            </div>
                <div id="txtHint"><b>Current Active alert will be shown here : </b></div>
        </div>

        
        <!--<div class="form-group">
            <label class="control-label col-sm-2" for="next_alert" >next Alert</label>
            <div class="col-sm-10">
                <input type="text" name="next_alert" id="next_alert">
            </div>
        </div> -->
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn" name="setAlert">Set Alert</button>
                <button type="cancel" class="btn" name="CancelAlert">Cancel</button>
            </div>

    </form></centre>
</body>
</html>
