<!DOCTYPE html>
<?php include "./view/header.php"; ?>
<body>
    <?php include "./view/navigation.php"; ?>
    
    <h1>Please Enter Information</h1>
    <form action="./loginController.php" method="post">
        <div id="data">
            <label for ="currentUser">Username (This will be your account name. People can find you by your account name. Account names are unique.)</label>
            <input type="text" name="currentUser">
            </br>
            <label for ="password">Password</label>
            <input type="password" name="password">
            </br>
            <label for ="profileName">Profile Name (This is the name displayed on your profile)</label>
            <input type="text" name="profileName">
            <input type="hidden" name="action" value="createAccount" />
            </br>
        </div>
        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Create Account"/>
        </div>
    </form>
    
  
</body>

<?php include './view/footer.php'; ?>


