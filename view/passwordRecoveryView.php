<!DOCTYPE html>
<?php include "./view/header.php";
  // $userQuestion1="";
  // $userQuestion2="";?>

<body>
    <?php include "./view/navigation.php"; ?>

    <h1>Please enter Username</h</h1>
    <form action="./passwordRecoveryController.php" method="post">
        <div id="data">
            <label for ="currentUser">Username</label>
            <input type="text" name="currentUser">
            <input type="hidden" name="action" value="fetchSecurityQueustions" />
            </br>
        </div>
        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" name ="button" value="Show Questions"/>
        </div>
    </form>

    <?php echo $userQuestion1;
          echo $userQuestion2;
          ?>

</body>

<?php include './view//footer.php'; ?>
