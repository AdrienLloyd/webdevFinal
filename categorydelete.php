<?php 
//your services are no longer required, please refer to categoryupdating.php
    require('connect.php');
    session_start();
    include('adminonly.php');
    
    $type = filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT);

    $query = "DELETE FROM categories WHERE type = $type";
    $statement = $db->prepare($query);
    $statement->bindValue(':type',$type,PDO::PARAM_INT);
    if($statement->execute())
    {
        header('Location: categorylist.php');
    }
    exit();
?>