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
        $action = 'fetchRecoveryQuestions';
    }
}

if ($action == 'fetchRecoveryQuestions') {

}
