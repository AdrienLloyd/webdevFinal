<?php
    require('connect.php');
    session_start();
    //load the data for the header and footer
    
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')
    {
        if(!filter_input(INPUT_POST,'loginusername',FILTER_SANITIZE_FULL_SPECIAL_CHARS))
        {
            header('Location: index.php');
        }
        $username = filter_input(INPUT_POST, 'loginusername', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if(!filter_input(INPUT_POST,'loginpassword',FILTER_SANITIZE_FULL_SPECIAL_CHARS))
        {
            header('Location: index.php');
        }
        $password = filter_input(INPUT_POST, 'loginpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $passwordhash = password_hash($password,PASSWORD_DEFAULT);

        $userQuery = "SELECT * FROM users WHERE username = '$username'";
        $userStatement = $db->prepare($userQuery);
        $userStatement->execute();
        $dbobject = $userStatement->fetch();
        
        //echo($dbobject['password']);
        if(password_verify($password,$dbobject['password']))
        {
            $_SESSION['type'] = $dbobject['type'];
            $_SESSION['username'] = $dbobject['username'];
        }
    }
    if(isset($_SESSION['returnmessage']))
    {
        $message = $_SESSION['returnmessage'];
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
        <!-- with header include! -->
        <?php include('header.php');?>

        <div id="body">
            <!-- this page should include a login form and a register form -->
            <h3>Login</h3>
            <form id="login"
		      action="login.php"
              method="post">
            <label for="loginusername">username</label>
            <input id="loginusername" name="loginusername" type="text">
            <label for="loginpassword">password</label>
            <input id="loginpassword" name="loginpassword" type="password">
            <button type="submit" value="login" form="login">Login</button>

            <?php if(isset($_SESSION['username']) && (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')):?>
                <br/> You are logged in.

            <?php elseif(isset($_GET['logout'])) :?>
                <?php if($_GET['logout'] == 'true') :?>
                    <br/> Logout succesful.
                <?php endif?>
            <?php elseif( (!isset($_SESSION['username'])) && (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST')) : ?>
                <br/> loggin failed.
            <?php endif?>

            <h3>Register</h3>
            </form>

            <form id="register"
		      action="registration.php"
              method="post">
            <label for="registerusername">username</label>
            <input id="registerusername" name="registerusername" type="text">

            <label for="registeremail">email</label>
            <input id="registeremail" name="registeremail" type="text">

            <label for="registerpassword">password</label>
            <input id="registerpassword" name="registerpassword" type="password">

            <label for="registerpassword2">re-enter password</label>
            <input id="registerpassword2" name="registerpassword2" type="password">

            <button type="submit" value="register" form="register">Register</button>
            </form>
            <?php if(isset($_GET['registered'])) :?>
                <?php if($_GET['registered'] === 'true') :?>
                    <br/> Registration was succesful!
                <?php elseif($_GET['registered'] === 'false'):?>
                    <br/> <?=$_SESSION['returnmessage']?>
                <?php endif?>
            <?php endif?>
        </div>

        <?php if(isset($_SESSION['type'])) :?>
            <?php if($_SESSION['type'] == 1):?>
                <a href="adminuserlist.php">View User List</a>
            <?php endif ?>
        <?php endif ?>

        <!-- with footer include! -->
        <?php include('footer.php');?>
    </div>
</body>
</html>