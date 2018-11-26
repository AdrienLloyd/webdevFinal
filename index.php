<?php
    require('connect.php');
    session_start();
    
    //$query = "SELECT * FROM forums";
    //$statement = $db->prepare($query);
    //$statement->execute();
    

    if(isset($_GET['orderBy']) && isset($_SESSION['username']))
    {
        if($_GET['orderBy'] == 'createdDate')
        {
            $query = "SELECT * FROM forums ORDER BY createdDate DESC";
            $statement = $db->prepare($query);
            $statement->execute();
            $sortType = "Date Created";
        }
        if($_GET['orderBy'] == 'updatedDate')
        {
            $query = "SELECT * FROM forums ORDER BY updatedDate DESC";
            $statement = $db->prepare($query);
            $statement->execute();
            $sortType = "Date Updated";
        }
        if($_GET['orderBy'] == 'title')
        {
            $query = "SELECT * FROM forums ORDER BY title";
            $statement = $db->prepare($query);
            $statement->execute();
            $sortType = "Title";
        }
    }
    else
    {
        $query = "SELECT * FROM forums";
        $statement = $db->prepare($query);
        $statement->execute();
        $sortType = "None";
    }
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
            <h1>BidderCoders - Home</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login/Register</a></li>
                <li><a href="destroy.php">Log out</a></li>

                <?php if(isset($_SESSION['username'])):?>
                    <li><a href="forumcreate.php">Create Forum</a></li>
                <?php else :?>
                    <a href="login.php">sign in to create a Forum</a> 
                <?php endif ?>
            </ul>
            ----------------------------------------------------------------------------------
        </div>
        
        <!-- amen -->
        <div id="body">
            This is where you would introduce the website and sell it to people who are visiting it for the first time.
            Sell your service and explain prices and services in depth
            <br>
            <?php if(isset($_SESSION['username'])):?>
                <a href="index.php?orderBy=title">Sort By Title</a>
                <a href="index.php?orderBy=createdDate">Sort By Date Created</a>
                <a href="index.php?orderBy=updatedDate">Sort By Date Updated</a>
            <?php endif ?>
            <h4>Sort Type:  <?=$sortType?></h4>

            <ul>
                <?php if($statement->rowCount() !=0):?>
                    <?php while($row = $statement->fetch()):?>
                        <li>
                        
                            <img src="images/<?=$row["image"]?>" alt="No Images Available"><br>
                            <a href="forum.php?forumId=<?=$row['forumId']?>"><?=$row['title']?></a>
                            <?php if(isset($_SESSION['username'])):?>
                                <?php if($_SESSION['username'] == 'admin' || $_SESSION['username'] == $row['username']):?>
                                    <a href="forumdelete.php?forumId=<?=$row['forumId']?>">DELETE</a> 
                                    <a href="forumupdate.php?forumId=<?=$row['forumId']?>">UPDATE</a>
                                <?php endif?>
                            <?php endif ?>
                        </li>
                    <?php endwhile?>
                <?php endif?>
                <?php if(isset($_SESSION['username'])):?>
                    <li><a href="forumlist.php?orderBy=title">View Page List...</a></li>
                <?php endif ?>
            </ul>
        </div>

        <!-- make a header/footer include -->
        <div id="footer">
        ----------------------------------------------------------------------------------
        <h3>BidderCoder</h3>
        <h3>An AlloyDynamics Company</h3>
        <?php $statement->execute();?>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login/Register</a></li>
                <li><a href="destroy.php">Log out</a></li>

                <?php if(isset($_SESSION['username'])):?>
                    <li><a href="forumcreate.php">Create Forum</a></li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</body>
</html>