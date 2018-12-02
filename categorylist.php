<?php 
    require('connect.php');
    session_start();
    include('adminonly.php');

    $query = "SELECT * FROM categories";
    $statement = $db->prepare($query);
    $statement->execute();
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
</head>
<body>
    <div id="wrapper">

        <!-- with header include! -->
        <?php include('header.php');?>

        <div id="body">
            <ul>
                <?php if($statement->rowCount() !=0):?>
                    <?php while($row = $statement->fetch()):?>
                        <li>
                            <?=$row['name']?>
                            <a href="categoryupdate.php?type=<?=$row['type']?>">UPDATE</a>
                        </li>
                    <?php endwhile?>
                <?php endif?>
                <li><a href="categorycreate.php">Create a Category</a></li>
            </ul>
        </div>

        <!-- with footer include! -->
        <?php include('footer.php');?>
    </div>
</body>
</html>