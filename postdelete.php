<?php 
    require('connect.php');
    session_start();
    include('useronly.php');
    
    if(!filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php?orderBy=None');
    }
    $forumId = filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT);
    
    if(!filter_input(INPUT_GET,'postId',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php?orderBy=None');
    }
    $postId = filter_input(INPUT_GET,'postId',FILTER_SANITIZE_NUMBER_INT);
    
    $query = "DELETE FROM forumposts WHERE postId = :postId";
    $statement = $db-> prepare($query);
    $statement->bindValue(':postId',$postId,PDO::PARAM_STR);
    if($statement->execute())
    {
        header('Location: forum.php?forumId='.$forumId);
    }
    exit();
?>