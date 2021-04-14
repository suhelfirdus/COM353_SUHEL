<?php
//include($_SERVER['DOCUMENT_ROOT']."\\functions.php");
//include($_SERVER['DOCUMENT_ROOT']."\\log_reg_follow_up_func.php");
include('functions.php');
include('log_reg_follow_up_func.php');

if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Additional info</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Main Sign-in Page</title>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<div class="jumbotron text-left">
    <h1>COVID-19 daily questionnaire</h1>
    <p style="font-size: large">
        Please fill out the questionnaire every day until the end of 14 days quarantine period.
        It is important to fill out the questionnaire also in cases where you and are feeling well and do not experience any symptoms.
        This survey is anonymous and all data will be used solely for tracking the spread of the virus.
        You will not have any return of information from the answers you provide in the questionnaire.
    </p>
    <p style="font-style: italic; color: darkred">
        Please understand that this questionnaire cannot diagnose coronavirus infection, moreover this questionnaire does not constitute any form of clinical care.
    </p>
    <p>
        <!-- logged in user information -->
    <div class="profile_info" style="position: relative; top:0; right: 0; padding: 10px " >
        <!--<img src="images/Cov-19-128x128.png"  >-->
        <div style="position: absolute; right:50%">
            <?php  if (isset($_SESSION['user'])) : ?>
                <strong><?php echo $_SESSION['user']['username']; ?></strong>
                <small>
                    <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                    <br>
                    <form id="index" class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div>
                            <button class="btn btn-outline-primary" type="submit" form="index" name="logout">Logout</button>
                        </div>
                    </form>
                </small>
            <?php endif ?>
        </div>
    </div>
    </p>
</div>
<div>
    <label></label>
    <form class="form-horizontal"  method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="alert alert-warning" role="alert">
            <?php echo display_error(); ?>
        </div>
        <div class="form-group row" style="margin-left: 10px">
            <label class="col-1 col-form-label" for="current-date">Current Date*</label>
            <div class="col-10">
                <input class="form-control col-3" id="current-date" type="date" name = "current-date">
            </div>
        </div>

        <div class="form-group row" style="margin-left: 10px">
            <label class="col-1 col-form-label" for="current-time">Current Time*</label>
            <div class="col-10">
                <input class="form-control col-3" id="current-time" type="time" name="current-time">
            </div>
        </div>



        <!--     <label for="current-date">Current Date</label>
             <input readonly id="current-date" type="date" name = "current-date" value=--><?php /*echo date("Y-m-d");*/?>

        <!-- <div class="form-control">
             <label for="current-time">Current Time*</label>
             <input id="current-time" type="time" name="current-time">
         </div>-->


        <!--<input readonly id="current-time" type="time" name="current-time" value=--><?php
        /*                    $dt = new DateTime("now", new DateTimeZone('America/New_York'));
                            echo $dt->format('H:i:s')*/?>

        <div class="form-group">
            <label class="control-label col-sm-2" for="symptoms">Are you experiencing any of the following symptoms?*</label>
            <div class="col-sm-10">
                <ul id="symptoms" style="list-style-type: none">
                    <span class="error"></span>
                    <li> <input type="checkbox" name = "check-list[]" value = "fever"> fever (temperature exceeding 38.1 degrees Celsius or 100.6 degrees Fahrenheit)</li>
                    <li><input type="checkbox" name = "check-list[]" value = "cough"> cough</li>
                    <li> <input type="checkbox" name = "check-list[]" value = "shortness of breath or difficulty breathing,"> shortness of breath or difficulty breathing</li>
                    <li><input type="checkbox" name = "check-list[]" value = "loss of taste and smell"> loss of taste and smell</li>
                    <li><input type="checkbox" name = "check-list[]" value = "nausea"> nausea</li>
                    <li> <input type="checkbox" name = "check-list[]" value = "stomach aches"> stomach aches</li>
                    <li><input type="checkbox" name = "check-list[]" value = "vomiting"> vomiting</li>
                    <li> <input type="checkbox" name = "check-list[]" value = "headache"> headache</li>
                    <li> <input type="checkbox" name = "check-list[]" value = "muscle pain"> muscle pain</li>
                    <li> <input type="checkbox" name = "check-list[]" value = "diarrhea"> diarrhea</li>
                    <li> <input type="checkbox" name = "check-list[]" value = "sore throat"> sore throat</li>
                    <li style="color: red; font-weight: bold"> <input type="checkbox" name = "check-list[]" value = "no symptoms"> no symptoms</li>
                </ul>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <label for="other-symptom">Other symptom. Please specify </label>
                <input type="text" name="other-symptom" id="other-symptom">
                <span class="error"></span>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <label for="body-temperature">What is your body temperature in Celsius?*</label>
                <input type="text" name="body-temperature" id="body-temperature">
                <span class="error"></span>
            </div>
        </div>
        <form class="form-horizontal">
            <div class="form-group">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Submit" name="send-follow-up-btn" />
                        <input type="submit" value="Cancel" name="cancel-follow-up-form-btn" />
                    </div>
                </div>
        </form>
</div>

<hr>
<footer class="container">
    <p style="display: block; text-align: center; margin-block-start: 1em; margin-block-end: 1em; margin-inline-start: 0px; margin-inline-end: 0px;">@ Covid Tracking App 2021</p>
</footer>

</body>
</html>
