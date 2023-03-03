<?php
session_start();
include "./menu.php";
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>

<body>
    <section class="home-section mt-5">
        <form class="con" method="post">
            <div class="container">
                <h3 class="text-center mt-5 mb-2">รายงานการสั่งซื้อ</h3>
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
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <label>ตั้งแต่วันที่ *</label>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <input type="date" name="start_date" class="form-control" value="<?php if (isset($_POST['start_date'])) {
                                                                                                echo $_POST['start_date'];
                                                                                            } else {
                                                                                                $_POST['start_date'] = date("Y-m-d", time() - 604800);
                                                                                                echo $_POST['start_date'];
                                                                                            } ?>">

                    </div>
                    <div class=" col-xl-1 col-lg-4 col-md-4 col-sm-6 col-12">
                        <label>ถึงวันที่ *</label>
                    </div>
                    <div class=" col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <input type="date" name="end_date" class="form-control" value="<?php if (isset($_POST['end_date'])) {
                                                                                            echo $_POST['end_date'];
                                                                                        } else {
                                                                                            $_POST['end_date'] = date("Y-m-d", time() + 86400);
                                                                                            echo $_POST['end_date'];
                                                                                        } ?>">
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-xl-2 col-lg-4 col-md-4 col-sm-6 col-12">
                        <label>ประเภทการค้นหา</label>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12">
                        <select class="form-select form-select mb-3" aria-label=".form-select example" name="type" required>
                            <option value="0">ประเภทการค้นหา</option>
                            <option value="1">ใบสั่งซื้อสินค้าทั้งหมด</option>
                            <option value="2">รายการสั่งซื้อที่ยังไม่ได้รับสินค้า</option>
                            <option value="3">รายการสั่งซื้อที่ยังไม่ได้จ่ายชำระ</option>
                            <option value="4">ใบสั่งซื้อที่จ่ายชำระแล้ว</option>
                        </select>
                    </div>
                    <div class="col-xl-1 ">
                    </div>
                    <div class="col-xl-1">
                        <button type="submit" class="btn btn-success" name="bt-sm-insert">
                            <i class='bx bx-search'></i>
                            ค้นหา</button>
                    </div>
                </div>
            </div>
            <div class="container mt-3 mb-2">
                <div class="table-responsive">
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
                                    echo "<td>วัน เดือน ปี</td>";
                                    echo "<td>ชื่อร้านตัวแทน</td>";
                                    echo "<td>ยอดสั่งซื้อ</td>";
                                    echo "<td class='text-center' >สถานะ</td>";
                                } elseif ($_POST['type'] == 2) {
                                    echo "<td class='text-center'>ลำดับ</td>";
                                    echo "<td class='text-center'>เลขที่ใบสั่งซื้อ</td>";
                                    echo "<td>วันที่สั่งซื้อสินค้า</td>";
                                    echo "<td>ชื่อร้านตัวแทน</td>";
                                    echo "<td class='text-center'>ยอดสุทธิ</td>";
                                    echo "<td class='text-center'>สถานะสินค้า</td>";
                                } elseif ($_POST['type'] == 3) {
                                    echo "<td class='text-center'>ลำดับ</td>";
                                    echo "<td class='text-center'>เลขที่ใบรับ</td>";
                                    echo "<td>วันที่รับสินค้า</td>";
                                    echo "<td>ชื่อร้านตัวแทน</td>";
                                    echo "<td class='text-center'>ยอดสุทธิ</td>";
                                    echo "<td class='text-center'>สถานะสินค้า</td>";
                                } elseif ($_POST['type'] == 4) {
                                    echo "<td class='text-center'>ลำดับ</td>";
                                    echo "<td class='text-center'>เลขที่ใบจ่ายชำระ</td>";
                                    echo "<td>วันที่จ่ายชำระ</td>";
                                    echo "<td>ชื่อร้านตัวแทน</td>";
                                    echo "<td class='text-center'>ยอดสุทธิ</td>";
                                    echo "<td class='text-center'>สถานะสินค้า</td>";
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
                            } elseif ($_POST['type'] == 1) {
                                $sql = "SELECT `order`.`orderID`, `agents`.`agent_name`,`order`.`order_status`,`order`.`total_price`, `order`.`reg_date` FROM `order` JOIN `agents` ON `order`.`agent_id` = `agents`.`agent_id`WHERE `order`.`reg_date` BETWEEN '" . $_POST['start_date'] . "' AND '" . $_POST['end_date'] . "' ORDER BY `order`.`orderID` DESC";
                                $i = 1;
                                $result = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($result)) {
                            ?>
                                    <tr>
                                        <td style="width:5%" class="text-center"><?= $i++; ?></td>
                                        <td class='text-center'><?= $row['orderID']; ?></td>
                                        <td><?= $row['reg_date']; ?></td>
                                        <td><?= $row['agent_name']; ?></td>
                                        <td class='text-right'><?= number_format($row['total_price'], 2); ?></td>
                                        <td class='text-center'><?php
                                                                if ($row['order_status'] == "0") {
                                                                    $level = "รอรับสินค้า";
                                                                } elseif ($row['order_status'] == "1") {
                                                                    $level = "รอจ่ายชำระค่าสินค้า";
                                                                } elseif ($row['order_status'] == "2") {
                                                                    $level = "สำเร็จ";
                                                                }
                                                                echo $level;
                                                                ?>
                                        </td>
                                    </tr>
                                <?php
                                    $i++;
                                }
                            } elseif ($_POST['type'] == 2) {
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
                                        <td class='text-right'><?= number_format($row['total_price'], 2); ?></td>
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
                            } elseif ($_POST['type'] == 3) {
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
                                        <td class='text-right'><?= number_format($row['total_price'], 2); ?></td>
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
                            } elseif ($_POST['type'] == 4) {
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
                                        <td class='text-right'><?= number_format($row['total_price'], 2); ?></td>
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