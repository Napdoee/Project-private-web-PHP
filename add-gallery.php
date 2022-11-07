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
    <title>Add Gallery</title>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container">
            <h2 class="title">New Picture !</h2>
            <div class="box">
                    <form method="post" autocomplete="off" enctype="multipart/form-data">
                        <input maxlength="25" type="text" name="title" class="input-control" placeholder="Title" required>
                        <textarea id="desc" name="desc" rows="1" class="input-control" placeholder="Description"></textarea>
                        <input type="file" name="img" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
                        <input type="submit" name="gallery" value="Add Picture" class="btn-1">
                    </form>
                    <?php
                        if(isset($_POST['gallery'])){
                            $title = $_POST['title'];
                            $desc = $_POST['desc'];
                            
                            //Images
                            $filename = $_FILES['img']['name'];
                            $tmp_name = $_FILES['img']['tmp_name'];

                            $type1 = explode('.', $filename);
                            $type2 = $type1[1];

                            $image = 'image'.time().'.'.$type2;

                            $allowed = array('jpg', 'jpeg', 'png', 'gif');
                            

                            if(!in_array($type2, $allowed)){
                                echo "<script>alert('File type image not allowed!')</script>";
                            } else {
                                move_uploaded_file($tmp_name, './gallery/'.$image);

                                $insert = mysqli_query($conn, "INSERT INTO tb_gallery VALUES(
                                    null, 
                                    '".$title."',
                                    '".$desc."',
                                    '".$image."',
                                    null
                                    )");

                                if($insert){
                                    echo "<script>alert('Gallery added succesfully')</script>";
                                    echo "<script>window.location='gallery.php'</script>";
                                } else {
                                    echo "ERROR: ".mysqli_error($conn);
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <script> 
        autosize(document.getElementById("desc"));
    </script> 
</body>
</html>