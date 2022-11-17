<?php

require('./model/database.php');
require_once('./model/accountDatabase.php');
session_start();

$userQuestion1="";
$userQuestion2="";

$action = filter_input(INPUT_GET, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = 'usernamePrompt';
    }
}
if ($action == 'usernamePrompt'){

  require("./view/passwordRecoveryView.php");
}else if ($action == 'fetchSecurityQueustions') {
    $user= filter_input(INPUT_POST, 'currentUser');
    $userInfo = getRecoveryInfo($user);

    if ($userInfo != null) {
      $userQuestion2 = $userInfo[0]['recoveryQuestion1'];
      //$userQuestion

      //UNHASH QUESTIONS
      require("./view/passwordRecoveryView.php");
}else {
    $userQuestion2 = 'no user found';
  require("./view/passwordRecoveryView.php");

}
}//end fetchRecoveryQuestions
