<?php

require('./model/database.php');
require_once('./model/accountDatabase.php');
session_start();
$action = filter_input(INPUT_GET, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = "showEditProfile";
    }
}


if ($action == "showEditProfile") {
    $userArray = $_SESSION['user'];
    $profileName = $userArray['profileName'];

    require("./view/editProfileView.php");
} else if ($action == "editProfile") {
    $userArray = $_SESSION['user'];
    $newProfileName = filter_input(INPUT_POST, 'currentUser');
    $currentPassword = filter_input(INPUT_POST, 'currentPassword');
    $newPassword1 = filter_input(INPUT_POST, 'newPassword1');
    $username = $userArray['username'];

    if (password_verify($currentPassword, $userArray['password'])) {//correct password
        if ($userArray['profileName'] != $newProfileName) {//if new profile name
            changeProfileName($username, $newProfileName);
        }

        if ($newPassword1 != "") {//if user entered new password
            $newPassword2 = filter_input(INPUT_POST, 'newPassword2');
            if ($newPassword1 === $newPassword2) {
                $passwordHash = password_hash($newPassword1, PASSWORD_BCRYPT);
                changePassword($username, $passwordHash);
            }
        }
        
            $userArray = getUser($userArray['username']);
            $_SESSION['user'] = $userArray[0];

            header("Location:./profileController.php");
    } else {
            $error = "invalid password";
            include('./view/error.php');
        }
    }    
