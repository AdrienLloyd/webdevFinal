<?php 
    //your services are no longer required. please refer to forumupdating.php
    require('connect.php');
    session_start();
    include('useronly.php');
    
    if(!filter_input(INPUT_GET, 'forumId', FILTER_SANITIZE_FULL_SPECIAL_CHARS))
    {
        header('Location: index.php?orderBy=None');
    }
    $forumId = filter_input(INPUT_GET, 'forumId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $query = "DELETE FROM forums WHERE forumId = :forumId";
    $statement = $db-> prepare($query);
    $statement->bindValue(':forumId',$forumId,PDO::PARAM_STR);
    if($statement->execute())
    {
        header('Location: index.php?orderBy=title');
    }
    exit();
?>