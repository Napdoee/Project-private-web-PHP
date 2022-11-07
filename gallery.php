<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

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
<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Gallery</title>
    <script src="https://craig.global.ssl.fastly.net/js/mousetrap/mousetrap.min.js?a4098"></script>
    <script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
    <script>
        Mousetrap.bind(['shift+='], function() {
            return window.location = 'add-gallery.php';
        });
    </script>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
    <div class="container">
        <a class="btn-1 inner-right" id="ModalBtn"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Picture</a>
		<div class="title">Gallery</div>
			<div class="box">
                <div class="row">
                    <div class="gallery">
                    <?php
                        $img = mysqli_query($conn, "SELECT * FROM tb_gallery");

                        if(mysqli_num_rows($img) > 0){
                            while($a = mysqli_fetch_array($img)){
                    ?>
                    <div class="col-5 gall">
                    <img id="img-<?php echo $a['id_gallery']?>" alt="<?php echo $a['image_title']?>" src="gallery/<?php echo $a['picture']?>"
                         onclick="javascript:trigger('img-<?php echo $a['id_gallery']?>')">
                        <div class="img-title">
                            <p><?php echo $a['image_title']?></p>
                        </div>
                        </div>
                    <?php }} else {?>
                        <p align="center">None Picture Found</p>
                    <?php } ?>
                </div>
                </div>
			</div>
	    </div>
        <div class="container">
            <div class="modal" id="myModal">
                <div class="modal-box">
                    <div class="container">
                        <div class="title">New Picture ! <span class="close">&times;</span></div>
                        <br>
                        <form method="post" autocomplete="off" enctype="multipart/form-data">
                            <input maxlength="25" type="text" name="title" class="input-control" placeholder="Title" required>
                            <textarea id="desc" name="desc" rows="1" class="input-control" placeholder="Description"></textarea>
                            <input type="file" name="img" class="input-control" accept="image/png, image/jpg, image/gif, image/jpeg" required>
                            <input type="submit" name="gallery" value="Add Picture" class="btn-1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="styles/modal.js"></script>
	</div>

    <!-- Javascript for modal-picture gallery -->
    <div class="container">
        <div class="modal" id="pic-modal">
            <img class="modal-content" id="img01">
            <a id="caption"></a>
        </div>
    </div>
    <script> autosize(document.getElementById("desc")); </script> 
    <script>
        var picture = document.getElementById("pic-modal");

        var modalImg = document.getElementById("img01");
        var captionText = document.getElementById("caption");

        function trigger(var1)
        {
            var link = "picture.php?pic="+document.getElementById(var1).alt;

            picture.style.display = "block";
            modalImg.src = document.getElementById(var1).src;
            captionText.innerHTML = document.getElementById(var1).alt;
            captionText.href = link;
        }

        window.onclick = function(event) {
            if (event.target == picture) {
                picture.style.display = "none";
            }
        }

    </script>
    <!-- Javascript for modal-picture gallery -->

</body>
</html>