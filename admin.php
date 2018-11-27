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
                <li><a href="adminuserlist.php">View User List</a></li>
                <li><a href="categorylist.php">View Category List</a></li>
            </ul>
        </div>
            
        <!-- with footer include! -->
        <?php include('footer.php');?>
    </div>
</body>
</html>
