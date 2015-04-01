<?php

session_start();

// If the session vars aren't set, try to set them with a cookie
if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_name'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['user_name'] = $_COOKIE['user_name'];
    }
}
?>

<?php

require('/model/appvars.php');
require('/model/db_connect.php');
require('/model/user_repository.php');
require_once('translations/en.php');


// Make sure the user is logged in before going any further.
if (!isset($_SESSION['user_id'])) {
    //Redirect to login page
    include('views\not_logged_in.php');
    exit();
} else {
    echo('<p class="login">You are logged in as ' . $_SESSION['user_name'] . '. <a href="logout.php">Log out</a>.</p>');
}

// Grab the profile data from the database
if (!isset($_GET['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = $_GET['user_id'];
}
$user = get_user_by_userid($user_id);
if ($user_id >= 1) {
    $username = $_SESSION['user_name'];
    $first_name = $user['FirstName'];
    $last_name = $user['LastName'];
    if ($user['Gender'] == 'M') {
        $gender = 'Male';
    } else if ($user['Gender'] == 'F') {
        $gender = 'Female';
    } else {
        $gender = '';
    }
    if (!isset($_GET['user_id']) || ($_SESSION['user_id'] == $_GET['user_id'])) {
        $birthdate = $user['DOB'];
    } else { // Show only the birth year for everyone else
        list($year, $month, $day) = explode('-', $user['DOB']);
        $birthdate = $year;
    }
    $city = $user['City'];
    $state = $user['State'];
    $picture = $user['ProfilePic'];
    include('views\viewprofile.php');
} else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
}
