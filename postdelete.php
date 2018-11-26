<?php 
    //your services are no longer required. please refer to forumupdating.php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    if($forumId = !filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php');
    }
    $forumId = filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT);
    $postId = filter_input(INPUT_GET,'postId',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    $query = "DELETE FROM forumposts WHERE postId = :postId";
    $statement = $db-> prepare($query);
    $statement->bindValue(':postId',$postId,PDO::PARAM_STR);
    if($statement->execute())
    {
        header('Location: forum.php?forumId='.$forumId);
    }
    exit();
?>