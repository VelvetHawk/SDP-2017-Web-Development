<?php if(!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
    <!-- DO NOTHING -->
<?php else: ?>
    <div id="sidebar">
        <div class="inner">

            <!-- Search -->
            <section id="search" class="alt">
                <form method="post" action="search.php">
                    <input type="text" name="query" id="query" placeholder="Search" />
                </form>
            </section>

            <!-- Menu -->
            <nav id="menu">
                <header class="major">
                    <h2>Menu</h2>
                </header>
                <ul>
                    <!-- DON'T FORGET TO ADD LINK TO FLAGGED TASKS -->
                    <li><a href="home.php">Home</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="create-task.php">Create a Task</a></li>
                    <li><a href="claimed-tasks.php">Claimed Tasks</a></li>
                    <?php
                        $user = $_SESSION['username'];
                        $query = "SELECT score FROM Users WHERE user_id = $user";
                        foreach ($GLOBALS['pdo'] -> query($query) as $score)
                        {
                            if ($score['score'] >= 40)
                                echo "<li><a href=\"flagged-tasks.php\">Flagged Tasks</a></li>";
                        }
                    ?>
                    <li><a href="my-tasks.php">My Tasks</a></li>
                    <!-- -Home
                    -Create a task
                    -Claimed tasks
                    -Profile
                    -My tasks page
                    -FAQ -->
                </ul>
            </nav>

            <!-- Section -->
            <section>
                <header class="major">
                    <h2>Get in touch</h2>
                </header>
                <ul class="contact">
                    <li class="fa-envelope-o"><a href="#">information@untitled.tld</a></li>
                    <li class="fa-phone">(000) 000-0000</li>
                    <li class="fa-home">1234 Somewhere Road #8254<br />Nashville, TN 00000-0000</li>
                </ul>
            </section>

            <!-- Footer -->
            <footer id="footer">
                <p class="copyright">&copy; Untitled. All rights reserved.</p>
            </footer>

        </div>
    </div>
<?php endif ?>
