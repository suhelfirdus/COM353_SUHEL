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
<html>
<head>
    <meta charset="UTF-8">
    <title>Signed-in Page</title>
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
    <h1>Welcome to COVID-19 follow-up form</h1>
    <p style="font-size: large; font-weight: bold; color: darkred">Important Information!!!</p>
    <p style="font-size: large; font-style: italic">
        A person tested positive must fill-up a daily follow-up form for 14 consecutive days following the result date.
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
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">

                <!--  --><?php /*echo $_SESSION['username'];*/?>
                <input type="submit" value="Fill-Up The Form Now" name="go-to-daily-form-btn">
            </div>
        </div>
    </form>
</div>

<div class="col-sm-offset-2 col-sm-10">
    <hr>
    <h3>Notice</h3>
    <p>Information on the website in no way replaces the opinion of a health professional.
        If you have questions concerning your health status, consult a professional.</p>
    <hr>
    <h3>Be advised</h3>
    <p ">A sick person under home isolation is asked to follow the instructions below to prevent the
    spread of COVID-19 to other people around him/her: </p>
    <ul>
        <li>Do not go to school, work, a childcare center or any other public space.</li>
        <li>Do not use public transport.</li>
        <li>
            If the sick person lives alone and has no help to get essentials such as food or
            medication, use phone/online grocery and pharmacy home delivery services.
        </li>
        <li>Do not receive visitors at home. </li>
        <li>If the sick person lives with other people who are not infected by COVID-19:</li>
        <li>Open a window to air out the sick person's room and home often (weather
            permitting). <br>
            <ul>
                <li>
                    remain alone in one room of the house as often as possible and close to the
                    door.
                </li>
                <li>eat and sleep alone in one room of the house.</li>
                <li>if possible, use a bathroom reserved for the sick person sole use. Otherwise, disinfect the bathroom after every use.</li>
                <li>
                    avoid as much as possible contact with other people in the home. If this is
                    impossible, wear a mask. If a mask is not available, stay at least two
                    meters away from other people.
                </li>
            </ul>
        </li>
        <li>
            Do not go to a medical clinic unless you have first obtained an appointment and
            have notified the clinic that you have COVID-19. If you need to go to the
            emergency room (eg, if you have difficulty breathing), contact 911 and tell the
            person that you are sick with COVID-19.
        </li>
        <li>Wear a mask when someone is in the same room as you.</li>
        <li>
            Wear a mask if you must leave your home to seek medical care, you must first
            notify the medical clinic (or 911, if it is an emergency) that you have COVID-19.
        </li>
        <li>If you need to cough, sneeze, or blow your nose: <br>
            <ul>
                <li>
                    If you have a disposable tissue use it to cough, sneeze or blow your nose
                    then discard the tissue in the garbage, and then wash your hands with soap
                    and water.
                </li>
                <li>
                    If you do not have disposable tissues, cough, or sneeze in the crook of
                    your arm.
                </li>
            </ul>
        </li>
        <li>Wash your hands:<br>
            <ul>
                <li>
                    Wash your hands often with soap under warm running water for at least 20
                    seconds.
                </li>
                <li>Use an alcohol- based hand rub if soap and water are not available. </li>
                <li>Wash your hands before eating and whenever your hands look dirty</li>
                <li>
                    After using the toilet, put the lid down before flushing and then wash your
                    hands.
                </li>
            </ul>
        </li>
        <li>Do not share plates, utensils, glasses, towels, bed sheets or clothes with others.
        </li>
        <li>Watch your symptoms and take your temperature every day:<br>
            <ul>
                <li>Take your temperature every day at the same hour.</li>
                <li>
                    If you are taking medication for fever wait at least four hours before
                    taking your temperature.
                </li>
            </ul>
        </li>
        <li>Directives in case of severe symptoms:<br>
            <ul>
                <li>If your symptoms worsen call 514-644-4545 or call your doctor. </li>
                <li>
                    If you have difficulty breathing, or shortness of breath or chest pain call
                    911 and inform them you may be infected by COVID-19.
                </li>
            </ul>
        </li>
        <li>
            If someone close or caregiver helps you with your daily activities, then before
            helping you, the person must wash his/her hand, wear a mask and put-on
            disposable gloves. After helping you, the person must take off the gloves and put
            them in a garbage bin with a lid, wash his/her hands, take off the mask and put it
            in a garbage bin with a lid, and wash his/her hands again.
        </li>
        <li>For help with psychosocial matters, contact 811.</li>
    </ul>
</div>

<hr>
<footer class="container">
    <p style="display: block; text-align: center; margin-block-start: 1em; margin-block-end: 1em; margin-inline-start: 0px; margin-inline-end: 0px;">@ Covid Tracking App 2021</p>
</footer>
</body>
</html>