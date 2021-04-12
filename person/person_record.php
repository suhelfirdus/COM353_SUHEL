<?php
include 'person_functions.php' ;
include '../UICommon/template.php' ;
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
            <button type="submit" class="btn btn-primary" name="add_new_person">
                Add New Person
            </button>
            <?php
            $table_name = "persons_view";
            displayTable($table_name);
            ?>
        </div>
    </div>
</div>



</body>
</html>