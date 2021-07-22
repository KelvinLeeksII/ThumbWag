<!DOCTYPE html>
<?php include "./view//header.php"; ?>
<body>
    <?php include "./view/navigation.php"; ?>
    
    <h1>Please Log In</h1>
    <form action="./loginController.php" method="post">
        <div id="data">
            <label for ="currentUser">Username</label>
            <input type="text" name="currentUser">
            </br>
            <label for ="password">Password</label>
            <input type="password" name="password">
            <input type="hidden" name="action" value="submitLogin" />
            </br>
        </div>
        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" name = "button" value="Login"> 
            <input type="submit" name = "button" value="Make New Account"/>
            <input type="submit" name ="button" value="Change Password"/>
        </div>
    </form>
    
</body>

<?php include './view//footer.php'; ?>


