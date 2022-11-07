<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    if(isset($_GET['id'])){
        $check = mysqli_query($conn, "SELECT * FROM tb_task WHERE id_task = '".$_GET['id']."'");

        if(mysqli_num_rows($check) === 0){
            header('location: my-task.php');
        } else 
        $data = mysqli_fetch_object($check);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Task</title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container">
            <?php               
                $date = date("Y.m.d\\TH:i", strtotime($data->date));

                $today = new DateTime("Today"); // This object represents current date/time with time set to midnight

                $match_date = DateTime::createFromFormat( "Y.m.d\\TH:i", $date);
                $match_date->setTime( 0, 0, 0 ); // set time part to midnight, in order to prevent partial comparison

                $diff = $today->diff( $match_date );
                $diffDays = (integer)$diff->format( "%R%a" ); // Extract days count in interval

                $day;

                if($diffDays == 0){
                    $day = "Today";
                } else if($diffDays == -1){
                    $day = "Yesterday";
                } else if($diffDays == +1){
                    $day = "Tomorrow";
                } else {
                    $day = date('d/m/Y h:i A', strtotime($data->date));
                }
            ?>
			<div class="box" style="padding: 30px;">
				<a href="crud-delete.php?idt=<?php echo $data->id_task?>&from=home.php" onclick="return confirm('Are you sure want delete this data?')">
					<small class="btn btn-delete inner-right">
						Delete <span class="fas fa-trash">
					</small>
				</a>
				<a class="btn btn-edit inner-right" href="crud-edit.php?idt=<?php echo $data->id_task?>&from=task.php">
                    <small>
                        Edit <i class="fa fa-pencil" aria-hidden="true"></i>
                    </small>
				</a> 
				<a href="my-task.php?id=<?php echo $data->id_task?>&sts=<?php echo ($data->status == 0) ? '1' : '0'?>&from=task.php" >
					<?php if($data->status == 1){?>
                        <small class="btn btn-status-done inner-right">
                            <span class="fa fa-regular fa-check"></span> Done
                        </small>
                    <?php } else {?>
                        <small class="btn btn-status-not inner-right">
                            <span class="fa fa-times"></span> Not Done 
                        </small>
                    <?php } ?>
				</a>
                <h3><?php echo $data->task ?></h3>
				<small class="date"><?php echo "Created at ".$day?></small><br>
                <small>Priority: <b><?php echo $data->priority ?></b></small>
                <small class="inner-right">Due Date - <?php echo  date('d/m/Y h:i A', strtotime($data->due_date)) ?></small>
                <?php if(str_word_count($data->description) > 0) {?>
                <hr class="line"><br>
                <div class="box-desc">
                    <?php echo $data->description?>
                </div>
                <?php } ?>
			</div>
		</div>
    </div>
</body>
</html>