<?php
include '../UICommon/template.php' ;
?>
<body>
<form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<div class="container-fluid">
    <div class="row">
     <div class="col-md-4">
            <?php
            include '../admin/admin_menu.php' ;
            ?>
        </div>
        <div class="col-md-4">

            <button type="submit" class="btn btn-primary" name="add_newPerson_btn">
                add new Region
            </button>
            <?php
            $table_name = "region_view";
            displayTable($table_name);
            ?>
        </div>
    </div>
</div>



</body>
</html>