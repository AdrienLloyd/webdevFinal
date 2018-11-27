<?php
    require('connect.php');
    session_start();
    include('useronly.php');
    //if you press the update button
    if (isset($_POST['update_button'])) 
    {
        if(!isset($_SESSION['type']))
        {
            header('Location: index.php');
        }
        if(!filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT))
        {
            header('Location: index.php');
        }
        $forumId = filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $description = $_POST['description'];
        $rules = $rules = $_POST['rules'];
        
        date_default_timezone_set('America/Winnipeg');
        $updatedDate = date('Y-m-d');
        
        $query = "UPDATE forums SET title = :title, description = :description, rules = :rules, updatedDate = :updatedDate WHERE forumId = :forumId";
        
        $statement = $db-> prepare($query);
        
        $statement->bindValue(':title',$title);
        $statement->bindValue(':description',$description);
        $statement->bindValue(':rules',$rules);
        $statement->bindValue(':updatedDate',$updatedDate);
        $statement->bindValue(':forumId',$forumId, PDO::PARAM_INT);

        if($statement->execute())
        {
            header('Location: index.php');
        }
        exit();
    }
    

    //if you press the delete button
    else if (isset($_POST['delete_button'])) 
    {
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
            header('Location: index.php?orderBy=title');
        }
        exit();
    }
    
?>