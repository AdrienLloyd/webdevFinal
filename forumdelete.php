<?php 
    //your services are no longer required. please refer to forumupdating.php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    $forumId = filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "DELETE FROM forums WHERE forumId = :forumId";
    $statement = $db-> prepare($query);
    $statement->bindValue(':forumId',$forumId,PDO::PARAM_STR);
    if($statement->execute())
    {
        header('Location: adminforumlist.php?orderBy=title');
    }
    exit();
?>