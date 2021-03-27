<?php
session_start();

// connect to database
$db = mysqli_connect('localhost', 'root', '', 'main_projectv1');

// variable declaration
$username = "";
$email    = "";
$errors   = array();
$person_id ="";

// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
    register();
}

//call the cancelRegistration() function if cancel_btn is clicked
if(isset($_POST['cancel_red_adm_btn']))     {
    cancelAdmRegistration();
}

// REGISTER USER
function register(){
    // call these variables with the global keyword to make them available in function
    global $db, $errors, $username, $email;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $username    =  e($_POST['username']);
    $email       =  e($_POST['email']);
    $password_1  =  e($_POST['password_1']);
    $password_2  =  e($_POST['password_2']);

    // form validation: ensure that the form is correctly filled
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    // register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database

        if (isset($_POST['user_type'])) {
            $user_type = e($_POST['user_type']);
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
            mysqli_query($db, $query);
            $_SESSION['success']  = "New user successfully created!!";
            header('location: home.php');
        }else{
            $query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
            mysqli_query($db, $query);

            // get id of the created user
            $logged_in_user_id = mysqli_insert_id($db);

            $_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
            $_SESSION['success']  = "You are now logged in";
            header('location: index.php');
        }
    }
}

function cancelAdmRegistration() {
    header('location: home.php');
    exit();
}

// return user array from their id
function getUserById($id){
    global $db;
    $query = "SELECT * FROM users WHERE id=" . $id;
    $result = mysqli_query($db, $query);

    $user = mysqli_fetch_assoc($result);
    return $user;
}

// escape string
function e($val){
    global $db;
    return mysqli_real_escape_string($db, trim($val));
}

function display_error() {
    global $errors;

    if (count($errors) > 0){
        echo '<div class="error">';
        foreach ($errors as $error){
            echo $error .'<br>';
        }
        echo '</div>';
    }
}

function isLoggedIn()
{
    if (isset($_SESSION['user'])) {
        return true;
    }else{
        return false;
    }
}

// log user out if logout button clicked
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("location: login.php");
}

// call the login() function if register_btn is clicked
if (isset($_POST['login_btn'])) {
    login();
}

// LOGIN USER
function login(){
    global $db, $username, $errors;

    // grap form values
    $username = e($_POST['username']);
    $password = e($_POST['password']);

    // make sure form is filled properly
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // attempt login if no errors on form
    if (count($errors) == 0) {
        $password = md5($password);

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
        $results = mysqli_query($db, $query);

        if (mysqli_num_rows($results) == 1) { // user found
            // check if user is admin or user
            $logged_in_user = mysqli_fetch_assoc($results);
            if ($logged_in_user['user_type'] == 'admin') {

                $_SESSION['user'] = $logged_in_user;
                $_SESSION['success']  = "You are now logged in";
                header('location: admin/home.php');
            }else{
                $_SESSION['user'] = $logged_in_user;
                $_SESSION['success']  = "You are now logged in";

                header('location: index.php');
            }
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

function isAdmin()
{
    if (isset($_SESSION['user']) && $_SESSION['user']['user_type'] == 'admin' ) {
        return true;
    }else{
        return false;
    }
}

//call the followUp function if go-to-daily-form-btn button is clicked
if(isset($_POST['go-to-daily-form-btn']))   {
    header('Location: followUpForm.php');
}

//call the processFollowUp() function if send-follow-up-btn is clicked
if(isset($_POST['send-follow-up-btn']))  {
    processFollowUp();
}

//cancel the follow-up form if cancel-follow-up-form-btn is clicked
if(isset($_POST['cancel-follow-up-form-btn']))  {
    cancelFollowUpForm();
}

//cancel the follow up Form and return to main-user page
function cancelFollowUpForm()  {
    header('Location: index.php');
    exit();
}

//PROCESS FOLLOW UP FORM
function processFollowUp()
{
    global $db, $errors, $medicare_number, $current_date, $current_time, $body_temperature, $symptoms;

    // receive all input values from the form. Call the e() function
    // defined below to escape form values
    $medicare_number = e($_SESSION['user']['username']);
    $current_date = e($_POST['current-date']);
    $current_time = e($_POST['current-time']);
    $body_temperature = e($_POST['body-temperature']);
    if (!empty($_POST['check-list'])) {
        $symptoms = $_POST['check-list'];
    }

    if (empty($body_temperature)) {
        array_push($errors, "body-temperature required");
    }
    if (empty($symptoms)) {
        array_push($errors, "at least one symptom must be selected");
    }

    // send data to the tables if there are no errors in the form
    if (count($errors) == 0) {

        $query = "SELECT person_id, medicare_number FROM person WHERE medicare_number = '$medicare_number'";
        $result = $db->query($query);

        $person_id = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $person_id = $row["person_id"];
            }

            //put data into Symptoms Table
            foreach ($symptoms as $symptom) {
                $query = $db->prepare("INSERT INTO symptoms (person_id, date_reported, time_reported, symptom) VALUES(?, ?, ?, ?)");
                $query->bind_param('isss', $person_id, $current_date, $current_time, $symptom);
                $query->execute();
            }

            //put data into Daily Follow-Up Table
            $query = $db->prepare("INSERT INTO daily_follow_up (person_person_id, date_reported, time_reported, body_temperature) VALUES(?,?,?,?)");
            $query->bind_param('issd', $person_id, $current_date, $current_time, $body_temperature);
            $query->execute();

            $db->close();
            header('Location: thankyou.php');
        }
    }
}

if(isset($_GET['person'])){
    header("Location: person_records.php");
}



function displayTable($table_name){
    global $db;

    $query = "SELECT * FROM {$table_name}";
    
    $result = mysqli_query($db, $query);
    //$number_of_pk = count_num_pkeys($table_name);
    //echo $number_of_pk;

    $fields_num = mysqli_field_count($db);

    while(($row = $result->fetch_assoc()) !== null)
    {
        $data[] = $row;
    }
    $colNames = array_keys(reset($data));

    echo "<table class=table>";
    echo "<thead>";
    foreach($colNames as $colName)
    {
        if ($colName != "pkey") {
            if ($colName != "screenName") {
                echo "<th>$colName</th>";
            }
        }
    };
    echo "</thead>";
    foreach($data as $row)
    {
        echo "<tr>";
        foreach($colNames as $colName) {
            if ($colName != "pkey") {
                if ($colName != "screenName") {
                    echo "<td>" . $row[$colName] . "</td>";
                }

            }
        }
        echo "<td><a href=$row[screenName]_view.php?$row[pkey]>view</a>";

    }
    echo "</tr>";




   
    mysqli_free_result($result);
}

/*function add_edit_and_delete($row){
    $link_address_edit = "edit_user.php?edit_person='1'";
    $link_address_delete = "delete_user.php?delete_person='1'";
    echo "<a href={$link_address_edit}>Edit</a>";
    echo "<a href={$link_address_delete}>Delete</a>";
}*/

if(isset($_GET['person_person_id'])) {
    delete_person($_GET['person_person_id']);
}

function count_num_pkeys($table_name){
    

    
    global $db;
    echo 'inside get PK';
    $query = "select COUNT(*) FROM PERSON";
  
  $result = mysqli_query($db, $query);
    
    if(!$result) {
        echo 'db failed';
    }
  while($row = mysqli_fetch_row($result))
    {
        
        foreach($row as $cell) {
            echo 'a';
            echo $cell;
        }
        
    }
    mysqli_free_result($result);
    
    
    //echo $result; 
    
}

function getRegions(){
    global $db;
    $query = "SELECT region_name,current_active_alert from region";
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $regions = array();
    while ($row = $result->fetch_row()) {
        echo  "<option value=$row[0]>$row[0]</option>";
        $regions[]=$row;
    }

    return $regions;
       
 }
function getBulkData($QueryToRun){
    global $db;
    $query = $QueryToRun;
    $result = mysqli_query($db, $query);
    $numRows=mysqli_num_rows($result);
    $screenData = array();
    $row = mysqli_fetch_assoc($result);
    //printf("%s (%s)\n", $row["first_name"], $row["last_name"]);
    return $row;

}


?>