<?php
include('../functions.php') ?>
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
</head>
<body>
    <div class="jumbotron text-center">
        <h1>COVID-19 Tracking App Registration Page</h1>
        <p>new patients should register with their Medicare Card Number and Date of Birth</p>
    </div>
    <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="alert alert-warning" role="alert">
            <?php echo display_error(); ?>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="username_adm">Username</label>
            <div class="col-sm-10">
                <input class="form-control" type="text" name="username" id="username_adm" value="<?php echo $username; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email_adm" >Email</label>
            <div class="col-sm-10">
                <input type="email" name="email" id="email_adm" value="<?php echo $email; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="user_type" >User type</label>
            <div class="col-sm-10">
                <select name="user_type" id="user_type" >
                    <option value=""></option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="password_adm_1" >Password</label>
            <div class="col-sm-10">
                <input type="password" name="password_1" id="password_adm_1">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="password_adm_2" >Confirm password</label>
            <div class="col-sm-10">
                <input type="password" name="password_2" id="password_adm_2">
            </div>
        </div>
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn" name="register_btn">Create user</button>
                <button type="submit" class="btn" name="cancel_red_adm_btn">Cancel</button>
            </div>
        </div>
    </form>
</body>
</html>
