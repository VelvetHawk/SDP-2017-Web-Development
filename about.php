<?php
$page_title = "About";
include_once "res/utils/Functions.php";
include_once 'res/partials/parseLogin.php';
?>

<!DOCTYPE HTML>
<!--
    Editorial by HTML5 UP
    html5up.net | @ajlkn
    Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html lang="en">
<head>
    <?php
    include_once "res/partials/head.php";
    ?>
    <title>Proofreadr - For all your grammar needs</title>
    <meta name="description" content="This should contain a description about this particular page">
</head>
<body>

<!-- Wrapper -->
<div id="wrapper">

    <!-- Main -->
    <div id="main">
        <div class="inner">

            <!-- Header -->
            <header id="header">
                <?php
                include_once "res/partials/Header.php";
                ?>
            </header>

            <!-- Section -->
            <section>
                <div class="container flag">
                    <header class="major">
                        <h2>About</h2>
                    </header>
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        Select image to upload:
                        <input type="file" name="fileToUpload" id="fileToUpload">
                        <input type="submit" value="Upload Image" name="submit">
                    </form>
                    <!--



                    WHATEVER GOES HERE


                    -->
                </div>
            </section>

        </div>
    </div>
</div>

<!-- Scripts -->
<?php
include_once "res/partials/script-calls.php";
?>
</body>
</html>