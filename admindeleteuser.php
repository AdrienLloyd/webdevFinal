<?php 
    require('connect.php');
    session_start();
    include('adminonly.php');
    
    $username = filter_input(INPUT_GET,'username',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "DELETE FROM users WHERE username = :username";
    $statement = $db-> prepare($query);
    $statement->bindValue(':username',$username,PDO::PARAM_STR);
    if($statement->execute())
    {
        header('Location: adminuserlist.php');
    }
    exit();
?>