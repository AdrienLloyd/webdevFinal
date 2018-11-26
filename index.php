<?php
    require('connect.php');
    session_start();
    
    $query = "SELECT * FROM forums";
    //for category
    if(!isset($_SESSION['category']) || $_GET['orderBy'] == "None")
    {
        $_SESSION['category'] = "None";
    }
    if(isset($_POST['category']))
    {
        $_SESSION['category'] = $_POST['category'];
    }
    if($_SESSION['category'] != "None")
    {
        $query .= " WHERE categoryId = ". $_SESSION['category'];
    }

    //for search
    if (isset($_POST['search_button']) && $_SESSION['category'] != "None") 
    {
        $search = $_POST['search'];
        $query .= " AND title LIKE '%".$search."%'";
    }
    if(isset($_POST['search_button']) && $_SESSION['category'] == "None")
    {
        $search = $_POST['search'];
        $query .= " WHERE title LIKE '%".$search."%'";
    }

    //for order by
    if(!isset($_SESSION['orderBy']) || $_GET['orderBy'] == "None")
    {
        $_SESSION['orderBy'] = "None";
    }
    if(isset($_GET['orderBy']))
    {
        $_SESSION['orderBy'] = $_GET['orderBy'];
    }
    if($_SESSION['orderBy'] != "None")
    {
        $query .= " ORDER BY " . $_SESSION['orderBy'];
        if($_SESSION['orderBy'] == "createdDate" || $_SESSION['orderBy'] == "updatedDate")
        {
            $query .= " DESC";
        }
    }
    $statement = $db->prepare($query);
    $statement->execute();
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
            This is where you would introduce the website and sell it to people who are visiting it for the first time.
            Sell your service and explain prices and services in depth
            <br>

            <?php if(isset($_SESSION['username'])):?>
                <a href="index.php?orderBy=title">Sort By Title</a>
                <a href="index.php?orderBy=createdDate">Sort By Date Created</a>
                <a href="index.php?orderBy=updatedDate">Sort By Date Updated</a>
            <?php endif ?>
            <h4>Sort Type:  <?=$_SESSION['orderBy']?></h4>
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
            </ul>
        </div>

        <!-- with footer included! -->
        <?php include('footer.php');?>
        
    </div>
</body>
</html>