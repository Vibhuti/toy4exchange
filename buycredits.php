<?php

session_start();

// If the session vars aren't set, try to set them with a cookie
if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
        $_SESSION['user_id'] = $_COOKIE['user_id'];
        $_SESSION['user_name'] = $_COOKIE['user_name'];
    }
}
?>
<?php

require_once('/translations/en.php');
require('/model/appvars.php');
require('/model/db_connect.php');
require('/model/user_repository.php');

if (!isset($_SESSION['user_id'])) {
    //Redirect to login page
    include('views/not_logged_in.php');
    exit();
} else {
    echo('<p class="login">You are logged in as ' . $_SESSION['user_name'] . '. <a href="logout.php">Log out</a>.</p>');
}
if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $CC_NO = trim($_POST['CC_NO']);
    $CC_Type=trim($_POST['CC_Type']);
    $Name = trim($_POST['Name']);
    $ExpiryDate = trim($_POST['ExpiryDate']);
    $CSV = trim($_POST['CSV']);
    $Zip = trim($_POST['Zip']);
    $Amount = trim($_POST['Amount']);
    $error = false;
    if (!$error) {
        if (!empty($CC_NO) &&!empty($CC_Type) && !empty($Name) && !empty($ExpiryDate) && !empty($CSV) && !empty($Zip) && !empty($Amount)) {
            if ($ExpiryDate <= date("m.d.y")) {
                update_usercredits($_SESSION['user_id'], $Amount);
                echo 'Credits have been successfully added to your account';
            } else {
                echo 'Please enter a valid expiration date';
            }
        }
    }
} else {
        //Redirect to buycredits page
        if(isset($_POST['CC_NO'])) {$CC_NO = trim($_POST['CC_NO']);}
        if(isset($_POST['CC_Type'])) {$CC_Type = trim($_POST['CC_Type']);}
        if(isset($_POST['Name'])) {$Name = trim($_POST['Name']);}
        if(isset($_POST['ExpiryDate'])) {$ExpiryDate = trim($_POST['ExpiryDate']);}
        if(isset($_POST['CSV'])) {$CSV = trim($_POST['CSV']);}
        if(isset($_POST['Zip'])) {$Zip = trim($_POST['Zip']);}
        if(isset($_POST['Amount'])) {$Amount = trim($_POST['Amount']);}
        include('views/buycredits.php');
}