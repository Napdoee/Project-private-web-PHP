<?php
    if($_SESSION['status_login'] != true){
        echo "<script>window.location='login.php'</script>";
    }
?>