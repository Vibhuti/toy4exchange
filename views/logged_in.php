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
    <legend>Home</legend>
<?php    
if (!isset($_GET['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = $_GET['user_id'];
}
$user = get_user_by_userid($user_id);
if ($user_id >= 1) {
    $picture = $user['ProfilePic'];
}
//Load the user's homepage
echo WORDING_PROFILE_PICTURE . '<br/>' ;
if (!empty($picture)) echo "<img src='" . MM_UPLOADPATH . $picture . "' alt='Profile Picture' />".'<br/>'; ?>
<a href="./viewprofile.php">View Profile</a><br />
<a href="./editprofile.php">Edit Profile</a><br />
<a href="./buycredits.php">Buy Credits</a><br />
<a href="./edit.php">Edit Account Settings</a><br />
<a href="./logout.php">Log Out (<?php echo $_SESSION['user_name']; ?>)</a>
</fieldset>
</body>
<?php include('_footer.php'); ?>
</html>