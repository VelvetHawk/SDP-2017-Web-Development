
	<a href="index.php" class="logo"><strong>Proof</strong>readr</a> <!-- "font-size: 3em; -->


        <ul class="title-style">
            <?php if ((isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
                <li><a href="home.php" class="button">Dashboard</a></li>
                <li><a href="logout.php" class="button">Logout</a></li>
                <li><a href="about.php" class="button">About</a></li>
                <!-- if user not logged in display menus that were there before -->
            <?php else: ?>
                <li><a class="button" href="login.php">Login</a></li>
                <li><a class="button" href="signup.php">Sign up</a></li>
                <li><a class="button" href="about.php">About</a></li>
            <?php endif ?>
        </ul>


    <ul class="icons">
        <li><a href="http://www.twitter.com" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
        <li><a href="http://www.facebook.com" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
        <li><a href="http://www.snapchat.com" class="icon fa-snapchat-ghost"><span class="label">Snapchat</span></a></li>
        <li><a href="http://www.instagram.com" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
        <!-- <li><a href="#" class="icon fa-medium"><span class="label">Medium</span></a></li> -->
    </ul>


