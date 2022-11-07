<?php
	session_start();
	include "partials/links.php";
    include "partials/theme.php";
    include "partials/users.php";
	include "database.php";

    if(isset($_POST['financial'])){
        $insert = mysqli_query($conn, "INSERT INTO `tb_financial` (`activity`, `amount`, `type`, `date`) 
        VALUES ('".$_POST['activity']."', '".$_POST['amount']."', '".$_POST['type']."', '".$_POST['date']."')");

        if($insert){
            echo "<script>window.location='financial.php'</script>";
        } else {
            echo "Error: ".mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Financial Data</title>
</head>
<body class="<?php echo $theme; ?>">
    <?php include "partials/navbar.php" ?>
    <div id="main" class="main">
        <div class="container-70">
            <a class="btn-1 inner-right" id="ModalBtn"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Activity</a>
		    <div class="title">Financial Data</div>
            <div class="box">
                <table class="table-2 financial" border="0">
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        
                        $financial = mysqli_query($conn, "SELECT * FROM tb_financial ORDER BY id_financial ASC");

                        if(mysqli_num_rows($financial) > 0) {
                            while($x = mysqli_fetch_array($financial)){
                            if($x['type'] == 'saving'){
                                $color = '#6fa9e173';
                                $plus  = '+';
                            } else if ($x['type'] == 'expenses'){
                                $color = '#d93737a1';
                                $plus = '-';
                            } else {
                                $color = '#5af54291';
                                $plus = '+';
                            }
                        ?>
                        <tr align="center" style="background-color: <?php echo $color ?>">
                            <td width="25%"><?php echo $x['activity'] ?></td>
                            <td><?php echo $plus." Rp. ".number_format($x['amount']) ?></td>
                            <td><?php echo date('d/m/Y', strtotime($x['date'])) ?></td>
                            <td><?php echo $x['type'] ?></td>
                            <td>
                                <a href="crud-edit.php?idf=<?php echo $x['id_financial']?>&from=financial.php"><i class="fa fa-pencil" aria-hidden="true"></i></a> |
                                <a href="crud-delete.php?idf=<?php echo $x['id_financial']?>&from=financial.php"
                                onclick="return confirm('Are you sure want delete this data (<?php echo $x['activity'] ?>) ?')">
                                <i class="fas fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <?php }} else { ?>
                            <p align="center">None Data Found</p>
                        <?php } ?>
                    </tbody>
                </table>
                <table class="table-2" style="background-color: #39588b8c;">
                    <?php 
                    $data = mysqli_query($conn, "SELECT sum(amount) as income FROM tb_financial WHERE type = 'income'");
                    $dt = mysqli_fetch_array($data);
                    $data2 = mysqli_query($conn, "SELECT sum(amount) as saving FROM tb_financial WHERE type = 'saving'");
                    $sv = mysqli_fetch_array($data2);
                    $data3 = mysqli_query($conn, "SELECT sum(amount) as expenses FROM tb_financial WHERE type = 'expenses'");                    
                    $ex = mysqli_fetch_array($data3);
                    ?>
                    <tr>
                        <td width="15%">Total Income</td>
                        <td width="10%">:</td>
                        <td width="50%">Rp. <?php echo number_format($dt['income']) ?></td>
                    </tr>
                    <tr>
                        <td>Total Expenses</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($ex['expenses']) ?></td>
                    </tr>
                    <tr>
                        <td>Total Saving</td>
                        <td>:</td>
                        <td>Rp. <?php echo number_format($sv['saving']) ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="container">
            <div class="modal" id="myModal">
                <div class="modal-box">
                    <div class="container">
                        <div class="title">Add Activity <span class="close">&times;</span></div>
                        <br>
                        <form method="POST" autocomplete="off">
                            <input type="text" name="activity" placeholder="Activity" class="input-control" required>
                            <input type="text" name="amount" placeholder="Amount" class="input-control" required>
                            <select name="type" class="input-control" required>
                                <option value="">--Select Type--</option>
                                <option value="saving">Saving</option>
                                <option value="expenses">Expenses</option>
                                <option value="income">Income</option>
                            </select>
                            <input type="date" name="date" class="input-control" required>
                            <input type="submit" name="financial" value="Add Activity" class="btn-1">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="styles/modal.js"></script>
    </div>
</body>
</html>