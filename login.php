<?php
    session_start();
    include "partials/links.php";
    include "partials/theme.php";
    include "database.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login to account</title>
</head>
<body class="<?php echo $theme; ?>">
    <div class="container-login">
        <div class="box-login">
            <h2>Login</h2>
            <form method="post" autocomplete="off">
                <input type="text" name="user" placeholder="Username" class="input-control" required>
                <input type="password" name="pass" placeholder="Password" class="input-control" required>
                <input type="submit" value="Login to account" class="btn-1" name="login-form">
            </form>
            <?php
            if(isset($_POST['login-form'])){
                $user = mysqli_real_escape_string($conn, $_POST['user']);
                $pass = mysqli_real_escape_string($conn, $_POST['pass']);

                $verf = mysqli_query($conn, "SELECT * FROM tb_admin 
                WHERE username = '".$user."' AND password = '".MD5($pass)."'");

                if(mysqli_num_rows($verf) > 0){
                    $data = mysqli_fetch_object($verf);
                    $_SESSION['status_login'] = true;
                    $_SESSION['id_admin'] = $data->id_admin;
                    $_SESSION['a_name'] = $data->nickname;

                    echo "[".$_SESSION['id_admin']."] ".$_SESSION['a_name'];

                    echo "<script>window.location='home.php'</script>";
                } else {
                    echo "<script>alert('Wrong Username or Password')</script>";
                }

            }
        ?>
        </div>
    </div>
</body>
</html>