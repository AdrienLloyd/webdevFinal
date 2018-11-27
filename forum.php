<?php
    require('connect.php');
    session_start();
    if($forumId = !filter_input(INPUT_GET,'forumId',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php?orderBy=None');
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
        
        if($insertStatement->execute())
        {
            $_SERVER['REQUEST_METHOD'] == null;
        }
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
        <!-- with header include! -->
        <?php include('header.php');?>

        <div id="body">
            <h3><?=$forum['title']?></h3>
            <img src="<?=$forum['image']?>" alt="no image found">
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
                        </li>
                    <?php endwhile?>
                <?php else :?>
                    Be the first to add a comment!
                <?php endif?>
            </ul>
            

            <!-- check if user is signed in with an if $_Session"signedIn" = true -->
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
            <?else :?>
                You must <a href="login.php">Sign In</a> To post a comment.
            <?php endif ?>
            <!-- else echo guest to sign in to be able to comment on posts-->
        </div>
        
        <!-- with footer include! -->
        <?php include('footer.php');?>
    </div>
</body>
</html>