<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php include('_header.php'); ?>
    <body>
    <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
        <fieldset>
            <legend>Edit Profile</legend>
            <label for="firstname">First name:</label>
            <input type="text" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" />
            <label for="lastname">Last name:</label>
            <input type="text" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" />
            <label for="gender">Gender:</label>
            <select id="gender" name="gender"><br/>
                <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
                <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
            </select><br /><br/>
            <label for="birthdate">Birthdate:</label><br/>
            <input type="date" id="birthdate" name="birthdate" value="<?php if (!empty($birthdate)) {echo $birthdate;} else {echo 'mm/dd/yy';} ?>" /><br /><br/>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php if (!empty($city)) echo $city; ?>" />
            <label for="state">State:</label>
            <input type="text" id="state" name="state" value="<?php if (!empty($state)) echo $state; ?>" />
            <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
            <label for="new_picture">Picture:</label><br/>
                <?php
            if (!empty($old_picture)) {
                echo '<img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" />'.'<br/>';
            }
            ?>
            <input type="file" id="new_picture" name="new_picture" />
            
        </fieldset>
        <input type="submit" value="Save Profile" name="submit" />
    </form>
    <a href="index.php">Home</a>
    </body>
<?php include('_footer.php'); ?>
</html>
