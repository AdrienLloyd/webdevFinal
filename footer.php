<div id="footer">
----------------------------------------------------------------------------------
    <h3>BidderCoder</h3>
    <h3>An AlloyDynamics Company</h3>
        <ul>
            <li><a href="index.php?orderBy=None">Home</a></li>
            <li><a href="login.php">Login/Register</a></li>
            <li><a href="destroy.php">Log out</a></li>

            <?php if(isset($_SESSION['username'])):?>
                <li><a href="forumcreate.php">Create Forum</a></li>
            <?php else :?>
                <a href="login.php">sign in to create a Forum</a> 
            <?php endif ?>
        </ul>
</div>