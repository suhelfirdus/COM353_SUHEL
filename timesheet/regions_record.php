<?php
include '../UICommon/template.php' ;
include 'region_functions.php' ;
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
            <button type="submit" class="btn btn-primary" name="add_new_Region">
                Add New Region
            </button>
            </form>
            <?php
            $table_name = "region_view";
            displayTable($table_name);
            ?>
        </div>
    </div>
</div>



</body>
</html>