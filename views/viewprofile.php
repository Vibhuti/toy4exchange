<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php include('_header.php'); ?>
    <body>
        <fieldset>
            <legend>Profile View</legend>
            <?php if (!empty($picture)) echo "<img src='" . MM_UPLOADPATH . $picture . "' alt='Profile Picture' />"; ?><br />
            <label for="username">User name:</label><?php if (!empty($username)) echo $username; ?><br />
            <label for="firstname">First name:</label><?php if (!empty($first_name)) echo $first_name; ?><br />
            <label for="lastname">Last name:</label><?php if (!empty($last_name)) echo $last_name; ?><br />
            <label for="gender">Gender:</label><?php if (!empty($gender)) echo $gender; ?><br />
            <label for="birthdate">Birth Date:</label><?php if (!empty($gender)) echo $birthdate; ?><br />
            <label for="location">Location:</label><?php if (!empty($city) || !empty($state)) echo $city . ', ' . $state; ?><br />
        </fieldset>
        <p>Would you like to <a href="editprofile.php">edit your profile</a>?</p>
        <a href="index.php">Home</a>
        <?php include('_footer.php'); ?>
    </body>
</html>


