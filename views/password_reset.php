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
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<?php include('_header.php'); ?>
<body>

<?php if ($login->passwordResetLinkIsValid() == true) { ?>
    <form method="post" action="password_reset.php" name="new_password_form">
        <input type='hidden' name='user_name' value='<?php echo $_GET['user_name']; ?>' />
        <input type='hidden' name='user_password_reset_hash' value='<?php echo $_GET['verification_code']; ?>' />

        <label for="user_password_new"><?php echo WORDING_NEW_PASSWORD; ?></label>
        <input id="user_password_new" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

        <label for="user_password_repeat"><?php echo WORDING_NEW_PASSWORD_REPEAT; ?></label>
        <input id="user_password_repeat" type="password" name="user_password_repeat" pattern=".{6,}" required autocomplete="off" />
        <input type="submit" name="submit_new_password" value="<?php echo WORDING_SUBMIT_NEW_PASSWORD; ?>" />
    </form>
    <!-- no data from a password-reset-mail has been provided, so we simply show the request-a-password-reset form -->
<?php } else { ?>
    <form method="post" action="password_reset.php" name="password_reset_form">
        <label for="user_name"><?php echo WORDING_REQUEST_PASSWORD_RESET; ?></label>
        <input id="user_name" type="text" name="user_name" required />
        <input type="submit" name="request_password_reset" value="<?php echo WORDING_RESET_PASSWORD; ?>" />
    </form>
<?php } ?>

<a href="index.php"><?php if(isset($_SESSION['user_name'])){echo WORDING_BACK_TO_HOME;} else {echo WORDING_BACK_TO_LOGIN;} ?></a>

</body>
<?php include('_footer.php'); ?>
</html>
