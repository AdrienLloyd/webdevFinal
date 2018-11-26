<?php
    if($forumId = !filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php');
    }
    $forumId = filter_input(INPUT_GET,'id',FILTER_SANITIZE_NUMBER_INT);
    require('connect.php');
    

    $forumQuery = "SELECT * FROM forums WHERE forumId = $forumId";
    $forumStatement = $db->prepare($forumQuery);
    $forumStatement->execute();
    $forum = $forumStatement->fetch();

    $query = "SELECT * FROM forums";
    $statement = $db->prepare($query);
    $statement->execute();

    $postQuery = "SELECT * FROM forumposts WHERE forumId = $forumId";
    $postStatement = $db->prepare($postQuery);
    $postStatement->execute();
?>
<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>BidderCoders</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="main.js"></script>
</head>
<body>
    <div id="wrapper">
        <!-- make a header/footer include -->
        <div id="header">
            <h1>BidderCoders - <?=$forum["title"]?></h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if($statement->rowCount() !=0):?>
                    <?php while($row = $statement->fetch()):?>
                        <li><a href="forum.php?id=<?=$row['forumId']?>"><?=$row['title']?></a></li>
                    <?php endwhile?>
                <?php endif?>
            </ul>
            ----------------------------------------------------------------------------------
        </div>

        <div id="body">
            <h4>Description</h4>
            <?=$forum["Description"]?>
            <h4>Rules</h4>
            <?=$forum["Rules"]?>
            <h1>Contract Opportunities</h1>
            <ul>
                <?php if($postStatement->rowCount() !=0):?>
                    <?php while($row = $postStatement->fetch()):?>
                        <li>
                            <?=$row["title"]?><br>
                            <img src="images/<?=$row["image"]?>" alt="No Images Available"><br>
                            <?=$row["body"]?><br>
                            <a href="post.php?postId=<?=$row["postId"]?>&userId=<?=$row["userId"]?>">View Post</a>
                            
                        </li>
                    <?php endwhile?>
                <?php endif?>
            </ul>
        </div>
        <!-- make a header/footer include -->
        <div id="footer">
        --------------------------------------------------------------------------------
        <h3>BidderCoder</h3>
        <h3>An AlloyDynamics Company</h3>
        <?php $statement->execute();?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if($statement->rowCount() !=0):?>
                    <?php while($row = $statement->fetch()):?>
                        <li><a href="forum.php?id=<?=$row['forumId']?>"><?=$row['title']?></a></li>
                    <?php endwhile?>
                <?php endif?>
            </ul>
        </div>
    </div>
</body>
</html>