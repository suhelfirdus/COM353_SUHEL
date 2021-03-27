<?php
include('../functions.php');

if (!isAdmin()) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: ../login.php");


}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Main Admin Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div class="content">
        <!-- notification message -->
        <?php if (isset($_SESSION['success'])) : ?>
            <div class="error success" >
                <h3>
                    <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </h3>
            </div>
        <?php endif ?>
        <!-- logged in user information -->
        <div class="profile_info" style="position: relative; top:0; right: 0; padding: 10px ">
            <img src="../images/sys-admin-96.png"  >
            <div style="position: absolute; top:0; right:10px">
                <?php  if (isset($_SESSION['user'])) : ?>
                    <strong><?php echo $_SESSION['user']['username']; ?></strong>
                    <small>
                        <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                        <br>
                    </small>
                <div>
                    <a href="home.php?logout='1'" class="btn btn-info btn-lg" style="background-color: darkred">
                        <span class="glyphicon glyphicon-log-out"></span> Log out</a>
                </div>
                <?php endif ?>
            </div>
            <div>
                <a href="create_user.php" class="btn btn-info btn-lg">
                    <span class="glyphicon glyphicon-log-out"></span>Create User</a>
            </div>
        </div>
        <div class="jumbotron text-center">
            <h1>Welcome to Admin Main Page</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-4 col-md-2">
            <div style="position: absolute; left: 0">
                <div style="padding: 10px">
                    <a href="create_user.php?person='1'" class="btn btn-outline-secondary" style="width: 175px">
                        <span class="glyphicon glyphicon-log-out"></span>Person Records</a>
                </div>
                <div style="padding: 10px">
                    <a href="create_user.php" class="btn btn-outline-secondary" style="width: 175px">
                        <span class="glyphicon glyphicon-log-out"></span>Health Centers</a>
                </div>
                <div style="padding: 10px">
                    <a href="create_user.php" class="btn btn-outline-secondary" style="width: 175px">
                        <span class="glyphicon glyphicon-log-out"></span>Health Workers</a>
                </div>
                <div style="padding: 10px">
                    <a href="create_user.php" class="btn btn-outline-secondary" style="width: 175px">
                        <span class="glyphicon glyphicon-log-out"></span>Zones Category</a>
                </div>
                <div style="padding: 10px">
                    <a href="create_user.php" class="btn btn-outline-secondary" style="width: 175px">
                        <span class="glyphicon glyphicon-log-out"></span>Regions</a>
                </div>
                <div style="padding: 10px">
                    <a href="create_user.php" class="btn btn-outline-secondary" style="width: 175px">
                        <span class="glyphicon glyphicon-log-out"></span>PH Recommendations</a>
                </div>
                <div style="padding: 10px">
                    <a href="set_alert.php" class="btn btn-outline-danger" style="width: 175px">
                        <span class="glyphicon glyphicon-log-out"></span>Set An Alert</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-9">
            <p>
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.
            </p>
        </div>
    </div>
</body>
</html>