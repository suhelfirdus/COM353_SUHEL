<?php
include '../UICommon/template.php' ;

?>
<body>
<!-- First Columns is always the menu -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <?php
            include '../admin/admin_menu.php';
            ?>
        </div>
        <!-- First Columns is always the menu ends-->

        <div class="col-md-4">
            <!-- Button to call a new Operation -->
            <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <!-- Button to call a new Operation  ends -->
                <div class="form-group">
                <label for="searchparam">select a param:</label>
                <select name="searchparam" id="searchparam">
                    <option value="msg_id">Message Id</option>
                    <option value="person_id">Person_id</option>
                    <option value="datetime">Message Date</option>
                    <option value="email">Email</option>
                    <option value="old_alert_state">Old Alert State</option>
                    <option value="new_alert_state">New Alert State</option>
                    <option value="msg_body">Message Body</option>
                    <option value="message_category">Message Category</option>
                </select>
                </div>
                <div class="form-group">
                    <label for="searchvalue">
                        value
                    </label>
                    <input type="text" class="form-control" id="searchvalue"  name="searchvalue" />
                </div>

                <div class="form-group">
                    <label for="fromdate">
                        From Date
                    </label>
                    <input type="date" class="form-control" id="fromdate"  name="fromdate" />
                </div>

                <div class="form-group">
                    <label for="todate">
                        to Date
                    </label>
                    <input type="date" class="form-control" id="todate"  name="todate" />
                </div>


                <button type="submit" class="btn btn-primary" name="SEARCH_MESSAGES" >
                    SEARCH
                </button>&NonBreakingSpace;
                <hr>
                <hr>

        </div>
        <!-- Second column-->
        <div class="col-md-4">


            <!--</form>-->
            <form>
                <div class="row">
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
        </div>
    </div>

</body>
<?php
if (isset($_POST['SEARCH_MESSAGES'])) {
    $searchparam=e($_POST['searchparam']);
    $searchvalue=e($_POST['searchvalue']);
    $fromdate=(isset($_POST['fromdate'])) ? $_POST['fromdate'] : 0;
    $todate=(isset($_POST['todate'])) ? $_POST['todate'] : 0;

    if ($fromdate!=''){
         if ($todate!=''){
             $query = "select * from messages where ".$searchparam." like '".$searchvalue."%' and datetime between '".$fromdate."%' and '".$todate."%'";
        }
    }else{
        $query = "select * from messages where ".$searchparam." like '".$searchvalue."%'";
    }

    //$query = "select * from messages where ".$searchparam." like '".$searchvalue."%'";
    //$query = "select * from messages where ".$searchparam." like '".$searchvalue."%' and datetime between '".$fromdate."%' and '".$todate."%'";
    //echo $query;
    global $db;
    $result = mysqli_query($db, $query);
    $fields_num = mysqli_field_count($db);
    while (($row = $result->fetch_assoc()) !== null) {
        $data[] = $row;
    }
    if ( @$data!==null) {
        @$colNames = array_keys(reset($data));
        echo "<row>";
        echo "<table>";
        echo "<thead>";
        foreach ($colNames as $colName) {
            if ($colName != "pkey") {
                if ($colName != "screenname") {
                    echo "<th>$colName</th>";
                }
            }
        };
        echo "</thead>";
        foreach ($data as $row) {
            echo "<tr>";
            foreach ($colNames as $colName) {
                if ($colName != "pkey") {
                    if ($colName != "screenname") {
                        echo "<td>" . $row[$colName] . "</td>";
                    }

                }
            }
            echo "<td><a href=" . @$row['screenname'] . "_view.php?" . @$row['pkey'] . ">view</a>";
            echo "</tr>";

            echo "</row>";
        }
    }
}
?>

</html>
