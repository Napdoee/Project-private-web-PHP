<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    if(isset($_GET['id'])){
        $data = mysqli_query($conn, "SELECT * FROM tb_wishlist WHERE id_wishlist='".$_GET['id']."'");

        if(mysqli_num_rows($data)){
            $w = mysqli_fetch_object($data);
        } else {            
            header('location: my-wish.php');
        }
    }else{
        header('location: my-wish.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wishlist - <?php echo $w->name?></title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container-50">
            <div class="box">
                <div class="heading-1">
                <?php echo $w->name." (".$w->quantity.")"?>
				<a href="crud-delete.php?idw=<?php echo $w->id_wishlist?>&from=my-wish.php" 
                onclick="return confirm('Are you sure want delete this data?')">
                <small class="btn btn-delete inner-right">Delete <span class="fas fa-trash"></small>
				</a>
				<a class="btn btn-edit inner-right" href="crud-edit.php?idw=<?php echo $w->id_wishlist?>&from=wish.php">
                <small>Edit <i class="fa fa-pencil" aria-hidden="true"></i></small>
				</a> 
                </div>
                <div class="date"><?php echo $w->date?></div>
                <div class="inner-right" style="padding: 0px 10px; font-weight: bold;">Rp. <?php echo number_format($w->price)?></div>
                <div style="padding: 5px 0px; margin: 0px; font-size: 14px"><?php echo $w->description?></div>
                <?php if($w->icon != 'blank') { ?>
                <a onclick="return confirm('Open fullscreen image on new tab?')" href="WL_Icon/<?php echo $w->icon ?>">
                    <div class="picture-img" style="max-height: 467px;">
                        <img class="picture" src="WL_Icon/<?php echo $w->icon?>">
                    </div>
                </a>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>