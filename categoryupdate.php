<?php 
    require('connect.php');
    session_start();
    include('adminonly.php');

    $type = filter_input(INPUT_GET,'type',FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM categories WHERE type = :type";
    
    $statement = $db->prepare($query);
    $statement->bindValue(':type',$type,PDO::PARAM_INT);

    $statement->execute();

    $categoryRow = $statement->fetch();
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
            <form id="forum"
            action="categoryupdating.php?type=<?=$type?>"
            method="post">
                <label for="name">Category Name</label>
                <input id="name" name="name" type="text" value="<?=$categoryRow['name']?>">
                <button type="submit" name="update_button" value="update">Update</button>
                <button type="submit" name="delete_button" value="delete"  onclick="return confirm('Are you sure you wish to delete this post?')">Delete</button>
            </form>
        </div>
    
        <!-- with header include! -->
        <?php include('header.php');?>
    </div>
</body>
</html>