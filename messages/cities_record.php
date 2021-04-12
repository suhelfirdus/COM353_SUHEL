<?php
include '../UICommon/template.php' ;
include 'cities_functions.php' ;
?>
<body>

<div class="container-fluid">
    <div class="row">
     <div class="col-md-4">
            <?php
            include '../admin/admin_menu2.php';
            ?>
        </div>
        <div class="col-md-4">
            <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit" class="btn btn-primary" name="add_new_city">
                Add New City
            </button>
            </form>
            <?php
            $table_name = "cities_view";
            displayTable($table_name);
            ?>
        </div>
    </div>
</div>



</body>
</html>