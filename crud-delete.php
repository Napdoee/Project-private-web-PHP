<?php
    include "database.php";

    if(isset($_GET['idw'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_wishlist WHERE id_wishlist = '".$_GET['idw']."'");
        $as = mysqli_fetch_object($datas);

        if($as->icon != 'blank'){
            unlink('./WL_Icon/'.$as->icon);
        }
        
        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else {
            $delete = mysqli_query($conn, "DELETE FROM tb_wishlist WHERE id_wishlist = '".$_GET['idw']."'");

            if($delete){
                if(isset($_GET['from'])){
                    echo "<script>window.location='".$_GET['from']."'</script>";
                } else
                header('location: crud.php');
            } else {
                echo mysqli_error($conn);
            }
        }
    }

    if(isset($_GET['idg'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_gallery WHERE id_gallery = '".$_GET['idg']."'");
        $as = mysqli_fetch_object($datas);

        unlink('./gallery/'.$as->picture);
        
        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else {
            $delete = mysqli_query($conn, "DELETE FROM tb_gallery WHERE id_gallery = '".$_GET['idg']."'");

            if($delete){
                if(isset($_GET['from'])){
                    echo "<script>window.location='".$_GET['from']."'</script>";
                } else
                header('location: crud.php');
            } else {
                echo mysqli_error($conn);
            }
        }
    }

    if(isset($_GET['idt'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_task WHERE id_task = '".$_GET['idt']."'");
        $as = mysqli_fetch_object($datas);
        
        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else {
            $delete = mysqli_query($conn, "DELETE FROM tb_task WHERE id_task = '".$_GET['idt']."'");

            if($delete){
                if(isset($_GET['from'])){
                    echo "<script>window.location='".$_GET['from']."'</script>";
                } else
                header('location: crud.php');
            } else {
                echo mysqli_error($conn);
            }
        }
    }

    if(isset($_GET['idf'])){
        $datas = mysqli_query($conn, "SELECT * FROM tb_financial WHERE id_financial = '".$_GET['idf']."'");
        $as = mysqli_fetch_object($datas);
        
        if(mysqli_num_rows($datas) === 0){
            header('location: crud.php');
        } else {
            $delete = mysqli_query($conn, "DELETE FROM tb_financial WHERE id_financial = '".$_GET['idf']."'");

            if($delete){
                if(isset($_GET['from'])){
                    echo "<script>window.location='".$_GET['from']."'</script>";
                } else
                header('location: crud.php');
            } else {
                echo mysqli_error($conn);
            }
        }
    }
?>