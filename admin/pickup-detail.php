<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');
$ids = $_GET['id'];
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
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
    <title>รายละเอียดการสั่งซื้อสินค้า <?php echo $name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <style type="text/css">
        #printable {
            display: none;
        }

        @media print {
            #non-printable {
                display: none;
            }

            #printable {
                display: block;
            }
        }
    </style>
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
        <div class="container mt-3">
            <div>
                <img src="../images/logo1.png" height="80" alt="logo">
            </div>
            <div class="text-right mb-5">
                <h6 class="text-right">เลขทะเบียน : 0405563003376
                </h6>
                <p class="text-right">1079 หมู่ที่ 1 ตำบลชุมแพ อำเภอชุมแพ จังหวัดขอนแก่น 40130
                </p>
            </div>
            <div class="mt-5">
                <div class="container mt-3 mb-2">
                    <h5>เลขที่ใบรับสินค้า : <?= $ids ?></h5>
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th style="width:5%" class="text-center">#</th>
                                <th>รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th class="text-center">ราคา</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql1 = "SELECT * FROM order_detail as d, furniture as p, `order` as t WHERE d.orderID = t.orderID AND d.fur_id = p.fur_id AND d.orderID='" . $ids . "' ORDER BY d.fur_id";
                            $sum_total2 = 0;
                            $result1 = mysqli_query($conn, $sql1);
                            while ($row = mysqli_fetch_array($result1)) {
                                $sum_total2 = $row['total_price'];
                            ?>
                                <tr>
                                    <td style="width:5%" class="text-center">
                                        <?= $i++; ?>
                                    </td>
                                    <td>
                                        <?= $row["fur_id"] ?>
                                    </td>
                                    <td>
                                        <?= $row["fur_name"] ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo number_format($row['orderPrice'], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $row["orderQty"] ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo number_format($row['total'], 2); ?>
                                    </td>
                                </tr>
                        </tbody>
                    <?php
                            }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>รวมทั้งสิ้น</td>
                        <td></td>
                        <td></td>
                        <td class="text-right"><?php echo number_format($sum_total2, 2); ?></td>
                    </tr>
                    </table>
                    </table>

                </div>
                <div class="text-left mt-5" id="non-printable">
                    <a href='report-order-pickup.php'>
                        <button type="button" class='btn btn-dark' style='margin-right: 5px;'>
                            กลับ
                        </button></a>
                </div>
            </div>
        </div>

        </div>
    </section>

</body>
<?php
mysqli_close($conn);
?>

</html>