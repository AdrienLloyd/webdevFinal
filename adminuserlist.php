<?php
    require('connect.php');
    session_start();
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php');
    }
    if($_SESSION['type'] == 2)
    {
        header('Location: index.php');
    }
    $query = "SELECT * FROM users";
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
<a href="index.php">Go Home</a>
    <?php if($statement->rowCount() !=0):?>
        <?php while($row = $statement->fetch()):?>
            <li><?=$row['username']?><a href="admindeleteuser.php?username=<?=$row['username']?>"> DELETE</a></li>
        <?php endwhile?>
    <?php endif?>
</body>
</html>
