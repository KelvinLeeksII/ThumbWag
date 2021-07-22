<?php
 
    try{
        $dataSourceName = "mysql:host=localhost;dbname=thumb_wag";
        $userName = 'root';
        $password = 'test';
        $db = new PDO($dataSourceName,$userName,$password);
         }catch(PDOException $ex){
             $errorMessage = $ex->getMessage();
             echo"Something happened! : " . $errorMessage;
             
         }
?>