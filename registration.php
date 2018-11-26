<?php
    require('connect.php');
    $errorFlag = false;
    session_start();
    unset($_SESSION['returnmessage']);
    
    if(!filter_input(INPUT_POST, 'registerusername', FILTER_SANITIZE_FULL_SPECIAL_CHARS))
    {
        $errorFlag = true;
        $_SESSION['returnmessage'] = "invalid username";
    }
    elseif(!filter_input(INPUT_POST, 'registerpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS))
    {
        $errorFlag = true;
        $_SESSION['returnmessage'] = "invalid password";
    }
    elseif(!filter_input(INPUT_POST, 'registerpassword2', FILTER_SANITIZE_FULL_SPECIAL_CHARS))
    {
        $errorFlag = true;
        $_SESSION['returnmessage'] = "invalid password";
    }
    elseif(!filter_input(INPUT_POST, 'registeremail', FILTER_SANITIZE_FULL_SPECIAL_CHARS))
    {
        $errorFlag = true;
        $_SESSION['returnmessage'] = "invalid email";
    }

    $email = filter_input(INPUT_POST, 'registeremail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_input(INPUT_POST, 'registerusername', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'registerpassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password2 = filter_input(INPUT_POST, 'registerpassword2', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $type = 2;
    if($password <> $password2)
    {
        $errorFlag = true;
        $_SESSION['returnmessage'] = "passwords must match";
    }

    $userQuery = "SELECT * FROM users WHERE username = '$username' OR email='$email' LIMIT 1";
    $userStatement = $db->prepare($userQuery);
    $userStatement->execute();
    if($userStatement->rowCount() == 1)
    {
        $_SESSION['returnmessage'] = "username or email already taken";
    }
    if($errorFlag == true)
    {
        header('Location: login.php?registered=false');
    }
    else
    {
        $choppedAndScrewed = password_hash($password,PASSWORD_DEFAULT);
        $insertQuery = "INSERT INTO users (type,username,password,email) VALUES(:type,:username,:password,:email)";
        $insertStatement = $db->prepare($insertQuery);
        $insertStatement->bindValue(':type',$type);
        $insertStatement->bindValue(':username',$username);
        $insertStatement->bindValue(':password',$choppedAndScrewed);
        $insertStatement->bindValue(':email',$email);
        
        if($insertStatement->execute())
        {
            $_SESSION['username'] = $username;
            $_SESSION['type'] = $type;
            header('Location: login.php?registered=true');
        }
    }
?>