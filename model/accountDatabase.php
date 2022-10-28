<?php

function createAccount($username, $password, $profileName, $question1,$answer1,$question2 ,$answer2) {
    global $db;

    $query = "INSERT INTO ACCOUNT (username, password, profileName,recoveryQuestion1,answer1,recoveryQuestion2, answer2) VALUES (:username, :password, :profileName,:recoveryQuestion1, :answer1, :recoveryQuestion2, :answer2)";
    $statement = $db->prepare($query);

    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':profileName', $profileName);
    $statement->bindValue(':recoveryQuestion1', $question1);
    $statement->bindValue(':answer1', $answer1);
    $statement->bindValue(':recoveryQuestion2', $question2);
    $statement->bindValue(':answer2', $answer2);

    $statement->execute();
    $statement->closeCursor();
}

function getUser($username) {
    global $db;

    $query = "select * from account where username like :username";
    $statement = $db->prepare($query);

    $statement->bindValue(':username', $username);
    $statement->execute();
    $user = $statement->fetchAll();
    $statement->closeCursor();
    return $user;
}

function sendWag($wag, $username) {
    global $db;
    $trimmedWag = trim($wag);
    $userId = getUserID($username);

    $query = "INSERT INTO WAGS (userID, wag) VALUES (:userId, :wag)";
    $statement = $db->prepare($query);

    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':wag', $trimmedWag);

    $statement->execute();
    $statement->closeCursor();
}

function sendWagWithImage($wag, $username,$image,$imageName) {
    global $db;
    $trimmedWag = trim($wag);
    $userId = getUserID($username);

    $query = "INSERT INTO WAGS (userID, wag ,image,imageName) VALUES (:userId, :wag , :image, :imageName)";
    $statement = $db->prepare($query);

    $statement->bindValue(':userId', $userId);
    $statement->bindValue(':wag', $trimmedWag);
    $statement->bindValue(':image', $image);
    $statement->bindValue(':imageName', $imageName);

    $statement->execute();
    $statement->closeCursor();
}

function getWags() {
    global $db;

    $query = "SELECT account.username, wags.wag, wags.likes, wags.image FROM wags INNER JOIN account on wags.userID = account.id order by wags.id DESC";
    $statement = $db->prepare($query);


    $statement->execute();
    $wags = $statement->fetchAll();
    $statement->closeCursor();
    return $wags;
}

function getWagsByUser($username) {
    global $db;
    $userID = getUserID($username);
    $query = "SELECT account.username, wags.wag, wags.likes, wags.image FROM wags INNER JOIN account on wags.userID = account.id WHERE wags.userID = :userID ORDER BY wags.id DESC ";
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);

    $statement->execute();
    $wags = $statement->fetchAll();
    $statement->closeCursor();
    return $wags;
}

function getFollowerWags($username) {
    global $db;

    $userID = getUserID($username);
    $query = "select account.username, wags.wag, wags.image, wags.likes from wags" .
            " inner join account on account.id = wags.userID" .
            " inner join followlist on wags.userID = followlist.followingAccountID" .
            " where followlist.currentAccountID = :userID";
    $statement = $db->prepare($query);
    //  $userID = $userIDArray[0]['id'];
    $statement->bindValue(':userID', $userID);

    $statement->execute();
    $wags = $statement->fetchAll();
    $statement->closeCursor();
    return $wags;
}

function likeWag($currentUser, $wag, $wagUser) {
    //add like to table
    global $db;
    $wagID = getWagID($wag, $wagUser);
    $userID = getUserID($currentUser);

    $query = "INSERT INTO `waglikes` (`id`, `wagID`, `likedByID`) VALUES (NULL, :wagID, :userID)";
    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':wagID', $wagID);

    $statement->execute();
    $statement->closeCursor();
    //increase like int
    $update = "UPDATE wags SET likes = likes+1 where id = :wagID";
    $newStatement = $db->prepare($update);

    $newStatement->bindValue(':wagID', $wagID);

    $newStatement->execute();
    $newStatement->closeCursor();
}

function unlikeWag($currentUser, $wag, $wagUser) {
    //remove like from like table
    global $db;
    $wagID = getWagID($wag, $wagUser);
    $userID = getUserID($currentUser);

    $query = "delete from waglikes where wagID = :wagID and likedByID = :userID";
    $statement = $db->prepare($query);

    $statement->bindValue(':wagID', $wagID);
    $statement->bindValue(':userID', $userID);

    $statement->execute();
    $statement->closeCursor();
    //increase like int
    $update = "UPDATE wags SET likes = likes-1 where id = :wagID";
    $newStatement = $db->prepare($update);

    $newStatement->bindValue(':wagID', $wagID);

    $newStatement->execute();
    $newStatement->closeCursor();
}

function unfollowUser($currentUser, $userInQuestion) {
    global $db;
    $currentUserID = getUserID($currentUser);
    $userInQuestionID = getUserID($userInQuestion);

    $query = "delete from followlist where currentAccountID = :currentUser AND followingAccountID = :userInQuestion";
    $statement = $db->prepare($query);

    $statement->bindValue(':currentUser', $currentUserID);
    $statement->bindValue(':userInQuestion', $userInQuestionID);

    $statement->execute();
    $statement->closeCursor();
}

function followUser($currentUser, $userInQuestion) {
    global $db;
    $currentUserID = getUserID($currentUser);
    $userInQuestionID = getUserID($userInQuestion);

    $query = "insert into followlist(currentAccountID,followingAccountID) VALUES (:currentUser,:userInQuestion)";
    $statement = $db->prepare($query);

    $statement->bindValue(':currentUser', $currentUserID);
    $statement->bindValue(':userInQuestion', $userInQuestionID);

    $statement->execute();
    $statement->closeCursor();
}

function changePassword($username, $password) {
    global $db;

    $query = "UPDATE ACCOUNT SET password = :password where username= :username ";
    $statement = $db->prepare($query);

    $statement->bindValue(':password', $password);

    $statement->bindValue(':username', $username);

    $statement->execute();
    $statement->closeCursor();
}

function changeProfileName($username, $profilename){
     global $db;

    $query = "UPDATE ACCOUNT SET profilename = :profilename where username= :username ";
    $statement = $db->prepare($query);

    $statement->bindValue(':profilename', $profilename);

    $statement->bindValue(':username', $username);

    $statement->execute();
    $statement->closeCursor();

}

//helper methods
function getUserID($username) {
    global $db;

    $query = "SELECT id FROM `account` WHERE username = :username";
    $statement = $db->prepare($query);
    $statement->bindValue(':username', $username);

    $statement->execute();
    $userID = $statement->fetchAll();
    $statement->closeCursor();
    return $userID[0]['id'];
}

function getWagID($wag, $wagUser) {
    global $db;
    $waguUserID = getUserID($wagUser);
    $query = "SELECT id FROM wags WHERE wag LIKE :wag and userID = :userID";
    $statement = $db->prepare($query);

    $statement->bindValue(':userID', $waguUserID);
    $statement->bindValue(':wag', $wag);

    $statement->execute();
    $wagID = $statement->fetchAll();
    $statement->closeCursor();
    return $wagID[0]['id'];
}

//returns 0 if user liked wag, returns 1 if user did not like wag
function checkLikes($username, $wag, $wagUser) {
    global $db;
    $userID = getUserID($username);
    $wagUserID = getUserID($wagUser);
    $query = "SELECT * FROM waglikes " .
            "inner join wags on wags.id = waglikes.wagID WHERE wags.wag LIKE :wag and waglikes.likedByID = :userID and wags.userID = :wagUserID";
    $statement = $db->prepare($query);
    $statement->bindValue(':wag', $wag);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':wagUserID', $wagUserID);

    $statement->execute();
    $wags = $statement->fetchAll();
    $statement->closeCursor();

    $result = -1;
    if (empty($wags)) {//did not like wag
        $result = 1;
    } else if (!empty($wags)) {//did like wag
        $result = 0;
    }
    return $result;
}

function checkFollow($currentUser, $userInQuestion) {
    global $db;
    $currentUserID = getUserID($currentUser);
    $userInQuestionID = getUserID($userInQuestion);
    $query = "SELECT * FROM followlist where currentAccountID = :currentUser AND followingAccountID = :userInQuestion";
    $statement = $db->prepare($query);
    $statement->bindValue(':currentUser', $currentUserID);
    $statement->bindValue(':userInQuestion', $userInQuestionID);


    $statement->execute();
    $following = $statement->fetchAll();
    $statement->closeCursor();

    $result = -1;
    if (empty($following)) {//did not follow
        $result = 1;
    } else if (!empty($following)) {//did follow
        $result = 0;
    }
    return $result;
}
