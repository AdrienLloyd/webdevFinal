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
    $type = $_GET['type'];
    $query = "SELECT * FROM categories WHERE type = $type";
    $statement = $db->prepare($query);
    $statement->bindValue(':type',$type,PDO::PARAM_INT);

    $statement->execute();

    $row = $statement->fetch();
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
    <form id="forum"
		action="categoryupdating.php?type=<?=$type?>"
        method="post">
        <label for="name">Category Name</label>
        <input id="name" name="name" type="text" value="<?=$row['name']?>">
        <button type="submit" name="update_button" value="update">Update</button>
    </form>
</body>
</html>