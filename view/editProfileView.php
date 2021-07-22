<!DOCTYPE html>
<?php include "./view/header.php"; ?>
<body>
      <?php
    if (isset($_SESSION['isLoggedIn'])) {//if user is logged in show logout nav
        include "./view/navigationWithLogout.php";
    } else {
        include "./view/navigation.php";
    }//if user is not logged in, show login nav
    ?>
    
    <h1>Edit Profile Information</h1>
    <form action="./editProfileController.php" method="post">
        <div id="data">
            <label for ="currentUser">Profile Name</label>
            <input type="text" name="currentUser" value ="<?php echo$profileName ?>">
            </br>
            <label for ="currentPassword">Current Password</label>
            <input type="password" name="currentPassword">
            </br>
            <label for ="newPassword1">New Password (if changing password)</label>
            <input type="password" name="newPassword1">
            </br>
            <label for ="newPassword2">Please enter new password again</label>
            <input type="password" name="newPassword2">
            <input type="hidden" name="action" value="editProfile" />
            </br>
        </div>
        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" name = "submitChanges" value="Submit Changes"/>
        </div>
    </form>
    
  
</body>

<?php include './view/footer.php'; ?>


