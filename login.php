<?php
include('functions.php') ?>
<!DOCTYPE html>
<html>
<head>
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
        <h1>Welcome to COVID-19 Tracking App Login Page</h1>
        <p>To continue please enter your username and password</p>
    </div>
    <form class="form-horizontal" method="post" id="main-sign-in" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="alert alert-warning" role="alert">
            <?php echo display_error(); ?>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="username">Username</label>
            <div class="col-sm-10">
                <input class="form-control" id="username" type="text" name="username" placeholder="users sign in with Medicare Card Number: ABCD-123456">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="password">Password</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" id="password" placeholder="Date-of-Birth: ddmmyyyy">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn" name="login_btn">Login</button>
            </div>
        </div>
        <p>
            Not yet a member? <a href="register.php">Sign up</a>
        </p>
    </form>
</body>
</html>
