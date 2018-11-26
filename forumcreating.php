<?php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = $_POST['description'];
    $rules = $_POST['rules'];
    $categoryId = $_POST['category'];

    date_default_timezone_set('America/Winnipeg');
    $date = date('Y-m-d');

    $username = $_SESSION['username'];

    $insertQuery = "INSERT INTO forums (title,description,rules,createdDate,username,categoryId) VALUES (:title,:description,:rules,:createdDate,:username,:categoryId)";
    $insertStatement = $db-> prepare($insertQuery);
    $insertStatement->bindValue(':title',$title);
    $insertStatement->bindValue(':description',$description);
    $insertStatement->bindValue(':rules',$rules);
    $insertStatement->bindValue(':createdDate',$date);
    $insertStatement->bindValue(':username',$username);
    $insertStatement->bindValue(':categoryId',$categoryId);
    $insertStatement->execute();
    header('Location: index.php');
    //what could i ever possibly do to turn this into a user page
    //header('Location: adminforumlist.php?orderBy=title');
?>