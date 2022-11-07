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
    <title>Crud Settings</title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container">
            <div class="col-2">
                <h1 class="title">Gallery</h1>
                <div class="box">
                    <table border="1" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>ID</th>
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $gallery = mysqli_query($conn, "SELECT * FROM tb_gallery");

                                if(mysqli_num_rows($gallery) > 0){
                                    $no = 1;
                                    while($g = mysqli_fetch_array($gallery)){ 
                            ?>
                            <tr>
                                <td width="30px" align="center"><?php echo $no++ ?></td>
                                <td><?php echo $g['image_title']?></td>
                                <td align="center"><?php echo $g['id_gallery']?></td>
                                <td width="40px" align="center"><a href="crud-edit.php?idg=<?php echo $g['id_gallery']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                                <td width="40px" align="center"><a href="crud-delete.php?idg=<?php echo $g['id_gallery']?>" 
                                onclick="return confirm('Are you sure want delete (<?php echo $g['image_title']?>)?')"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="5" align="center">404 Data Not Found</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>                
            </div>
            <div class="col-2">
                <div class="title">Wishlist</div>
                <div class="box">
                    <table border="1" class="table">
                        <thead>
                            <th>No</th>
                            <th>Title</th>
                            <th>ID</th>
                            <th colspan="2">Action</th>
                        </thead>
                        <tbody>
                            <?php
                                $wishlist = mysqli_query($conn, "SELECT * FROM tb_wishlist");
                                if(mysqli_num_rows($wishlist) > 0){
                                    $no=1;
                                    while($wl = mysqli_fetch_array($wishlist)){
                            ?>
                            <tr>
                                <td width="30px" align="center"><?php echo $no++?></td>
                                <td><?php echo $wl['name']?></td>
                                <td align="center"><?php echo $wl['id_wishlist']?></td>
                                <td width="40px" align="center"><a href="crud-edit.php?idw=<?php echo $wl['id_wishlist']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                                <td width="40px" align="center"><a href="crud-delete.php?idw=<?php echo $wl['id_wishlist']?>"
                                onclick="return confirm('Are you sure want delete this data (<?php echo $wl['name'] ?>) ?')"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                            </tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
        <div class="container">
            <h1 class="title">Task List</h1>
            <div class="box  tb-scroll">
                <table border="1" class="table">
                    <thead>
                        <th>No</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>ID</th>
                        <th colspan="2">Action</th>
                    </thead>
                    <tbody>
                        <?php 
                            $task = mysqli_query($conn, "SELECT * FROM tb_task");
                            if(mysqli_num_rows($task) > 0){
                                $no=1;
                                while($todo = mysqli_fetch_array($task)){
                        ?>
                        <tr>
                            <td width="30px" align="center"><?php echo $no++?></td>
                            <td><?php echo $todo['task']?></td>
                            <td width="60px" align="center"><?php echo $todo['status'] ? '<span class="fa fa-regular fa-check">' : '<span class="fa fa-times">' ?></td>
                            <td><?php echo $todo['date']?></td>
                            <td align="center"><?php echo $todo['id_task']?></td>
                            <td width="40px" align="center"><a href="crud-edit.php?idt=<?php echo $todo['id_task']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>
                            <td width="40px" align="center"><a href="crud-delete.php?idt=<?php echo $todo['id_task']?>"
                            onclick="return confirm('Are you sure want delete (ID - <?php echo $todo['id_task']?>)?')"><i class="fas fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php }} else {?>
                            <tr>
                                <td colspan="6">No Data Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>