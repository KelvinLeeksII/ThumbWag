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
    
    <h1>Please Change Password</h1>
    <form action="./loginController.php" method="post">
        <div id="data">
            <label for ="currentUser">Username</label>
            <input type="text" name="currentUser" value="test">
            </br>
            <label for ="currentPassword">Current Password</label>
            <input type="password" name="currentPassword">
            </br>
            <label for ="newPassword1">New Password</label>
            <input type="password" name="newPassword1">
            </br>
            <label for ="newPassword2">Please enter new password again</label>
            <input type="password" name="newPassword2">
            <input type="hidden" name="action" value="changePassword" />
            </br>
        </div>
        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Change Password"/>
        </div>
    </form>
    
  
</body>

<?php include './view/footer.php'; ?>


