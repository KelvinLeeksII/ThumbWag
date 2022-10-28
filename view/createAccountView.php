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
          </br>
            <label for ="securityQuestion">Please select two security questions below. NOTE: If answers are lost then account CAN NOT be recovered.</label>
          </br>
            <select id="securityQuestion1" name="securityQuestion1">
              <option value="1"> What is your favorite piece of media?</option>
              <option value="2">What is your favorite drink?</option>
              <option value="3"> Where did you first orgasm? </option>
              <option value="4">What is your deepest fear?</option>
            </select>
            <input type="text" name="answer1">
          </br>
        </br>
            <select id="securityQuestion2" name="securityQuestion2">
              <option value="1"> What is your favorite piece of media?</option>
              <option value="2">What is your favorite drink?</option>
              <option value="3"> Where did you first orgasm? </option>
              <option value="4">What is your deepest fear?</option>
            </select>
            <input type="text" name="answer2">
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
