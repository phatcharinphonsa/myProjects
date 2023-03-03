<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');
$sql = "SELECT *
        FROM `sale`
        JOIN `customers` ON `sale`.`cus_id` = `customers`.`cus_id`
        JOIN `users` ON `sale`.`userid` = `users`.`userid`
        WHERE `sale`.`saleID` = '" . $_SESSION["sale_id"] . "'";

$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$rs = mysqli_fetch_array($result);
$total_price = $rs['total_price'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../assets/css/admin_staff.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>ใบขายสินค้า</title>
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
                    <h5>เลขที่ใบขายสินค้า :
                        <?= $rs['saleID'] ?>
                    </h5>
                    <h6>ชื่อผู้ขาย :
                        <?= $rs['name'] ?>
                    </h6>
                    <h6>ชื่อลูกค้า :
                        <?= $rs['cus_id'] ?>
                        <?= $rs['cus_name'] ?>
                    </h6>
                    <h6>เบอร์โทรติดต่อ :
                        <?= $rs['cus_phone'] ?>
                    </h6>
                    <h6>ที่อยู่ :
                        <?= $rs['cus_add'] ?>
                    </h6>
                    <h6>วันที่สั่งซื้อ :
                        <?= $rs['reg_date'] ?>
                    </h6>
                    <table class="table mt-5">
                        <thead>
                            <tr>
                                <th style="width:5%" class="text-center">#</th>
                                <th class="text-center">รหัสสินค้า</th>
                                <th>ชื่อสินค้า</th>
                                <th class="text-center">ราคา</th>
                                <th class="text-center">จำนวน</th>
                                <th class="text-center">ราคารวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $sql2 = "select * from sale_detail d,furniture p where d.fur_id=p.fur_id and
                            d.saleID='" . $_SESSION["sale_id"] . "'";
                            $result2 = mysqli_query($conn, $sql2);
                            while ($row = mysqli_fetch_array($result2)) {
                            ?>
                                <tr>
                                    <td style="width:5%" class="text-center">
                                        <?php echo $i++; ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $row["fur_id"] ?>
                                    </td>
                                    <td>
                                        <?= $row["fur_name"] ?>
                                    </td>
                                    <td class="text-right">
                                        <?php echo number_format($row['salePrice'], 2); ?>
                                    </td>
                                    <td class="text-center">
                                        <?= $row["saleQty"] ?>
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
                        <td class="text-right"><?php echo number_format($total_price, 2); ?></td>
                    </tr>
                    </table>
                </div>
                <div id="non-printable" class="text-left mt-5 ">
                    <div class="row">
                        <div class="col-xl-11 col-lg-4 col-md-4 col-sm-6 col-12">
                            <a href='./report-sale-delivery.php'>
                                <button type="button" class='btn btn-dark' style='margin-right: 5px;'>
                                    กลับ
                                </button></a>
                        </div>

                        <div class="col-xl-1 col-lg-4 col-md-4 col-sm-6 col-12">
                            <a>
                                <button onclick="window.print()" class='btn btn-success' style='margin-right: 5px;'>
                                    ใบเสร็จ
                                </button>
                            </a>
                        </div>
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