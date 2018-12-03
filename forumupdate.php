<?php
    require('connect.php');
    session_start();
    include('useronly.php');

    if(!filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT))
    {
        header('Location: index.php');
    }
    $id = filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT);

    $query = "SELECT * FROM forums WHERE forumId = :forumId";
    $statement = $db->prepare($query);
    $statement->bindValue(':forumId',$id,PDO::PARAM_INT);
    $statement->execute();
    $forumRow = $statement->fetch();

    $categoryQuery2 = "SELECT * FROM categories";
    $categoryStatement2 = $db->prepare($categoryQuery2);
    $categoryStatement2->execute();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="main.js"></script>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
</head>
<body>
    <div id="wrapper">

        <!-- with header include! -->
        <?php include('header.php');?>

        <div id="body">
            
            <form id="forum"
                action="forumupdating.php?forumId=<?=$forumRow['forumId']?>"
                method="post">
                <label for="title">Forum Title</label>
                <input id="title" name="title" type="text" value="<?=$forumRow['title']?>">

                <label for="description">Forum Description</label>
                <textarea name="description" id="description" cols="30" rows="10"><?=$forumRow['Description']?></textarea>

                <label for="rules">Forum Rules</label>
                <textarea name="rules" id="rules" cols="30" rows="10"><?=$forumRow['Rules']?></textarea>

                <select name="category" id="category">
                    <option value="">None</option>
                    <?php if($categoryStatement2->rowCount() !=0):?>
                        <?php while($categoryRow = $categoryStatement2->fetch()):?>
                            <option value="<?=$categoryRow['type']?>" 
                            <?php if($categoryRow['type'] === $forumRow['categoryId']):?>
                                selected="selected"
                            <?php endif?>
                            ><?=$categoryRow['name']?></option>
                        <?php endwhile?>
                    <?php endif?>
                </select>

                <button type="submit" name="update_button" value="update">Update</button>
                <button type="submit" name="delete_button" value="delete"  onclick="return confirm('Are you sure you wish to delete this post?')">Delete</button>
                
            </form>
        </div>

        <!-- with footer include! -->
        <?php include('footer.php');?>

    </div>
        
</body>
</html>