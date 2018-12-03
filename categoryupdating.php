<?php
    require('connect.php');
    session_start();
    include('adminonly.php');

    if (isset($_POST['update_button'])) 
    {
        if(!filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT))
        {
            header('Location: index.php');
        }
        if(!filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS))
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
    }

    else if(isset($_POST['delete_button'])) 
    {
        if(!filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT))
        {
            header('Location: index.php');
        }
        $type = filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT);
        
        $query = "DELETE FROM categories WHERE type = $type";
        $statement = $db->prepare($query);
        $statement->bindValue(':type',$type,PDO::PARAM_INT);
        if($statement->execute())
        {
            header('Location: categorylist.php');
        }
        exit();
    }
?>