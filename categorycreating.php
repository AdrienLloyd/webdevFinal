<?php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    if(!($_SESSION['type'] == 1))
    {
        header('Location: index.php');
    }
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $insertQuery = "INSERT INTO categories (name) VALUES (:name)";
    $insertStatement = $db-> prepare($insertQuery);
    $insertStatement->bindValue(':name',$name);
    $insertStatement->execute();
    header('Location: categorylist.php');
?>