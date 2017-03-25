<?php
    $page_title = "Task Creation Page";
    include_once 'partials/headers.php';
    include_once 'partials/parseTaskCreate.php';
    ?>

<div class="container">
	<section class="col col-lg-7">
		<h2>Create Task </h2> <br>
		<div>
            <?php if(isset($result)) echo $result; ?>
            <?php if(!empty($form_errors)) echo show_errors($form_errors); ?>
        </div>

        <!--
        <?php if(!isset($_SESSION['username'])): ?>
            <p class="lead">You are not authorized to view this page <a href="login.php">Login</a>
            Not yet a member? <a href="signup.php">Signup</a></p>

        -->
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
                        <input type="text" name="taskDescription" class="form-control" id="taskDescription" value="">
                    </div>

                    <div class="form-group">
                        <label for="taskTags">Task Tags (Seperate with commas)</label>
                        <input type="text" name="taskTags" class="form-control" id="taskTags" value="">
                    </div>

                    <div class="form-group">
                        <label for="taskPageCount">Task Page Count</label>
                        <input type="text" name="taskPageCount" class="form-control" id="taskPageCount" value="">
                    </div>

                    <div class="form-group">
                        <label for="taskWordCount">Task Word Count</label>
                        <input type="text" name="taskWordCount" class="form-control" id="taskWordCount" value="">
                    </div>

                    <div class="file-format">
                    	<input type="radio" name="format"
						<?php if (isset($format) && $format==".docx") echo "checked";?>
						value=".docx">Word Doc
						<input type="radio" name="format"
						<?php if (isset($format) && $format==".pdf") echo "checked";?>
						value=".pdf">PDF
						<input type="radio" name="format"
						<?php if (isset($format) && $format==".txt") echo "checked";?>
						value=".txt">Text File
					</div>

					<input type="hidden" name="hidden_id" value="<?php if(isset($id)) echo $id; ?>">
                    <button type="submit" name="createTaskButton" class="btn btn-primary pull-right">Create Task</button>
            </form>
        <?php endif ?>
    </section>
    <p><a href="index.php">Back</a></p>
</div>

<?php include_once 'partials/footers.php'; ?>