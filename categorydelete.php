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
    $type = $_GET['type'];

    $query = "DELETE FROM categories WHERE type = $type";
    $statement = $db->prepare($query);
    $statement->bindValue(':type',$type,PDO::PARAM_INT);
    if($statement->execute())
    {
        header('Location: categorylist.php');
    }
    exit();
?>