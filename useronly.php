<?php
    if(!isset($_SESSION['type']))
    {
        header('Location: index.php?orderBy=None');
    }
?>