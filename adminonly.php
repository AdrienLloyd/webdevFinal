<?php
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php?orderBy=None');
    }
    if($_SESSION['type'] == 2)
    {
        header('Location: index.php?orderBy=None');
    }
?>