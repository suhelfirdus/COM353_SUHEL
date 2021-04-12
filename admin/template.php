<?php
include('../functions.php') ;
include 'admin_header.php' ;
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
                    include 'admin_menu2.php';
                    ?>

                </div>

                <form role="form">


                </form>

                <div class="col-md-4">
                </div>
            </div>
        </div>

    </body>
    </html>
<?php
