<?php

require('./model/database.php');
require('./model/accountDatabase.php');
session_start();

$action = filter_input(INPUT_GET, 'action');
//defaults to homepage without action specified
if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = 'home';
    }
}

if ($action == 'home') {
    if (!isset($_SESSION['isLoggedIn'])) {
        $wags = getWags();
        require("./view/home.php");
    } else if (isset($_SESSION['isLoggedIn'])) {
        $wags = getFollowerWags($_SESSION['user']['username']);
        require("./view/userHome.php");
    }
} else if ($action == 'submitWag') {
    $user = $_SESSION['user']['username'];
    $wag = filter_input(INPUT_POST, 'wag');
    $fileName = $_FILES['image']['name'];
    $imagetmp = $_FILES['image']['tmp_name'];
    $imageType = $_FILES['image']['type'];
    $imageSize = $_FILES['image']['size'];

    if ($imagetmp != null) {//If wag had image
        if ($imageType === "image/jpg" || $imageType === "image/png" || $imageType === "image/jpeg") {//ensures image type
            if ($imageSize > 2000000) {//ensures file size
                $error = "Sorry! File is way too big. Try to keep it under 2 mb folks ";
                include('./view/error.php');
            }else {
                $fp = fopen($imagetmp, 'r');
            $content1 = fread($fp, filesize($imagetmp));

            fclose($fp);

            sendWagWithImage($wag, $user, $content1, $fileName);
            header("Location: ./index.php");
            }
            
        } else {
            $error = "Wrong file type, Only JPG, JPEG, and PNG's";
            include('./view/error.php');
        }
    } else {//send normal wag
        sendWag($wag, $user);
        header("Location: ./index.php");
    }
}

