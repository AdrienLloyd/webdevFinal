<?php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    if(!filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT))
    {
        header('Location: index.php');
    }
    $id = filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM forums WHERE forumId = :forumId";

    $statement = $db->prepare($query);

    $statement->bindValue(':forumId',$id,PDO::PARAM_INT);

    $statement->execute();

    $row = $statement->fetch();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
<!-- a forum will be updated and will have a title, Description, createdDate, Rules, updatedDate -->
    <form id="forum"
		action="forumupdating.php?forumId=<?=$row['forumId']?>"
        method="post">
        <label for="title">Forum Title</label>
        <input id="title" name="title" type="text" value="<?=$row['title']?>">
        <label for="description">Forum Description</label>
        <textarea name="description" id="description" cols="30" rows="10"><?=$row['Description']?></textarea>
        <label for="rules">Forum Rules</label>
        <textarea name="rules" id="rules" cols="30" rows="10"><?=$row['Rules']?></textarea>
        <button type="submit" name="update_button" value="update">Update</button>
        <button type="submit" name="delete_button" value="delete">Delete</button>
    </form>
</body>
</html>