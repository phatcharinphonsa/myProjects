<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
include "./menu.php";
require('../config/config.php');
?>
<?php
$_POST['type'] = isset($_POST['type']) ? $_POST['type'] : 0;
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
    <title>รายละเอียดการสั่งซื้อสินค้า <?php echo $name; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
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
        <form class="con" method="POST">
            <div class="container">
                <h3 class="text-center mt-5 mb-2">รายงานการสั่งซื้อ - การขาย</h3>
                <div>
                    <img src="../images/logo1.png" height="80" alt="logo">
                </div>
                <div class="text-right mb-5">
                    <h6 class="text-right">เลขทะเบียน : 0405563003376
                    </h6>
                    <p class="text-right">1079 หมู่ที่ 1 ตำบลชุมแพ อำเภอชุมแพ จังหวัดขอนแก่น 40130
                    </p>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                        <label>วันที่ *</label>
                        <input type="date" name="start_data" class="form-control" value="<?php if (isset($_POST['start_date'])) {
                                                                                                echo $_POST['start_date'];
                                                                                            } else {
                                                                                                $_POST['start_date'] = date("Y-m-d", time() - 604800);
                                                                                                echo $_POST['start_date'];
                                                                                            } ?>">
                    </div>
                    <div class=" col-xl-6 col-lg-4 col-md-4 col-sm-6 col-12">
                        <label>ถึงวันที่ *</label>
                        <input type="date" name="end_date" class="form-control" value="<?php if (isset($_POST['end_date'])) {
                                                                                            echo $_POST['end_date'];
                                                                                        } else {
                                                                                            $_POST['end_date'] = date("Y-m-d", time() + 86400);
                                                                                            echo $_POST['end_date'];
                                                                                        } ?>">
                    </div>
                </div>
                <div class="row mt-2" id="non-printable">
                    <div class="col-xl-12 col-lg-4 col-md-4 col-sm-6 col-12">
                        <label>ประเภทการค้นหา</label>
                        <select class="form-select form-select mb-3" aria-label=".form-select example" name="type" required>
                            <option value="0">ประเภทการค้นหา</option>
                            <option value="1">รายการสั่งซื้อสินค้าทั้งหมด</option>
                            <option value="2">รายการสั่งซื้อที่ยังไม่ได้รับสินค้า</option>
                            <option value="3">รายการสั่งซื้อที่ยังไม่ได้จ่ายชำระ</option>
                            <option value="4">ใบสั่งซื้อที่จ่ายชำระแล้ว</option>
                            <option value="5">รายการขายสินค้าทั้งหมด</option>
                            <option value="6">ข้อมูลขายที่ยังไม่จัดส่งสินค้า</option>
                            <option value="7">ใบสั่งซื้อที่ขายสำเร็จ</option>
                            <option value="8">รายงานกำไร/หน่วย</option>
                            <option value="9">สินค้าคงเหลือ</option>
                        </select>
                    </div>
                </div>
                <div class="text-center mt-5" id="non-printable">
                    <button type="submit" class="btn btn-success" name="bt-sm-insert">
                        <i class='bx bx-search'></i>
                        ค้นหา</button>
                </div>
                <div class="container mt-3 mb-2">
                    <div>
                        <table id="myTable" class="display" style="width: 100%;">
                            <thead>
                                <tr>
                                    <?php
                                    if (!isset($_POST['type'])) {
                                        $_POST['type'] == 0;
                                    }
                                    if ($_POST['type'] == 0) {
                                        echo "<td class='text-center'>ข้อมูล</td>";
                                    } elseif ($_POST['type'] == 1) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td class='text-center'>เลขที่ใบสั่งซื้อ</td>";
                                        echo "<td>ชื่อสินค้า</td>";
                                        echo "<td class='text-center'>จำนวนสินค้า</td>";
                                        echo "<td class='text-center'>ราคาสินค้า</td>";
                                        echo "<td class='text-center'>ราคารวม</td>";
                                    } elseif ($_POST['type'] == 2) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td class='text-center'>เลขที่ใบสั่งซื้อ</td>";
                                        echo "<td>วันที่รับสินค้า</td>";
                                        echo "<td>ชื่อร้านตัวแทน</td>";
                                        echo "<td class='text-center'>ยอดสุทธิ</td>";
                                        echo "<td class='text-center'>สถานะสินค้า</td>";
                                    } elseif ($_POST['type'] == 3) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td class='text-center'>เลขที่ใบสั่งซื้อ</td>";
                                        echo "<td>วันที่รับสินค้า</td>";
                                        echo "<td>ชื่อร้านตัวแทน</td>";
                                        echo "<td class='text-center'>ยอดสุทธิ</td>";
                                        echo "<td class='text-center'>สถานะสินค้า</td>";
                                    } elseif ($_POST['type'] == 4) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td class='text-center'>เลขที่ใบสั่งซื้อ</td>";
                                        echo "<td>วันที่จ่ายชำระ</td>";
                                        echo "<td>ชื่อร้านตัวแทน</td>";
                                        echo "<td class='text-center'>ยอดสุทธิ</td>";
                                        echo "<td class='text-center'>สถานะสินค้า</td>";
                                    } elseif ($_POST['type'] == 5) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td>เลขที่ใบขาย</td>";
                                        echo "<td>ชื่อสินค้า</td>";
                                        echo "<td class='text-center'>จำนวนสินค้า</td>";
                                        echo "<td class='text-center'>ราคาสินค้า</td>";
                                        echo "<td class='text-center'>ราคารวม</td>";
                                    } elseif ($_POST['type'] == 6) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td class='text-center'>เลขที่ใบขาย</td>";
                                        echo "<td>วันที่ขาย</td>";
                                        echo "<td>ชื่อร้านตัวแทน</td>";
                                        echo "<td class='text-center'>ยอดสุทธิ</td>";
                                        echo "<td class='text-center'>สถานะสินค้า</td>";
                                    } elseif ($_POST['type'] == 7) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td class='text-center'>เลขที่ใบขาย</td>";
                                        echo "<td>วันที่ขาย</td>";
                                        echo "<td>ชื่อร้านตัวแทน</td>";
                                        echo "<td class='text-center'>ยอดสุทธิ</td>";
                                        echo "<td class='text-center'>สถานะสินค้า</td>";
                                    } elseif ($_POST['type'] == 8) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td>รหัสสินค้า</td>";
                                        echo "<td>ชื่อสินค้า</td>";
                                        echo "<td class='text-center'>ราคาซื้อ</td>";
                                        echo "<td class='text-center'>ราคาขาย</td>";
                                        echo "<td class='text-center'>กำไร/หน่วย</td>";
                                    } elseif ($_POST['type'] == 9) {
                                        echo "<td class='text-center'>ลำดับ</td>";
                                        echo "<td>รหัสสินค้า</td>";
                                        echo "<td>ชื่อสินค้า</td>";
                                        echo "<td>ประเภทสินค้า</td>";
                                        echo "<td class='text-center'>จำนวนคงเหลือ</td>";
                                    } else {
                                        echo "<td class='text-center'>ข้อมูล</td>";
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($_POST['type'] == 0) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>กรุณาเลือกประเภทการค้นหา</td>";
                                    echo "</tr>";
                                } elseif ($_POST['type'] == 1) { //รายการสั่งซื้อสินค้าทั้งหมด
                                    $i = 1;
                                    $sql = "SELECT `order_detail`.`orderID`, `furniture`.`fur_name`, `order_detail`.`orderQty`, `order_detail`.`orderPrice`, `order_detail`.`total` FROM `order_detail` 
                                        JOIN `furniture` ON `order_detail`.`fur_id` = `furniture`.`fur_id`;";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td class='text-center'><?php echo $row['orderID'] ?></td>
                                            <td><?php echo $row['fur_name'] ?></td>
                                            <td class="text-center"><?php echo number_format($row['orderQty']) ?></td>
                                            <td class='text-right'><?php echo number_format($row['orderPrice']) ?></td>
                                            <td class='text-right'><?php echo number_format($row['total']) ?></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 2) { //สั่งสินค้า
                                    $i = 1;
                                    $sql = "SELECT `order`.`orderID`, `agents`.`agent_name`, `order`.`order_status`, `order`.`total_price`, `order`.`reg_date` FROM `order` 
                                JOIN `agents` ON `order`.`agent_id` = `agents`.`agent_id` WHERE `order`.`order_status` = 0 
                                AND `order`.`reg_date` BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "' ORDER BY `order`.`orderID` DESC";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td class='text-center'><?php echo $row['orderID'] ?></td>
                                            <td><?php echo $row['reg_date'] ?></td>
                                            <td><?php echo $row['agent_name'] ?></td>
                                            <td class='text-right'><?php echo $row['total_price'] ?></td>
                                            <td class='text-center'>
                                                <?php
                                                if ($row['order_status'] == 0) {
                                                    $level = "รอรับสินค้า";
                                                } elseif ($row['order_status'] == 1) {
                                                    $level = "รอจ่ายชำระ";
                                                } elseif ($row['order_status'] == 2) {
                                                    $level = "จ่ายชำระแล้ว";
                                                }
                                                echo $level;
                                                ?>
                                            </td>

                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 3) { //การรับสินค้า
                                    $i = 1;
                                    $sql = "SELECT `order`.`orderID`, `agents`.`agent_name`, `order`.`order_status`, `order`.`total_price`, `order`.`reg_date` FROM `order` 
                                JOIN `agents` ON `order`.`agent_id` = `agents`.`agent_id` WHERE `order`.`order_status` = 1 
                                AND `order`.`reg_date` BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "' ORDER BY `order`.`orderID` DESC";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td class='text-center'><?php echo $row['orderID'] ?></td>
                                            <td><?php echo $row['reg_date'] ?></td>
                                            <td><?php echo $row['agent_name'] ?></td>
                                            <td class='text-right'><?php echo $row['total_price'] ?></td>
                                            <td class='text-center'>
                                                <?php
                                                if ($row['order_status'] == 0) {
                                                    $level = "รอรับสินค้า";
                                                } elseif ($row['order_status'] == 1) {
                                                    $level = "รอจ่ายชำระ";
                                                } elseif ($row['order_status'] == 2) {
                                                    $level = "จ่ายชำระแล้ว";
                                                }
                                                echo $level;
                                                ?>
                                            </td>

                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 4) { //การจ่ายชำระ
                                    $i = 1;
                                    $sql = "SELECT `order`.`orderID`, `agents`.`agent_name`, `order`.`order_status`, `order`.`total_price`, `order`.`reg_date` FROM `order` 
                                JOIN `agents` ON `order`.`agent_id` = `agents`.`agent_id` WHERE `order`.`order_status` = 2
                                AND `order`.`reg_date` BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "' ORDER BY `order`.`orderID` DESC";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td class='text-center'><?php echo $row['orderID'] ?></td>
                                            <td><?php echo $row['reg_date'] ?></td>
                                            <td><?php echo $row['agent_name'] ?></td>
                                            <td class='text-right'><?php echo $row['total_price'] ?></td>
                                            <td class='text-center'>
                                                <?php
                                                if ($row['order_status'] == 0) {
                                                    $level = "รอรับสินค้า";
                                                } elseif ($row['order_status'] == 1) {
                                                    $level = "รอจ่ายชำระ";
                                                } elseif ($row['order_status'] == 2) {
                                                    $level = "จ่ายชำระแล้ว";
                                                }
                                                echo $level;
                                                ?>
                                            </td>

                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 5) { //รายการขายสินค้าทั้งหมด
                                    $i = 1;
                                    $sql = "SELECT `sale_detail`.`saleID`, `furniture`.`fur_name`, `sale_detail`.`saleQty`, `sale_detail`.`salePrice`, `sale_detail`.`total` FROM `sale_detail` JOIN `furniture` ON `sale_detail`.`fur_id` = `furniture`.`fur_id` ;";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td><?php echo $row['saleID'] ?></td>
                                            <td><?php echo $row['fur_name'] ?></td>
                                            <td class="text-center"><?php echo number_format($row['saleQty']) ?></td>
                                            <td class='text-right'><?php echo number_format($row['salePrice']) ?></td>
                                            <td class='text-right'><?php echo number_format($row['total']) ?></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 6) { //การจัดส่ง
                                    $i = 1;
                                    $sql = "SELECT `sale`.`saleID`, `sale`.`reg_date`, `sale`.`total_price`, `sale`.`order_status`, `customers`.`cus_name` FROM `sale` 
                                JOIN `customers` ON `sale`.`cus_id` = `customers`.`cus_id` WHERE `sale`.`order_status` = 1 AND `sale`.`reg_date` 
                                BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "' ORDER BY `sale`.`saleID` DESC";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td class='text-center'><?php echo $row['saleID'] ?></td>
                                            <td><?php echo $row['reg_date'] ?></td>
                                            <td><?php echo $row['cus_name'] ?></td>
                                            <td class='text-right'><?php echo $row['total_price'] ?></td>
                                            <td class='text-center'>
                                                <?php
                                                if ($row['order_status'] == 0) {
                                                    $level = "สำเร็จ";
                                                } elseif ($row['order_status'] == 1) {
                                                    $level = "รอการจัดส่ง";
                                                }
                                                echo $level;
                                                ?>
                                            </td>

                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 7) { //การขายสำเร็จ
                                    $i = 1;
                                    $sql = "SELECT `sale`.`saleID`, `sale`.`reg_date`, `sale`.`total_price`, `sale`.`order_status`, `customers`.`cus_name` FROM `sale` 
                                JOIN `customers` ON `sale`.`cus_id` = `customers`.`cus_id` WHERE `sale`.`order_status` = 0 AND `sale`.`reg_date` 
                                BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "' ORDER BY `sale`.`saleID` DESC";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td class='text-center'><?php echo $row['saleID'] ?></td>
                                            <td><?php echo $row['reg_date'] ?></td>
                                            <td><?php echo $row['cus_name'] ?></td>
                                            <td class='text-right'><?php echo $row['total_price'] ?></td>
                                            <td class='text-center'>
                                                <?php
                                                if ($row['order_status'] == 0) {
                                                    $level = "สำเร็จ";
                                                } elseif ($row['order_status'] == 1) {
                                                    $level = "รอการจัดส่ง";
                                                }
                                                echo $level;
                                                ?>
                                            </td>

                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 8) {
                                    $i = 1;
                                    $sql = "SELECT `furniture`.`fur_id`, `furniture`.`fur_name`, `furniture`.`fur_price`, `furniture`.`fur_sale` FROM `furniture`";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td><?php echo $row['fur_id'] ?></td>
                                            <td><?php echo $row['fur_name'] ?></td>
                                            <td class='text-right'><?php echo number_format($row['fur_price']) ?></td>
                                            <td class='text-right'><?php echo number_format($row['fur_sale']) ?></td>
                                            <td class='text-right'><?php echo number_format($row['fur_sale'] - $row['fur_price']) ?></td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                } elseif ($_POST['type'] == 9) {
                                    $i = 1;
                                    $sql = "SELECT `furniture`.`fur_id`, `furniture`.`fur_name`, `furniture`.`amount`, furnituretype.furtype_name FROM `furniture` JOIN furnituretype ON furniture.furtype_id = furnituretype.furtype_id";
                                    $rs = mysqli_query($conn, $sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                    ?>
                                        <tr>
                                            <td style="width: 5%;" class="text-center"><?php echo $i ?></td>
                                            <td><?php echo $row['fur_id'] ?></td>
                                            <td><?php echo $row['fur_name'] ?></td>
                                            <td><?php echo $row['furtype_name'] ?></td>
                                            <td class='text-center'><?php echo number_format($row['amount']) ?></td>
                                        </tr>
                                <?php
                                        $i++;
                                    }
                                } else {
                                    echo "<tr>";
                                    echo "<td class='text-center'>กรุณาเลือกประเภทการค้นหา</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

        </form>
    </section>

</body>
<script>
    $(document).ready(function() {
        $("#myTable").DataTable({
            "language": {
                "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด",
                "search": " ค้นหา : ",
                "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "info": "แสดงผลลัพธ์ _PAGE_ จาก _PAGES_ หน้า",
                "infoEmpty": "ไม่พบตารางที่ค้นหา",
                "infoFiltered": "(ค้นหาจากทั้งหมด_MAX_ตาราง)",
                "searchPlaceholder": "",
                "paginate": {
                    "previous": "ก่อนหน้า",
                    "next": "หน้าถัดไป",

                }
            }
        });
    });
</script>
<?php
mysqli_close($conn);
?>

</html>