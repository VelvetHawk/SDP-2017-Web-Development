<?php
include_once "res/utils/Functions.php";
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
    <script src="res/js/profile-tags.js"></script>
</head>
<body onload="addOnClick()">

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

                <header class="major">
                    <h2>Create Task</h2>
                </header>
                <?php if(!(isset($_SESSION['username']) || isCookieValid($GLOBALS['pdo']))): ?>
                    <?php redirectTo('index'); ?>
                    <!--<p class="lead">You are currently not signed in<br><a href="login.php">Login</a><br>
                        Not yet a member? <a href="signup.php">Sign up here</a><br>
                    </p>-->
                <?php else: ?>
                    <?php include_once "res/partials/parseTaskCreate.php" ?>
                <div>
                    <?php if(isset($result)) echo $result; ?>
                    <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
                </div>

                <form method="post" action="" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="taskTitle">Task Title</label>
                        <input type="text" name="taskTitle" class="form-control" id="taskTitle" value="">
                    </div>
                    <div class="form-group">
                        <label for="taskType">Task Type</label>
                        <input type="text" name="taskType" class="form-control" id="taskType" value="">
                    </div>

                    <div class="form-group">
                        <label for="taskDescription">Task Description</label>
                        <textarea class="form-control" name="taskDescription" id="taskDescription" placeholder="Enter description" rows="6"></textarea>
                        <!--<input type="text" name="taskDescription" class="form-control" id="taskDescription" value="">-->
                    </div>
                    <!-- date -->
                    <div class="form-group">
                        <label for="reviewDeadline">Review Deadline</label>
                        <input class="form-control" name="review_deadline" min="<?=date('Y-m-d')?>" type="date" id="reviewDeadline">
                    </div>
                    <div class="form-group">
                        <label for="claimDeadline">Claim Deadline</label>
                        <input class="form-control" name="claim_deadline" min="<?=date('Y-m-d')?>" type="date" id="claimDeadline">
                    </div>
                    <div class="form-group">
                        <label for="entry-area">Your Tags - 4 maximum (Press Enter to add new tag fields)</label>
                        <input type="hidden" name="taskTags" id="tags" value="0">
                        <div id="entry-area" contenteditable="false" class="entry-area"></div>
                    </div>
                    <div class="form-group">
                        <label for="taskPageCount">Task Page Count</label>
                        <input type="text" name="taskPageCount" class="form-control" id="taskPageCount" value="">
                    </div>
                    <div class="form-group">
                        <label for="taskWordCount">Task Word Count</label>
                        <input type="text" name="taskWordCount" class="form-control" id="taskWordCount" value="">
                    </div>
                    <!-- radio -->
                    <div class="radiobutton">
                        <div style="float: left; width: 15%;" class="4u 12u$(small)">
                            <input type="radio" id="word" name="format" checked <?php if (isset($format) && $format==".docx") echo "checked";?>
                                   value=".docx">
                            <label for="word">Word Doc</label>
                        </div>
                        <div style="float: left; width: 15%;" class="4u 12u$(small)">
                            <input type="radio" id="pdf" name="format" <?php if (isset($format) && $format==".pdf") echo "checked";?>
                                   value=".pdf">
                            <label for="pdf">PDF</label>
                        </div>
                        <div style="float: left; width: 15%;" class="4u$ 12u$(small)">
                            <input type="radio" id="text" name="format" <?php if (isset($format) && $format==".txt") echo "checked";?>
                                   value=".txt">
                            <label for="text">Text File</label>
                        </div>
                    </div></br></br>
                    <input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">

                    <div class="12u$">
                        <ul class="actions button-float-right">
                            <li><button name="createTaskButton" type="submit" value="Submit" class="special">Create Task</button></li>

                        </ul>
                    </div>
                    <p><a class="child_div_1" href="home.php">Back</a></p>
                </form>
                <?php endif ?>

            </section>

        </div>
    </div>

    <!-- Sidebar -->
    <?php
    include_once "res/utils/Sidebar.php";
    ?>
</div>

<!-- Scripts -->
<?php
include_once "res/partials/script-calls.php";
?>
<script>
    document.getElementById("entry-area").setAttribute("onmouseover", "mouseOn()");
    document.getElementById("entry-area").setAttribute("onmouseout", "mouseOff()");
    document.getElementById("updateProfileButton").setAttribute("onClick", "addTagsToSubmit()");
</script>
</body>
</html>