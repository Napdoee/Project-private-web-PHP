    <div class="navbar">
        <div class="topnav">
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
            <a href="javascript:void(0)"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo date('l, d F Y g:i A')?></a>
            <a href="profile.php"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['a_name']; ?></a>
            <a href="javascript:void(0)" onclick="ChangeTheme()">Theme</a>
            <a href="javascript:void(0)" onclick="ToggleNav()" class="split"><b>☰ Localhost</b></a>
        </div>
        <div id="sidenav" class="sidenav">
            <a class="<?php echo basename($_SERVER['PHP_SELF']) == 'home.php' ? 'active' : '' ?>" href="home.php">
            <i class="fa fa-home" aria-hidden="true"></i> Home</a>
            <a class="<?php echo basename($_SERVER['PHP_SELF']) == 'gallery.php' ? 'active' : '' ?>" href="gallery.php">
            <i class="fa fa-picture-o" aria-hidden="true"></i> Pictures</a>
            <a class="<?php echo basename($_SERVER['PHP_SELF']) == 'my-task.php' ? 'active' : '' ?>" href="my-task.php">
            <i class="fa fa-list" aria-hidden="true"></i> My Task</a>
            <a class="<?php echo basename($_SERVER['PHP_SELF']) == 'my-wish.php' ? 'active' : '' ?>" href="my-wish.php">
            <i class="fa fa-list" aria-hidden="true"></i> My Wishlist</a>
            <!-- <a class="<?php echo basename($_SERVER['PHP_SELF']) == 'financial.php' ? 'active' : '' ?>" href="financial.php">
            <i class="fa fa-money" aria-hidden="true"></i> Financial Data</a> -->
            <a class="<?php echo basename($_SERVER['PHP_SELF']) == 'crud.php' ? 'active' : '' ?>" href="crud.php">
            <i class="fa fa-cogs" aria-hidden="true"></i> Settings</a>
        </div>
    </div>