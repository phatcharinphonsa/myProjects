<?php
session_start();
include "./menu.php";
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');

$fur_id = $_GET['fur_id'];
$sql = "SELECT * FROM furniture WHERE fur_id='$fur_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
?>
<?php

$userid = $_SESSION['userid'];
$sqlUser = "SELECT * FROM users WHERE userid='$userid' ";
$resultsqlUser = mysqli_query($conn, $sqlUser);
$num_rows = mysqli_num_rows($resultsqlUser);
$rowsqlUser = mysqli_fetch_array($resultsqlUser);
$name = $rowsqlUser["name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/admin_staff.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>สังซื้อสินค้า <?php echo $name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03typeR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1typeK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <!-- datatable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body>
    <?php if (isset($_SESSION["process_success"])) : ?>
        <div class="alert alert-success">
            <?php echo $_SESSION["process_success"];
            unset($_SESSION["process_success"]);
            ?>

        </div>
    <?php elseif (isset($_SESSION["process_error"])) : ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION["process_error"];
            unset($_SESSION["process_error"]);
            ?>
        </div>
    <?php endif ?>
    <section class="home-section mt-5">
        <div class="con">
            <div>
                <img src="../images/logo1.png" height="80" alt="logo">
            </div>
            <div class="text-right">
                <h6 class="text-right">เลขทะเบียน : 0405563003376
                </h6>
                <p class="text-right">1079 หมู่ที่ 1 ตำบลชุมแพ อำเภอชุมแพ จังหวัดขอนแก่น 40130
                </p>
            </div>
            <form method="POST" action="./cart.php">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4 ">
                            <p class="card-header">รายการสั่งซื้อสินค้า</p>
                            <div class="table-responsive mt-3">
                                <table id="myTable" class="display" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width:5%" class="text-center">ลำดับ</th>
                                            <th>รหัสสินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>ราคาซื้อ</th>
                                            <th class="text-center">เลือก</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        $sumPrice = 0;
                                        $m = 1;
                                        for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {
                                            if ($_SESSION["strFurID"][$i] != "") {
                                                $sql1 = "select * from product where fur_id '" . $_SESSION["strFurID"][$i] . "'";
                                                $result1 = mysqli_query($conn, $sql1);
                                                $row_pro = mysqli_fetch_array($result1);
                                                $_SESSION["fur_price"] = $row_pro['fur_price'];
                                                $total = $_SESSION["strQty"][$i];
                                                $sum = $total * $row_pro['price'];
                                                $sumPrice = (float) $sumPrice + $sum;
                                                $_SESSION["sum_price"] = $sumPrice;
                                        ?>
                                                <tr>
                                                    <td style="width:5%" class="text-center">
                                                        <?php echo $m; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_pro['fur_name']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row_pro['fur_price']; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $_SESSION["strQty"][$i]; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href='cart.php?fur_id=<?php echo $row['fur_id']; ?>'>
                                                            <button type="button" class='btn btn-success' style='margin-right: 5px;'>
                                                                <i class='bx bx-shopping-bag'></i>
                                                            </button>
                                                        </a>
                                                    </td>

                                                </tr>
                                        <?php
                                            }
                                            $m = $m + 1;
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

</body>
<?php
mysqli_close($conn);
?>

</html>