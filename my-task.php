<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    if(isset($_GET['id'])){
        $update = mysqli_query($conn, "UPDATE tb_task SET status = '".$_GET['sts']."' WHERE id_task = '".$_GET['id']."'");

        if($update){
            if(isset($_GET['from'])){
                echo "<script>window.location='task.php?id=".$_GET['id']."'</script>";                
            } else
            echo "<script>window.location='my-task.php'</script>";
        } else {
            echo mysqli_error($conn);
        }
    }
	
	if(isset($_POST['task'])){
		$insert = mysqli_query($conn, "INSERT INTO `tb_task` (`task`, `description`, `due_date`, `priority`) 
		VALUES ('".$_POST['text']."', '".$_POST['desc']."', '".$_POST['due_date']."', '".$_POST['priority']."')");

		if($insert){
			echo "<script>window.location='my-task.php'</script>";
		} else {
			echo "Error: ".mysqli_error($conn);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>My Task</title>
	<script src="https://craig.global.ssl.fastly.net/js/mousetrap/mousetrap.min.js?a4098"></script>
	<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <script>
        Mousetrap.bind(['shift+='], function() {
            return window.location = 'add-task.php';
        });
    </script>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
    <div class="container-50">
		<a class="btn-1 inner-right" id="ModalBtn"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Task</a>
		<div class="title">Task List</div>
			<div class="box">
				<table border="0" width="100%" style="border-collapse: collapse;">
				<?php

					$halaman = 11;
					$page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
					$start = ($page>1) ? ($page * $halaman) - $halaman : 0;

					$result = mysqli_query($conn, "SELECT * FROM tb_task");
					$total = mysqli_num_rows($result);
					$pages = ceil($total/$halaman);

					$previous = $page - 1; 
					$next = $page + 1;

					$task = mysqli_query($conn, "SELECT * FROM tb_task ORDER BY id_task DESC LIMIT $start, $halaman");

					if(mysqli_num_rows($task) > 0){
					    while($a = mysqli_fetch_array($task)){
							
						$date = date("Y.m.d\\TH:i", strtotime($a['due_date']));
		
						$today = new DateTime("Today"); // This object represents current date/time with time set to midnight
		
						$match_date = DateTime::createFromFormat( "Y.m.d\\TH:i", $date);
						$match_date->setTime( 0, 0, 0 ); // set time part to midnight, in order to prevent partial comparison
		
						$diff = $today->diff( $match_date );
						$diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval
		
						$day;
		
						if($diffDays == 0){
							$day = "Today | ";
						} else if($diffDays <= -1){
							$day = "Too Late | ".date('d/m/Y', strtotime($a['due_date']));
						} else if($diffDays == +1){
							$day = "Tomorrow";
						} else {
							$day = date('d/m/Y', strtotime($a['due_date']));
						}
				?>
				<tr>
					<td width="50px">
						<a href="my-task.php?id=<?php echo $a['id_task']?>&sts=<?php echo ($a['status'] == 0) ? '1' : '0';?>" 
						   <?php echo ($a['status'] == 1) ? 'class="btn  btn-status-done task"' : 'class="btn btn-status-done"'?>>
                            <span class="fa fa-regular fa-check"></span>
                        </a>
					</td>
					<td >
						<h4 <?php echo ($a['status'] == 1) ? 'class="task"' : ''?> >
							<a href="task.php?id=<?php echo $a['id_task']?>"><?php echo $a['task']?> </a>
							<?php if(strlen($a['description']) > 0 && $a['status'] == 0) {?>
								<i title="Has Noted" style="color: #5f9fff;" class="fa fa-flag" aria-hidden="true"></i>
							<?php } ?>
						</h4>
						<?php if($a['status'] == 0){?>
							<small class="date">Due Date - <?php echo $day." ".date('h:i A', strtotime($a['due_date'])); ?></small>
						<?php } ?>
					</td>
					<td class="action">
						<small>
						<?php 
							if($a['status'] == 0 && $a['priority'] == 'Low') {
								$priority = '#96e73e';
							} else if($a['status'] == 0 && $a['priority'] == 'Medium') {
								$priority = '#ffe000';
							} else if($a['status'] == 0 && $a['priority'] == 'Urgent') {
								$priority = '#ff2d2d';
							}
						?>
						<?php if($a['status'] == 0) {?>
							<i style="color:<?php echo $priority ?>; font-size: 20px;" class="fa fa-bookmark" aria-hidden="true"></i>
						<?php }?>
						</small>
						<a href="crud-delete.php?idt=<?php echo $a['id_task']?>&from=my-task.php" 
						   class="btn btn-delete"><span class="fa fa-times"></span></a>
					</td>
				</tr>	
				<?php } } else { ?>
					<p align="center">None Schulde</p>
				<?php }?>
				</table>
				<!-- <hr class="line"> -->
                <div class="pagination">
                    <p class="inner-left">Total: <?php echo $total ?> entries</p>
                    <a <?php echo ($page <= 1) ? "class='disabled'" : "href='my-task.php?page=$previous'";?>>&laquo;</a>
					<?php 
                        if($page >= $pages){
                            $previous = $previous-1;
                            $next = $page;
                        } 
                        if ($page <= 1){
                            $previous = 0;
                        }
                        for ($i=$previous+1; $i<=$next; $i++){ ?>
					    <a class="<?php echo ($i == $page) ? " active" : ''?>" href="my-task.php?page=<?php echo $i?>"><?php echo $i; ?></a>
					<?php } ?>
                    <a <?php echo ($page >= $pages) ? "class='disabled'" : "href='my-task.php?page=$next'"?>>&raquo;</a>
				</div>
			</div>
		</div>
		<div class="container">
            <div class="modal" id="myModal">
                <div class="modal-box">
                    <div class="container">
                        <div class="title">Add New <span class="close">&times;</span></div>
                        <br>
                        <form method="POST" autocomplete="off">
                            <input maxlength="25" type="text" name="text" placeholder="Title Task" class="input-control" required>
							<input type="datetime-local" name="due_date" placeholder="Due Date" class="input-control" required>
							<select name="priority" class="input-control" required>
								<option value="">--Select--</option>
								<option value="Low">Low</option>
								<option value="Medium">Medium</option>
								<option value="Urgent">Urgent</option>
							</select>
                            <textarea type="text" name="desc" placeholder="Description" class="input-control"></textarea><br>
                            <input type="submit" name="task" value="Add Task" class="btn-1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
		<script> CKEDITOR.replace( 'desc' );</script> 
		<script src="styles/modal.js"></script>
    </div>
</body>
</html>