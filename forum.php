<?php
    require('connect.php');
    session_start();
    if($forumId = !filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php');
    }
    $forumId = filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT);
    //change this if statement because a refresh resubmits the post
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $username = $_SESSION['username'];
        $insertQuery = "INSERT INTO forumposts (title,body,forumId,username) VALUES (:title,:body,:forumId,:username)";
        $insertStatement = $db-> prepare($insertQuery);
        $insertStatement->bindValue(':title',$title);
        $insertStatement->bindValue(':body',$body);
        $insertStatement->bindValue(':forumId',$forumId);
        $insertStatement->bindValue(':username',$username);
        $insertStatement->execute();
    }

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
            <h3><?=$forum['title']?></h3>
            <img src="not implemented yet" alt="no image found">
            <h4>Description</h4>
            <?=$forum["Description"]?>
            <h4>Rules</h4>
            <?=$forum["Rules"]?>
            <h1>Contract Opportunities</h1>
            <ul>
                <?php if($postStatement->rowCount() !=0):?>
                    <?php while($row = $postStatement->fetch()):?>
                        <li>
                            <h4><?=$row["title"]?></h4><br/>
                            <?=$row["body"]?><br/>
                            <?php if(isset($_SESSION['username'])):?>
                                <?php if($_SESSION['username'] == 'admin'):?>
                                    <a href="postdelete.php?postId=<?=$row['postId']?>&forumId=<?=$forumId?>">DELETE</a>
                                <?php endif ?>
                            <?php endif ?>

                            <!-- removed this because i think that i might remove postSubmissions
                            ***************************************
                            <a href="post.php?postId=<?=$row["postId"]?>&userId=<?=$row["userId"]?>">View Post</a>
                            ***************************************-->
                        </li>
                    <?php endwhile?>
                <?php else :?>
                <a href="login.php">sign in to add a comment</a> 
                <?php endif?>
            </ul>
            

            <!-- check if user is signed in with an if $_Session["signedIn"] = true -->
            <?php if(isset($_SESSION['username'])):?>
                <form id="post" 
                action="forum.php?forumId=<?=$forumId?>"
                method="post">
                    <label for="title">Bid Title</label>
                    <input id="title" name="title" type="text">
                    <label for="body">Bid Content</label>
                    <textarea name="body" id="body" cols="30" rows="10"></textarea>
                    <button type="submit" value="Submit">Submit</button>
                </form>
            <?php endif ?>
            <!-- else echo guest to sign in to be able to comment on posts-->
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