<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    if(isset($_GET['pic'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_gallery WHERE image_title = '".$_GET['pic']."'");

        if(mysqli_num_rows($data) === 0){
            header('location: gallery.php');
        } else
        $a = mysqli_fetch_object($data);
    } 
    
    $date = date("Y.m.d\\TH:i", strtotime($a->date));

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
        $day = date('d/m/Y H:i:s', strtotime($a->date));
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Picture</title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container">
            <div class="box">
                <div class="col-2">
                    <div class="picture-img">
                        <a onclick="return confirm('Open fullscreen image on new tab?')" href="gallery/<?php echo $a->picture ?>" target="_blank">
                            <img class="picture" src="gallery/<?php echo $a->picture ?>">
                        </a>
                    </div>
                </div>
                <div class="col-2">
                    <div class="heading-1">
                        <?php echo $a->image_title ?>
                        <a href="crud-delete.php?idg=<?php echo $a->id_gallery?>&from=gallery.php" 
                        onclick="return confirm('Are you sure want delete this data?')"
                        class="btn btn-delete inner-right">
                        <small>Delete <span class="fas fa-trash"></small>
                        </a>
                        <a href="crud-edit.php?idg=<?php echo $a->id_gallery?>&from=picture.php"
                        class="btn btn-edit inner-right">
                        <small>Edit <i class="fa fa-pencil" aria-hidden="true"></i></small>
                        </a> 
                    </div>
                    <div class="date"><?php echo "Created at ".$day?></div>
                    <p class="picture-desc"><?php echo $a->image_desc ?></p>
                </div>
			</div>
        </div>
    </div>
</body>
</html>