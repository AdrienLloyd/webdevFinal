<?php
    require('connect.php');
    if($postId = !filter_input(INPUT_GET,'postId',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php');
    }
    $postId = filter_input(INPUT_GET,'postId',FILTER_SANITIZE_NUMBER_INT);
    if($userId = !filter_input(INPUT_GET,'userId',FILTER_SANITIZE_NUMBER_INT))
    {
        //maybe set an error message instead
        header('Location: index.php');
    }
    $userId = filter_input(INPUT_GET,'userId',FILTER_SANITIZE_NUMBER_INT);
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
    {
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $quote = filter_input(INPUT_POST,'quote',FILTER_SANITIZE_NUMBER_INT);

        $insertQuery = "INSERT INTO postsubmissions (title,body,quote,postId) VALUES (:title,:body,:quote,:postId)";
        $insertStatement = $db-> prepare($insertQuery);
        $insertStatement->bindValue(':title',$title);
        $insertStatement->bindValue(':body',$body);
        $insertStatement->bindValue(':quote',$quote);
        //this should be for userId when I am able to login and use session variables to retrieve user number
        //$insertStatement->bindValue(':userId0',$userId);
        $insertStatement->bindValue(':postId',$postId);
        $insertStatement->execute();
    }
    
    
    //retrieves the current post tha's been selected from the forum
    $postQuery = "SELECT * FROM forumposts WHERE postId = $postId";
    $postStatement = $db->prepare($postQuery);
    $postStatement->execute();
    $post = $postStatement->fetch();

    //retrieves the forums to fill the header and footer
    $query = "SELECT * FROM forums";
    $statement = $db->prepare($query);
    $statement->execute();

    //retrieves the bids for the forum post
    $submissionQuery = "SELECT * FROM postsubmissions WHERE postId = $postId ORDER BY submissionId DESC";
    $submissionStatement = $db->prepare($submissionQuery);
    $submissionStatement->execute();
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
            <h1>BidderCoders - <?=$post["title"]?></h1>
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
            <h1><?=$post["title"]?></h1>
            <img src="images/<?=$post["image"]?>" alt="No Images Available"><br>
            <?=$post["body"]?><br>
            -------------------------------------------------------------------------------------
            <h3>Bids</h3>
            <ul>
                <?php if($submissionStatement->rowCount() !=0):?>
                    <?php while($row = $submissionStatement->fetch()):?>
                        <li>
                            <h3><?=$row["title"]?><br></h3>
                            <?=$row["body"]?><br>
                            <h5>Quote Price: <?=$row["quote"]?></h5>
                            <a href="contact.php?userId=<?=$row["userId"]?>">Contact Bidder</a>
                            
                        </li>
                    <?php endwhile?>
                <?php endif?>
            </ul>

            <!-- check if user is signed in with an if $_Session["signedIn"] = true -->
            <form id="bid" 
		      action="post.php?postId=<?=$postId?>&userId=<?=$userId?>"
              method="post">
                <label for="title">Bid Title</label>
                <input id="title" name="title" type="text">
                <label for="body">Bid Content</label>
                <textarea name="body" id="body" cols="30" rows="10"></textarea>
                <label for="quote">Quoted Price</label>
                <input id="quote" name="quote" type="number">
                <button type="submit" value="Submit">Submit</button>
            </form>
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