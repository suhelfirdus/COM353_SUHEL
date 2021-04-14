<!--<html>
<body>

            <h3>COVID-19 Public Health Care System (C19PHCS)</h3><b>Sign Out</b>
            <hr>
<body>
</html> -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('../admin_autorization_check.php');

?>

<!DOCTYPE html>
<html>
<head>
    <style>
        .myDiv {
            border: 1px outset red;
            background-color: #d1c1c0;
            text-align: center;
        }
    </style>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 50%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {background-color: #ddd;}

        .dropdown:hover .dropdown-content {display: block;}

        .dropdown:hover .dropbtn {background-color: #3e8e41;}
    </style>
</head>
<body>
<!-- notification message -->
<?php if (isset($_SESSION['success'])) : ?>
    <div class="error success" >
        <h4>
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </h4>
    </div>
<?php endif ?>
<div class="myDiv">
    <h2>COVID-19 Public Health Care System (C19PHCS)</h2>
    <p>
        <!-- logged in user information -->
    <div class="profile_info" style="position: relative; top:0; right: 0; padding: 10px ">
        <!--            <img src="../images/sys-admin-96.png"  >-->
        <div>
            <?php  if (isset($_SESSION['user'])) : ?>
                <strong><?php echo $_SESSION['user']['username']; ?></strong>
                <small>
                    <i  style="color: #888;">(<?php echo ucfirst($_SESSION['user']['user_type']); ?>)</i>
                    <br>
                </small>
                <div>
                    <p>
                        <a href="../admin/admin_header.php?logout='1'" class="btn btn-outline-secondary">
                            <span class="glyphicon glyphicon-log-out"></span> Sign out</a>
                    </p>

                </div>
            <?php endif ?>
        </div>
    </div>

    <!--        sign out-->

    </p>
</div>
<div class="dropdown">
    <button class="dropbtn">Administrator Menu</button>
    <div class="dropdown-content">
        <a href="../person/person_record_search.php">Persons</a>
        <a href="../healthcenter/healthcenter_record_search.php">Health Centers</a>
        <a href="../healthworker/healthworker_record.php">Health Workers</a>
        <a href="../regions/region_record_search.php"">Regions</a>
        <a href="../cities/cities_record_search.php">Cities</a>
        <a href="../recommendations/recommendations_record_search.php">Recommendation</a>
        <a href="../covidtest/covidtest_record_search.php">Covid Tests</a>
        <a href="../alerts/alert_record_search.php">Set Alert</a>
        <a href="../messages/messages_record_search.php">Messages History</a>
        <a href="../emptracking/emptrack_record_search.php">Emp Tracking Reports</a>

    </div>
</div>
<hr>


</body>
</html>
