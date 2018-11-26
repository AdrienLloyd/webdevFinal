<?php
    //does this page have a use anymore? or did i use something else?
    require('connect.php');
    session_start();

    $username = filter_input(INPUT_POST, 'loginusername', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'loginpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT * FROM users WHERE username = '$username'";
    $statement = $db->prepare($query);
    $statement->execute();
    $dbpassword = $statement->fetch();

    if($password == $dbpassword['password'])
    {
        
        $_SESSION['username'] = $dbpassword['username'];
        header('Location: index.php');
    }
    exit();
?>