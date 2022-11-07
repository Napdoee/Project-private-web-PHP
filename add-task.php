<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Task</title>
    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container">
            <h2 class="title">New Task !</h2>
            <div class="box">					
                <form method="POST" autocomplete="off">
                    <input maxlength="25" type="text" name="text" placeholder="Title Task" class="input-control" required>
                    <textarea type="text" name="desc" placeholder="Description" class="input-control"></textarea><br>
                    <input type="submit" name="task" value="Add Task" class="btn-1">
                </form>
                <?php
                    if(isset($_POST['task'])){
                        $insert = mysqli_query($conn, "INSERT INTO `tb_task` (`task`, `description`) 
                        VALUES ('".$_POST['text']."', '".$_POST['desc']."')");

                        if($insert){
                            echo "<script>window.location='my-task.php'</script>";
                        } else {
                            echo "Error: ".mysqli_error($conn);
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <script> CKEDITOR.replace( 'desc' );</script> 
</body>
</html>