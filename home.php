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
    <title>Hello there !</title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container">
            <a href="my-task.php" class="btn-1 inner-right">More...</a>
            <div class="title">Task List</div>
            <div class="box">
					<?php
						$task = mysqli_query($conn, "SELECT * FROM tb_task ORDER BY id_task DESC LIMIT 10");
						if(mysqli_num_rows($task) > 0){
							while($b = mysqli_fetch_array($task)){
					?>
					<div class="col-5">
						<a href="task.php?id=<?php echo $b['id_task']?>">
							<div class="card-task">
								<div class="card-task-content">
									<?php echo $b['status'] ? '<span class="fa fa-regular fa-check">' : 
															  '<span class="fa fa-times">' ?>	</span>
									<h4><?php echo $b['task']?></h4>
								</div>
							</div>
						</a>
					</div>
					<?php	}} else { ?>
						<p align="center">Not Data Found</p>
					<?php } ?>
				</div>
        </div>
        <div class="container">
			<a href="gallery.php" class="btn-1 inner-right">More...</a>
            <div class="title">Gallery</div>
            <div class="box">
					<?php
						$sql = mysqli_query($conn, "SELECT * FROM tb_gallery ORDER BY id_gallery DESC LIMIT 4");
						if(mysqli_num_rows($sql) > 0){
							while($a = mysqli_fetch_array($sql)){
					?>
					<div class="col-4">
						<div onclick="window.location='picture.php?pic=<?php echo $a['image_title'] ?>'" class="card">
							<div class="card-image">
								<img src="gallery/<?php echo $a['picture'] ?>" alt="Pemandangan">
							</div>
							<div class="card-stacked">
								<div class="card-content">	
									<h3><?php echo $a['image_title'] ?></h3>
									<!-- <p><?php echo $a['image_desc'] ?></p> -->
									<div class="card-link">
										<button onclick="window.location='picture.php?pic=<?php echo $a['image_title'] ?>'">Read More</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php }} else {?>
						<p align="center">Not Picture Found</p>
					<?php } ?>
				</div>
        </div>
    </div>
</body>
</html>