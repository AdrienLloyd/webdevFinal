<div id="footer">
----------------------------------------------------------------------------------
    <h3>BidderCoder</h3>
    <h3>An AlloyDynamics Company</h3>
    <?php $statement->execute();?>
        <ul>
            <li><a href="index.php?orderBy=None">Home</a></li>
            <li><a href="login.php">Login/Register</a></li>
            <li><a href="destroy.php">Log out</a></li>

            <?php if(isset($_SESSION['username'])):?>
                <li><a href="forumcreate.php">Create Forum</a></li>
            <?php else :?>
                <a href="login.php">sign in to create a Forum</a> 
            <?php endif ?>

            <?php if(isset($_SESSION['type'])):?>
                <?php if($_SESSION['type'] == 1):?>
                    <li><a href="categorylist.php">View Category List</a></li>
                <?php endif?>
            <?php endif ?>
        </ul>
</div>