<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    $admin = mysqli_query($conn, "SELECT * FROM tb_admin WHERE id_admin='".$_SESSION['id_admin']."'");
    $a = mysqli_fetch_array($admin);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account Profile</title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container-50">
            <div class="title">Profile Data</div>
            <div class="box">
                <h2 align='center' style="font-size: 60px; margin: 10px 0px"><i class="fa fa-user" aria-hidden="true"></i></h2>
                <table class="table" border="1">
                    <tr>
                        <th>User ID</th>
                        <td align="center"><?php echo $a['id_admin'] ?></td>
                    </tr>
                    <tr>
                        <th>Nickname</th>
                        <td align="center"><?php echo $a['nickname'] ?></td>
                    </tr>
                    <tr>
                        <th>Username</th>
                        <td align="center"><?php echo $a['username'] ?></td>
                    </tr>
                </table>
            </div>
            <div class="box">
                <fieldset>
                    <legend>Update Profile</legend>
                    <form method="POST" autocomplete="off">
                        <input type="text" name="nick" class="input-control" placeholder="Nickname" 
                        value="<?php echo $a['nickname']?>">
                        <input type="text" name="user" class="input-control" placeholder="Username"
                        value="<?php echo $a['username']?>">
                        <input type="submit" name="adm" value="Update" class="btn-1"></input>
                    </form>
                </fieldset>
                <fieldset>
                    <legend>Change Password</legend>
                    <form method="POST" autocomplete="off">
                        <input type="password" name="pass1" class="input-control" placeholder="New Password">
                        <input type="password" name="pass2" class="input-control" placeholder="Confirm New Password">
                        <input type="submit" name="changepass" value="Change" class="btn-1"></input>
                    </form>
                </fieldset>
                <?php
                    if(isset($_POST['adm'])) {
                        $upd = mysqli_query($conn, "UPDATE tb_admin SET 
                        nickname = '".$_POST['nick']."',
                        username = '".$_POST['user']."' 
                        WHERE id_admin = '".$a['id_admin']."'");

                        if($upd){
                            echo "<script>alert('Profile has been update')</script>";
                            echo "<script>window.location='profile.php'</script>";
                        } else {
                            echo mysqli_error($conn);
                        }
                    }
                    if(isset($_POST['changepass'])) {
                        $pass1 = $_POST['pass1'];
                        $pass2 = $_POST['pass2']; 

                        if($pass2 != $pass1) {
                            echo "<script>alert('Confirm the new password does not match')</script>";
                        } else {
                            $changepass = mysqli_query($conn, "UPDATE tb_admin SET password = '".MD5($pass1)."'
                            WHERE id_admin = '".$a['id_admin']."' ");

                            if($changepass){
                                echo "<script>alert('Password changed successfully')</script>";
                                echo "<script>window.location='profile.php'</script>";
                            } else {
                                echo "Something error ".mysqli_error($conn);
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body> 
</html>