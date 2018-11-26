<?php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    $query = "SELECT * FROM categories";
    $statement = $db->prepare($query);
    $statement->execute();
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
<!-- a forum will be created and will have a title, Description, createdDate, Rules, updatedDate -->
    <a href="index.php">Go Home</a>
    <form id="forum"
		action="forumcreating.php"
        method="post">
        <label for="title">Forum Title</label>
        <input id="title" name="title" type="text">
        <label for="description">Forum Description</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <label for="rules">Forum Rules</label>
        <textarea name="rules" id="rules" cols="30" rows="10"></textarea>
        <select name="category" id="category">
            <?php if($statement->rowCount() !=0):?>
                <?php while($row = $statement->fetch()):?>
                    <option value="<?=$row['type']?>"><?=$row['name']?></option>
                <?php endwhile?>
            <?php endif?>
        </select>
        <button type="submit" value="Submit">Submit</button>
    </form>
</body>
</html>