<?php
    $categoryQuery = "SELECT * FROM categories";
    $categoryStatement = $db->prepare($categoryQuery);
    $categoryStatement->execute();

?>
<div id="header">
    <h1>BidderCoders</h1>
    <ul>

        <li><a href="index.php?orderBy=None">Home</a></li>
        <li><a href="login.php">Login/Register</a></li>
        <li><a href="destroy.php">Log out</a></li>

        <?php if(isset($_SESSION['username'])):?>
            <li><a href="forumcreate.php">Create Forum</a></li>
        <?php else :?>
            <li><a href="login.php">sign in to create a Forum</a></li>
        <?php endif ?>

        <?php if(isset($_SESSION['type'])):?>
            <?php if($_SESSION['type'] == 1):?>
                <li><a href="admin.php">View Admin Page</a></li>
            <?php endif?>
        <?php endif ?>

    </ul>
    
    <form id="search"
        action="index.php?orderBy=<?=$_SESSION['orderBy']?>&category=<?=$_SESSION['category']?>"
        method="post">
        <select name="category" id="category">
            <option value="None">All Categories</option>
            <?php if($categoryStatement->rowCount() !=0):?>
                <?php while($row = $categoryStatement->fetch()):?>
                    <option value="<?=$row['type']?>"><?=$row['name']?></option>
                <?php endwhile?>
            <?php endif?>
            
        </select>
        <label for="search">Search Page Titles</label>
        <input id="search" name="search" type="text">
        <button type="submit" name="search_button" value="Submit">Submit</button>
    </form>
    ----------------------------------------------------------------------------------
</div>