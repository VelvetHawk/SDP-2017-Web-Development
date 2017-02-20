<?php
$page_title = "User authentication - Homepage";
include_once 'partials/headers.php';
?>
    <div class="container">


        <div class="flag">
            <h1>User authentication system</h1>
            <p class="lead">Use this document as a way to quickly start any new project.<br>
                All you get is this text and a mostly barebones HTML document.</p>
            <?php if(!isset($_SESSION['username'])): ?>
                <p class="lead">You are currently not signed in<br><a href="login.php">Login</a><br>
                    Not yet a member? <a href="signup.php">Sign up here</a>
                </p>
            <?php else: ?>
                <p class="lead">You are logged in as <?php if(isset($_SESSION['username'])) echo $_SESSION['username']; ?> <a href="logout.php">Logout</a></p>
            <?php endif ?>

            <?php echo $_SERVER['REMOTE_ADDR'] ."<br>" . $_SERVER['HTTP_USER_AGENT'] ;
            echo "<br>".time()."<br>";
            if(isset($_SESSION['last_active'])) {
                echo $_SESSION['last_active'];
            };
            ?>
        </div>

    </div>

<?php
include_once 'partials/footers.php'
?>

</body>
</html>