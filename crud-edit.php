<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    if(isset($_GET['idg'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_gallery WHERE id_gallery = '".$_GET['idg']."'");
        $title = 'Gallery';

        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else 
        $data = mysqli_fetch_object($datas);

    } else if(isset($_GET['idt'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_task WHERE id_task = '".$_GET['idt']."'");
        $title = 'Task';

        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else 
        $data = mysqli_fetch_object($datas);

    } else if(isset($_GET['idw'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_wishlist WHERE id_wishlist = '".$_GET['idw']."'");
        $title = 'Wishlist';

        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else 
        $data = mysqli_fetch_object($datas);

    } else if(isset($_GET['idf'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_financial WHERE id_financial = '".$_GET['idf']."'");
        $title = 'Financial Data';

        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else 
        $data = mysqli_fetch_object($datas);

    } else {
        header('location: crud.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit</title>
    <script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container">
            <h2 class="title">Update <?php echo $title ?></h2>
            <div class="box">
                <?php if(isset($_GET['idf'])) {?>
                <form method="post" autocomplete="off">
                    <input type="text" name="activity" placeholder="Activity" class="input-control" value="<?php echo $data->activity ?>" required>
                    <input type="text" name="amount" placeholder="Amount" class="input-control" value="<?php echo $data->amount ?>" required>
                    <select name="type" class="input-control" required>
                        <option value="">--Select Type--</option>
                        <option value="saving" <?php echo $data->type == 'saving' ? 'selected' : '' ?>>Saving</option>
                        <option value="expenses" <?php echo $data->type == 'expenses' ? 'selected' : '' ?>>Expenses</option>
                        <option value="income" <?php echo $data->type == 'income' ? 'selected' : '' ?>>Income</option>
                    </select>
                    <input type="date" name="date" value="<?php echo date("Y-m-d", strtotime($data->date)) ?>" class="input-control" required>
                    <input type="submit" name="updf" value="Add Activity" class="btn-1">
                </form>
                <?php 
                    if(isset($_POST['updf'])){
                        $act    = $_POST['activity'];
                        $amount = $_POST['amount'];
                        $type   = $_POST['type'];
                        $date   = $_POST['date'];

                        $update = mysqli_query($conn, "UPDATE tb_financial SET
                        activity = '".$act."', 
                        amount   = '".$amount."',
                        type     = '".$type."',
                        date     = '".$date."' WHERE id_financial = '".$data->id_financial."'");

                        if($update){
                            echo "<script>alert('Succesfully update data')</script>";
                            if(isset($_GET['from'])){
                                echo "<script>window.location='".$_GET['from']."?id=".$data->id_financial."'</script>";
                            } else {
                                echo "<script>window.location='crud.php'</script>";
                            }
                        } else {
                            echo "ERROR: ".mysqli_error($conn);
                        }
                    }
                } ?>
               <?php if(isset($_GET['idw'])){ ?>
                <form method="post" autocomplete="off" enctype="multipart/form-data">
                    <input maxlength="25" type="text" name="name" placeholder="Product Name" class="input-control" value="<?php echo $data->name?>">
                    <!-- <input type="text" name="price" placeholder="Unit Price" class="input-control" required> -->
                    <input type="number" name="price" min="1000" step="any"  placeholder="Unit Price" class="input-control" value="<?php echo $data->price?>">
                    <input type="number" name="quantity" min="1" placeholder="Quantity (optional)" class="input-control" value="<?php echo $data->quantity?>">
                    <input type="text" name="description" placeholder="Description (optional)" class="input-control" value="<?php echo $data->description?>">
                    <?php if($data->icon != 'blank') { ?>
                        <img src="WL_Icon/<?php echo $data->icon ?>" width="100px">
                        <p><?php echo $data->icon?></p>
                    <?php }?>
                    <input type="hidden" name="pic" value="<?php echo $data->icon?>">
                    <input type="file" name="image" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg">
                    <input type="submit" name="updw" value="Update" class="btn-1">
                </form>
                <?php 
                    if(isset($_POST['updw'])){
                        $name       = $_POST['name'];
                        $price      = $_POST['price'];
                        $quantity   = $_POST['quantity'];
                        $desc       = $_POST['description'];
                        $pic = $_POST['pic'];

                        //Images
                        $filename = $_FILES['image']['name'];
                        $tmp_name = $_FILES['image']['tmp_name'];

                        if($pic == 'blank' && $filename == ''){
                            $icon = 'blank';
                        } else if($filename != '') {
                            $type1 = explode('.', $filename);
                            $type2 = $type1[1];
                
                            $image = 'icon'.time().'.'.$type2;
                    
                            $allowed = array('jpg', 'jpeg', 'png', 'gif');
                    
                            if(!in_array($type2, $allowed)){
                                echo "<script>alert('File type image not allowed!')</script>";
                            } else {
                                if($pic != 'blank'){
                                    unlink('./WL_Icon/'.$pic);
                                }
                                move_uploaded_file($tmp_name, './WL_Icon/'.$image);
                                $icon = $image;
                            }
                        } else {
                            $icon = $pic;
                        }

                        $update = mysqli_query($conn, "UPDATE tb_wishlist SET
                            name = '".$name."',
                            price = '".$price."',
                            quantity = '".$quantity."',
                            description = '".$desc."',
                            icon = '".$icon."' 
                            WHERE id_wishlist = '".$data->id_wishlist."' ");

                        if($update){
                            echo "<script>alert('Succesfully update data')</script>";
                            if(isset($_GET['from'])){
                                echo "<script>window.location='".$_GET['from']."?id=".$data->id_wishlist."'</script>";
                            } else {
                                echo "<script>window.location='crud.php'</script>";
                            }
                        } else {
                            echo "ERROR: ".mysqli_error($conn);
                        }
                    }
                } ?>
                <?php if(isset($_GET['idg'])) {?>
                <form method="post" autocomplete="off" enctype="multipart/form-data">
                    <input maxlength="25" type="text" name="title" value="<?php echo $data->image_title?>" class="input-control" required>
                    <textarea id="descs" name="descscription" placeholder="Description" rows="1" class="input-control"><?php echo $data->image_desc?></textarea>
                    <!-- <input type="text" name="descs" value="<?php echo $data->image_desc?>" class="input-control" required><br> -->
                    <input type="hidden" name="pic" value="<?php echo $data->picture?>">
                    <img src="gallery/<?php echo $data->picture ?>" width="100px">
                    <p><?php echo $data->picture?></p>
                    <input type="file" name="image" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg">
                    <input type="submit" name="updg" value="Update" class="btn-1">
                </form>
                <?php
                    if(isset($_POST['updg'])){
                        $title = $_POST['title'];
                        $desc = $_POST['descscription'];
                        $pic = $_POST['pic'];

                        //Images
                        $filename = $_FILES['image']['name'];
                        $tmp_name = $_FILES['image']['tmp_name'];

                        //not changed
                        if($filename != ''){
                            $type1 = explode('.', $filename);
                            $type2 = $type1[1];

                            $image = 'image'.time().'.'.$type2;

                            $allowed = array('jpg', 'jpeg', 'png', 'gif');

                            if(!in_array($type2, $allowed)){
                                echo "<script>alert('File type image not allowed!')</script>";  
                            } else {
                                unlink('./gallery/'.$pic);
                                move_uploaded_file($tmp_name, './gallery/'.$image);
                                $picture = $image;
                            }
                        } else {
                            $picture = $pic;
                        }

                        $update = mysqli_query($conn, "UPDATE tb_gallery SET
                            image_title = '".$title."', 
                            image_desc = '".$desc."', 
                            picture = '".$picture."'
                            WHERE id_gallery = '".$data->id_gallery."'");

                        if($update){
                            echo "<script>alert('Succesfully update data')</script>";
                            if(isset($_GET['from'])){
                                echo "<script>window.location='".$_GET['from']."?pic=".$title."'</script>";
                            } else
                            echo "<script>window.location='crud.php'</script>";
                        } else {
                            echo $desc."<br>";
                            echo "ERROR: ".mysqli_error($conn);
                        }
                    }
                }
                ?>
                <?php if(isset($_GET['idt'])){?>
                <form method="post" autocomplete="off" enctype="multipart/form-data">
                    <input maxlength="25" type="text" name="task" value="<?php echo $data->task?>" class="input-control" required>
                    <input type="datetime-local" name="due_date" value="<?php echo date("Y-m-d\TH:i:s", strtotime($data->due_date)) ?>" class="input-control" required>
                    <select name="priority" class="input-control" required>
                        <option <?php echo ($data->priority === 'Low') ? "selected" : ''?> value="Low">Low</option>
                        <option <?php echo ($data->priority === 'Medium') ? "selected" : ''?> value="Medium">Medium</option>
                        <option <?php echo ($data->priority === 'Urgent') ? "selected" : ''?> value="Urgent">Urgent</option>
                    </select>
                    <textarea type="text" name="desc" class="input-control" required><?php echo $data->description?></textarea><br>
                    <select name="status" class="input-control" required>
                        <option <?php echo ($data->status == 1) ? "selected" : "" ?> value="1">Done</option>
                        <option <?php echo ($data->status == 0) ? "selected" : "" ?> value="0">Not</option>
                    </select>
                    <input type="submit" name="updt" value="Update" class="btn-1">
                </form>
                <?php 
                    if(isset($_POST['updt'])){
                        $title  = $_POST['task'];
                        $desc = $_POST['desc'];
                        $prity = $_POST['priority'];
                        $due = $_POST['due_date'];
                        $status = $_POST['status'];

                        $update = mysqli_query($conn, "UPDATE tb_task SET
                            task = '".$title."',
                            description = '".$desc."',
                            priority = '".$prity."',
                            due_date = '".$due."',
                            status = '".$status."'
                            WHERE id_task = '".$data->id_task."'");
                        
                        if($update){
                            echo "<script>alert('Succesfully update data')</script>";
                            if(isset($_GET['from'])){
                                echo "<script>window.location='".$_GET['from']."?id=".$data->id_task."'</script>";
                            } else
                            echo "<script>window.location='crud.php'</script>";
                        } else {
                            echo "ERROR: ".mysqli_error($conn);
                        }
                    }
                }?> 
            </div>
        </div>
    </div>
    <script> 
        CKEDITOR.replace( 'desc' );
        autosize(document.getElementById("descs"));
    </script> 
</body>
</html>