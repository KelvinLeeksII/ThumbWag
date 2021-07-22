<?php

require('./model/database.php');
require_once('./model/accountDatabase.php');
session_start();

$followButton = "";
$likeButton = "";
$editProfileButton = "";
if (!isset($_SESSION['action'])) {
    $action = filter_input(INPUT_GET, 'action');
} else if (isset($_SESSION['action'])) {
    $action = $_SESSION['action'];
}

if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = "showProfile";
    }
}


if ($action == "showProfile") {//show logged in user profile
    $_SESSION['action'] = null;
    $userArray = $_SESSION['user'];
    $wags = getWagsByUser($userArray['username']);

    $user = $userArray['profileName'];
    $editProfileButton = "<form class='changePasswordButton' action='editProfileController.php' method='post'>
            <input type='submit' name='editProfile' value = 'Edit Profile'>
            <input  type='hidden' name='action' value='showEditProfile'>
            </form>";
    

    require("./view/userProfile.php");
} else if ($action == "searchForUser") {//show searched user
    $_SESSION['action'] = null;

    //finds searched user
    if (!isset($_SESSION['searchedUser'])) {
        $userSearch = filter_input(INPUT_GET, 'userSearch');
    } else if (isset($_SESSION['searchedUser'])) {
        $userSearch = $_SESSION['searchedUser'];
    }
    
    if ($userSearch == null) {
        $userSearch = filter_input(INPUT_POST, 'userSearch');
    }
    
    $userArray = getUser(trim($userSearch));
    if ($userArray == null) {//if searched user cannot be found
        $error = "Oh no! User could not be found! Did you spell the name correctly?";
        include('./view/error.php');
    } else {
        //assigns searched user
        $username = $userArray[0]['username'];

        //FOLLOW\UNFOLLOW BUTTON logic/display
        //if logged in user isnt following searched user, and isnt searched user  ADDS FOLLOW BUTTON
        if (isset($_SESSION['isLoggedIn']) && $username != $_SESSION['user']['username'] && checkFollow($_SESSION['user']['username'], $username) === 1) {
            $followButton = "<form  id='followButton' action='profileController.php' method='post'>
            <input type='submit' name='followProfile' value = 'Follow'>
            <input  type='hidden' name='action' value='followUser'>
            <input type='hidden' name='otherUser' value='$username'/>
            </form>";

            //if logged in user is following searched user, and isnt searched user. ADDS UNFOLLOW BUTTON
        } else if (isset($_SESSION['isLoggedIn']) && $username != $_SESSION['user']['username'] && checkFollow($_SESSION['user']['username'], $username) === 0) {
            $followButton = "<form  id='followButton' action='profileController.php' method='post'>
            <input type='submit' name='followProfile' value = 'Unfollow'>
            <input  type='hidden' name='action' value='unfollowUser'>
            <input type='hidden' name='otherUser' value='$username'/>
            </form>";
        }
        //ends FOLLOW/UNFOLLOW button logic



        //logged in user searched themselves LOL LOSER jk but there is a profile link in nav sooo
        if (isset($_SESSION['isLoggedIn']) && $username == $_SESSION['user']['username']) {
            $action = "showProfile";
            header("Location: ./profileController.php");
        }


        //sets user wags
        $_SESSION['action'] = NULL;
        $_SESSION['searchedUser'] = null;
        $user = $userArray[0]['profileName'];
        $wags = getWagsByUser($username);
        require("./view/userProfile.php");
    }
} else if ($action == 'unfollowUser') {
    $currentUser = $_SESSION['user']['username'];
    $userInQuestion = filter_input(INPUT_POST, 'otherUser');
    unfollowUser($currentUser, $userInQuestion);
    
    //returns user to userInQuestions profile 
    $_SESSION['action'] = "searchForUser";
    $_SESSION['searchedUser'] = $userInQuestion;
    header("Location: ./profileController.php");
} else if ($action == 'followUser') {
    $currentUser = $_SESSION['user']['username'];
    $userInQuestion = filter_input(INPUT_POST, 'otherUser');
    followUser($currentUser, $userInQuestion);

    //returns user to userInQuestions profile 
    $_SESSION['action'] = "searchForUser";
    $_SESSION['searchedUser'] = $userInQuestion;
    header("Location: ./profileController.php");
}