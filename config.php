<?php 
    /* Database configuration */
    $hostName = 'sql106.epizy.com';
    $userName = 'epiz_31879709';
    $password = 'I1F7xGXlmm';
    $dbName = 'epiz_31879709_XXX';
    try{
        $connection = mysqli_connect($hostName, $userName, $password, $dbName);
    }catch(Exception $e){

    }