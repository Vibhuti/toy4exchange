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

if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = trim($_POST['firstname']);
    $last_name = trim($_POST['lastname']);
    $gender = trim($_POST['gender']);
    $birthdate = trim($_POST['birthdate']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $old_picture = trim($_POST['old_picture']);
    $new_picture = trim($_FILES['new_picture']['name']);
    $new_picture_type = $_FILES['new_picture']['type'];
    $new_picture_size = $_FILES['new_picture']['size'];
    if ($_FILES['new_picture']['tmp_name']) {
        list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
    }
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
        if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
                ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
                ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) {
            if ($_FILES['new_picture']['error'] == 0) {
                // Move the file to the target upload folder
                $target = MM_UPLOADPATH . basename($new_picture);
                if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
                    // The new picture file move was successful, now make sure any old picture is deleted
                    if (!empty($old_picture) && ($old_picture != $new_picture)) {
                        @unlink(MM_UPLOADPATH . $old_picture);
                    }
                } else {
                    // The new picture file move failed, so delete the temporary file and set the error flag
                    @unlink($_FILES['new_picture']['tmp_name']);
                    $error = true;
                    echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
                }
            }
        } else {
            // The new picture file is not valid, so delete the temporary file and set the error flag
            @unlink($_FILES['new_picture']['tmp_name']);
            $error = true;
            echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
            ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
        }
    }

    // Update the profile data in the database
    if (!$error) {
        if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate) && !empty($city) && !empty($state)) {

            update_user($first_name, $last_name, $gender, $birthdate, $city, $state, $new_picture, $_SESSION['user_id']);

            // Confirm success with the user
            echo '<p>Your profile has been successfully updated. Would you like to <a href="viewprofile.php">view your profile</a>?</p>';

            exit();
        } else {
            echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
        }
    }
} // End of check for form submission
else {
    // Grab the profile data from the database
    $user = get_user_by_userid($_SESSION['user_id']);

    if ($user != NULL) {
        $first_name = $user['FirstName'];
        $last_name = $user['LastName'];
        $gender = $user['Gender'];
        $birthdate = $user['DOB'];
        $city = $user['City'];
        $state = $user['State'];
        //$balance=$user['balance'];
        $old_picture = $user['ProfilePic'];
        include('views/editprofile.php');
    } else {
        echo '<p class="error">There was a problem accessing your profile.</p>';
    }
}

        