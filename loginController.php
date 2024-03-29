<?php
require('./model/database.php');
require('./model/accountDatabase.php');
session_start();
$action = filter_input(INPUT_GET, 'action');

if ($action == NULL) {
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        
        if(isset ($_SESSION['isLoggedIn'])){//
            $action = 'logout';
        }else if(!isset ($_SESSION['isLoggedIn'])) {$action = 'showLogin';}
        
      
    }
}

if ($action == 'showLogin') {
    require("./view/loginView.php");
} else if ($action == 'logout') {
    $_SESSION = [];
    session_destroy();
    
    header("Location: ./index.php");
    
} else if ($action == 'submitLogin') {


    $button = filter_input(INPUT_POST, 'button');

    if ($button == 'Login') {
        $username = filter_input(INPUT_POST, 'currentUser');
        $password = filter_input(INPUT_POST, 'password');
        $user = getUser($username);
        

        if ($user != null) {
            $formatedUser = strtolower($user[0]["username"]);
            $formatedName = strtolower($username);
            if ($formatedName === $formatedUser && password_verify($password,$user[0]['password'])) {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['user'] = $user[0];
                header("Location: ./index.php");
            } else {
                $error= "invalid username or password";
                include('./view/error.php');
                
            }
        }else {
            $error="invalid username or password";
           include('./view/error.php');
        }
    } else if ($button == 'Make New Account') {
        require("./view/createAccountView.php");
    }else if($button == 'Change Password'){
        require("./view/changePasswordView.php");
    }
} else if ($action == "createAccount") {
    $username = filter_input(INPUT_POST, 'currentUser');
    $password = filter_input(INPUT_POST, 'password');
    $profileName = filter_input(INPUT_POST, 'profileName');
    
    $usernameCheck = getUser($username);
    if($usernameCheck[0] === null){
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        createAccount($username, $passwordHash, $profileName);
        header("Location: ./index.php");
    }else{
        $error = "Username already taken.";
        include('./view/error.php');
    }
    
}
else if($action =="changePassword"){
    $username = filter_input(INPUT_POST, 'currentUser');
    $currentPassword = filter_input(INPUT_POST, 'currentPassword');
    $newPassword1 = filter_input(INPUT_POST, 'newPassword1');
    $newPassword2 = filter_input(INPUT_POST, 'newPassword2');
      $user = getUser($username);

        if ($user != null) {
            $formatedUser = strtolower($user[0]["username"]);
            $formatedName = strtolower($username);
            
            if ($formatedName === $formatedUser && password_verify($currentPassword,$user[0]['password'])) {//if info is correct
                if($newPassword1 === $newPassword2){
                    $passwordHash = password_hash($newPassword1, PASSWORD_BCRYPT);
                    
                    changePassword($username,$passwordHash);
                    header("Location: ./index.php");
                    
                }else {
                    $error = "passwords do not match";
                    include('./view/error.php');
                }
                
            }
                
            } else {
                $error= "invalid username or password";
                include('./view/error.php');
                
            }
    
    
}
