<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    if(isset($_POST['wish'])){

        $name       = $_POST['name'];
        $price      = $_POST['price'];
        $quantity   = $_POST['quantity'];
        $desc       = $_POST['description'];

        //Images
        $filename = $_FILES['img']['name'];
        $tmp_name = $_FILES['img']['tmp_name'];

        if($filename == ''){
            $image = 'blank';
        } else {
            $type1 = explode('.', $filename);
            $type2 = $type1[1];

            $image = 'icon'.time().'.'.$type2;
    
            $allowed = array('jpg', 'jpeg', 'png', 'gif');
    
            if(!in_array($type2, $allowed)){
                echo "<script>alert('File type image not allowed!')</script>";
            } else {
                move_uploaded_file($tmp_name, './WL_Icon/'.$image);
            }
        }

            $insert = mysqli_query($conn, "INSERT INTO tb_wishlist VALUES(
                null, 
                '".$image."',
                '".$name."',
                null,
                '".$price."',
                '".$quantity."',
                '".$desc."')");

            if($insert){
                echo "<script>alert('Wishlist added succesfully')</script>";
                echo "<script>window.location='my-wish.php'</script>";
            } else {
                echo "ERROR: ".mysqli_error($conn);
            }
    }    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wish List</title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container-70">
            <a class="btn-1 inner-right" id="ModalBtn"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Wishlist</a>
            <div class="title">My Wishlist</div>
            <div class="box">
                <table class="table-2" border="0">
                    <thead>
                        <tr>
                            <th style="text-align: left;">Product Item</th>
                            <th style="text-align: left;">Unit Price</th>
                            <th style="text-align: left;">Description</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $halaman = 5;
                            $page = isset($_GET["page"]) ? (int)$_GET['page'] : 1;
                            $start = ($page>1) ? ($page * $halaman) - $halaman : 0;

                            $result = mysqli_query($conn, "SELECT * FROM tb_wishlist");
                            $total = mysqli_num_rows($result);
                            $pages = ceil($total/$halaman);

                            $previous = $page - 1; 
                            $next = $page + 1;

                            $wl = mysqli_query($conn, "SELECT * FROM tb_wishlist ORDER BY id_wishlist ASC LIMIT $start, $halaman");

                            if(mysqli_num_rows($wl) > 0){
                                while($a = mysqli_fetch_array($wl)){
                        ?>
                        <tr>
                            <td width="30%" onclick="window.location='wish.php?id=<?php echo $a['id_wishlist'] ?>'" 
                                style="cursor: pointer;">
                                <div class="inner-left img-sml">
                                    <?php if($a['icon'] != 'blank') { ?>
                                        <img src="WL_Icon/<?php echo $a['icon'] ?>">
                                    <?php } else { ?>
                                        <img src="img/blankImg.png">
                                    <?php }?>
                                </div>
                                <div class="inner-left">
                                    <p><?php echo $a['name']?></p>
                                    <div class="date"><?php echo date('d/m/Y', strtotime($a['date']))?></div>
                                </div>
                            </td>
                            <td><?php echo "Rp. ".number_format($a['price'])?></td>
                            <td width="20%"><?php echo $a['description']?></td>
                            <td align="center"><?php echo $a['quantity']?></td>
                            <td width="13%" class="center">
                                <a href="crud-delete.php?idw=<?php echo $a['id_wishlist']?>&from=my-wish.php" class="btn btn-delete"
                                onclick="return confirm('Are you sure want delete this data (<?php echo $a['name'] ?>) ?')">
                                <i class="fas fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php  } } else { ?>
                            <tr>
                                <td colspan="5" align="center">
                                    None item
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <p class="inner-left">Total: <?php echo $total ?> entries</p>
                    <a <?php echo ($page <= 1) ? "class='disabled'" : "href='my-wish.php?page=$previous'";?>>&laquo;</a>
					<?php 
                        if($page >= $pages){
                            $previous = $previous-1;
                            $next = $page;
                        } 
                        if ($page <= 1){
                            $previous = 0;
                        }
                        for ($i=$previous+1; $i<=$next; $i++){ ?>
					    <a class="<?php echo ($i == $page) ? " active" : ''?>" href="my-wish.php?page=<?php echo $i?>"><?php echo $i; ?></a>
					<?php } ?>
                    <a <?php echo ($page >= $pages) ? "class='disabled'" : "href='my-wish.php?page=$next'"?>>&raquo;</a>
				</div>
            </div>
        </div>
        <div class="container">
            <div class="modal" id="myModal">
                <div class="modal-box">
                    <div class="container">
                        <div class="title">New Wishlist<span class="close">&times;</span></div>
                        <br>
                        <form method="POST" autocomplete="off" enctype="multipart/form-data">
                            <input type="file" name="img" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg">
                            <input maxlength="25" type="text" name="name" placeholder="Product Name" class="input-control" required>
                            <!-- <input type="text" name="price" placeholder="Unit Price" class="input-control" required> -->
                            <input type="number" name="price" min="1000" step="any"  placeholder="Unit Price" class="input-control" required>
                            <input type="number" name="quantity" min="1" placeholder="Quantity (optional)" class="input-control" value="1">
                            <input type="text" name="description" placeholder="Description (optional)" class="input-control">
                            <input type="submit" name="wish" value="Add Wishlist" class="btn-1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="styles/modal.js"></script>
    </div>
</body>
</html>