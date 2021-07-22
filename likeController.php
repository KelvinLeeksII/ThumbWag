<?php

require('./model/database.php');
require('./model/accountDatabase.php');
session_start();

$index = filter_input(INPUT_POST, 'count');
$filteredPost = filter_input_array(INPUT_POST);

for ($i = 0; $i <= $index; $i++) {

    if (array_key_exists($i, $filteredPost['likeButton'])) {//
        $wag = $filteredPost['likedWag'][$i];
        $wagUser = $filteredPost['wagUser'][$i];
        break;
    }
}
$currentUser = $_SESSION['user']['username'];
$userLikedWag = checkLikes($_SESSION['user']['username'], $wag, $wagUser);
$action = filter_input(INPUT_POST, 'action');

if ($action == "userProfile") {//if user was on a user profile
    if ($userLikedWag == 0) {//user liked wag
        unlikeWag($currentUser, $wag, $wagUser);
        $_SESSION['action'] = "searchForUser";
        $_SESSION['searchedUser'] = $wagUser;
        header("Location:./profileController.php");
    } else if ($userLikedWag == 1) {//user did not like wag
        likeWag($currentUser, $wag, $wagUser);
        $_SESSION['action'] = "searchForUser";
        $_SESSION['searchedUser'] = $wagUser;
        header("Location:./profileController.php");
    } else {
        $error = "Something went wrong, sorrrryyy";
        include('./views/error.php');
    }
} else {//if user was on home
    if ($userLikedWag == 0) {//user liked wag
        unlikeWag($currentUser, $wag, $wagUser);
        header("Location: ./index.php");
    } else if ($userLikedWag == 1) {//user did not like wag
        likeWag($currentUser, $wag, $wagUser);
        header("Location: ./index.php");
    } else {
        $error = "Something went wrong, sorrrryyy";
        include('./views/error.php');
    }
}