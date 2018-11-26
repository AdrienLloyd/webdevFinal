<?php 
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    if(!($_SESSION['type'] == 1))
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
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <div id="wrapper">
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
                <?php if(isset($_SESSION['username'])):?>
                    <li><a href="categorycreate.php">Create Category</a></li>
                <?php else :?>
                    <a href="login.php">sign in to view Categories list</a> 
                <?php endif ?>
            </ul>
            ----------------------------------------------------------------------------------
        </div>

        <div id="body">
            <ul>
                <?php if($statement->rowCount() !=0):?>
                    <?php while($row = $statement->fetch()):?>
                        <li>
                            <?=$row['name']?>
                            <a href="categorydelete.php?type=<?=$row['type']?>">DELETE</a> 
                            <a href="categoryupdate.php?type=<?=$row['type']?>">UPDATE</a>
                        </li>
                    <?php endwhile?>
                <?php endif?>
                <li><a href="categorycreate.php">Create a Category</a></li>
            </ul>
        </div>

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
                <?php else :?>
                    <a href="login.php">sign in to create a Forum</a>
                <?php endif ?>
                <?php if(isset($_SESSION['username'])):?>
                    <li><a href="categorycreate.php">Create Category</a></li>
                <?php else :?>
                    <a href="login.php">sign in to view Categories list</a> 
                <?php endif ?>
            </ul>
        </div>
    </div>
</body>
</html>