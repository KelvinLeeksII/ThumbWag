<ul>
    <li><a href="./index.php">Home</a></li>
    <li><a href="./loginController.php">Login</a></li>
     <li>
        <form  class="navForm" action="profileController.php" method="post">
            <input type="submit" for="userSearch" value="User Search">
            <input type="text" name="userSearch">
            <input  type="hidden" name="action" value="searchForUser">
        </form>
    </li>
</ul>