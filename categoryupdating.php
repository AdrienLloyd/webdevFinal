<?php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    if(!filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT))
    {
        header('Location: index.php');
    }
    $type = filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT);
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "UPDATE categories SET name = :name WHERE type = :type";
    
    $statement = $db-> prepare($query);
    
    $statement->bindValue(':name',$name);
    $statement->bindValue(':type',$type, PDO::PARAM_INT);

    if($statement->execute())
    {
        header('Location: categorylist.php');
    }
    exit();
?>