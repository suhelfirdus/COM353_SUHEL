<?php
include('../functions.php') ;
include 'admin_header.php' ;
?>
<!DOCTYPE html>
<html>
<head>
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

                <label class="control-label col-sm-2" for="user_type" >Region Name</label>
                <select name="region_names" id="region_names"  onchange="showRegion(this.value)" >
                    <?php echo $region=getRegions();
                    ?>
                </select>
                <div id="txtHint"><b></b></div>

              <div>
                <button type="submit" class="btn btn-primary">
                    Update Data
                </button>
                <button type="submit" class="btn btn-primary">
                    Delete Person
                </button>
              </div>
            </form>

            <div class="col-md-4">
            </div>
        </div>
    </div>

</body>
</html>
