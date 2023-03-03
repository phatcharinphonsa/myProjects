<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
include "./menu.php";
require('../config/config.php');
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
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <title>จัดการรายการขายสินค้า <?php echo $name; ?></title>
    <link rel="icon" type="image/x-icon" href="../assets/images/logo_icon.ico">
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
    <!-- bootstrap -->
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
    <script>
        function getOrder(id) {
            $(".oderId").text(id)
            $(".btn-success").val(Number(id))
            console.log(id);
            console.log($(".oderId").text())
            console.log($(".btn-success").val())
        }
    </script>
</head>

<body>
    <section class="home-section justify-center mt-5">
        <div class="con">

            <h5 class="mt-2 mb-3">แสดงข้อมูลการสั่งซื้อ
            </h5>
            <div class="mt-2 mb-3">
                <a href=' ./show-product.php'>
                    <button type="button" class='btn btn-success' style='margin-right: 5px;'>
                        สั่งซื้อสินค้า
                    </button></a>
                <a href=' ./report-order-success.php'>
                    <button type="button" class='btn btn-dark' style='margin-right: 5px;'>
                        สั่งซื้อสำเร็จ
                    </button></a>
                <a href=' ./report-order-list.php'>
                    <button type="button" class='btn btn-dark' style='margin-right: 5px;'>
                        รับสินค้า
                    </button></a>
                <a href=' ./report-order-pickup.php'>
                    <button type="button" class='btn btn-danger' style='margin-right: 5px;'>
                        จ่ายชำระ
                    </button></a>

            </div>
            <div class="table-responsive">
                <table id="myTable" class="display" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">ลำดับ</th>
                            <th>เลขที่ใบสั่งซื้อ</th>
                            <th>ร้านตัวแทน</th>
                            <th>วันที่สั่ง</th>
                            <th>ยอดสั่งซื้อ</th>
                            <th>สถานะ</th>
                            <th>รายละเอียด</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql = "SELECT * FROM `order` JOIN `agents` ON `order`.`agent_id` = `agents`.`agent_id` ORDER BY reg_date DESC";
                        $rs = mysqli_query($conn, $sql);
                        if (!$rs) {
                            die("Query failed: " . mysqli_error($conn));
                        }
                        while ($row = mysqli_fetch_array($rs)) {
                        ?>
                            <tr>
                                <td style="width:5%" class="text-center">
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?= $row['orderID'] ?>
                                </td>
                                <td>
                                    <?= $row['agent_id'] . " " . $row['agent_name'] ?>
                                </td>
                                <td>
                                    <?= $row['reg_date'] ?>
                                </td>
                                <td>
                                    <?php echo $row['total_price']; ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['order_status'] == "0") {
                                        $level = "กำลังดำเนินการ";
                                    } elseif ($row['order_status'] == "1") {
                                        $level = "รับสินค้า";
                                    } elseif ($row['order_status'] == "2") {
                                        $level = "จ่ายชำระแล้ว";
                                    } elseif ($row['order_status'] == "3") {
                                        $level = "สำเร็จ";
                                    }
                                    echo $level;
                                    ?>
                                </td>
                                <td>
                                    <a href='./detail-order.php?id=<?= $row['orderID'] ?>'>
                                        <button type="button" class='btn btn-success' style='margin-right: 5px;'>
                                            รายละเอียด
                                        </button></a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
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

</html>