<?php
session_start();
include "./menu.php";
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
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
    <link rel="stylesheet" type="text/css" href="../assets/css/admin_staff.css">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>สั่งซื้อสินค้า โดย <?php echo $name; ?></title>
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
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
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

            <form action="./insert-cart.php" method="POST">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <p class="card-header">แบบฟอร์มบันทึกข้มูลสั่งซื้อสินค้า</p>
                        <div class="table-responsive mt-3">
                            <div class="col-md-12 mb-5">
                                <label>เลือกร้านตัวแทนเพื่อสั่งซื้อ :</label>
                                <select class="form-select form-select mb-3" aria-label=".form-select example" name="agent_id" required>
                                    <option hidden value="">กรุณาเลือกร้านตัวแทน</option>
                                    <?php
                                    $sql_type = "SELECT * FROM agents";
                                    $rs_type = mysqli_query($conn, $sql_type);
                                    while ($row_type = mysqli_fetch_array($rs_type)) {
                                        echo "<option value='" . $row_type['agent_id'] . "'>" . $row_type['agent_name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">


                        <div class="table-responsive mb-3">
                            <table class="table table-sm" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th style="width:5%" class="text-center">ลำดับ</th>
                                        <th class="text-center">รหัสสินค้า</th>
                                        <th>ชื่อสินค้า</th>
                                        <th class="text-center">ราคา</th>
                                        <th class="text-center">จำนวน</th>
                                        <th class="text-center">ราคารวม</th>

                                        <th>จัดการ</th>
                                        <th>ยกเลิก</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sumPrice = 0;
                                    $m = 1;
                                    $sumTotal = 0;
                                    if (!isset($_SESSION["intLine"])) {
                                        return "javascript:history.back()";
                                    }
                                    for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {
                                        if ($_SESSION["strProductID"][$i] != "") {
                                            $sql1 = "select * from furniture where fur_id = '" . $_SESSION["strProductID"][$i] . "'";
                                            $result = mysqli_query($conn, $sql1);
                                            $row_pro = mysqli_fetch_array($result);
                                            $_SESSION["fur_price"] = $row_pro['fur_price'];
                                            $total = $_SESSION["strQty"][$i];
                                            $sum = $total * $row_pro['fur_price'];
                                            $sumPrice = (float) $sumPrice + $sum;
                                            $_SESSION["sumPrice"] = $sumPrice;
                                            $sumTotal = $sumTotal + $total;
                                    ?>
                                            <tr>
                                                <td style="width:5%" class="text-center">
                                                    <?php echo $m; ?>
                                                </td>
                                                <td class="text-center mt-3">
                                                    <?php echo $row_pro['fur_id']; ?>
                                                </td>
                                                <td class="mt-3">
                                                    <?php echo $row_pro['fur_name']; ?>
                                                </td>
                                                <td class="mt-3 text-right">
                                                    <?php echo number_format($row_pro['fur_price'], 2); ?>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                    &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;

                                                </td>
                                                <td class="text-center mt-3">
                                                    <?= $total ?>
                                                </td>
                                                <td class="mt-3 text-right">
                                                    <?php echo number_format($sum, 2); ?>&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;
                                                    &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp;

                                                </td>

                                                <td class="mt-3">
                                                    <a type="button" class='btn btn-success mt-2' href="order.php?id=<?php echo $row_pro['fur_id']; ?>">
                                                        <i class='bx bx-message-square-add'></i>
                                                    </a>
                                                    <?php if ($_SESSION["strQty"][$i] > 1) { ?>
                                                        <a type="button" class='btn btn-primary mt-2' href='order-delete.php?id=<?php echo $row_pro['fur_id']; ?>'>

                                                            <i class='bx bx-message-square-minus'></i>

                                                        </a>
                                                    <?php } ?>
                                                </td>
                                                <td class="mt-3">
                                                    <a href='pro_delete.php?Line=<?= $i ?>'>
                                                        <button type="button" class='btn btn-danger mt-2' style='margin-right: 5px;'>
                                                            <i class='bx bx-trash'></i>
                                                        </button>
                                                    </a>
                                                </td>
                                            </tr>

                                    <?php
                                        }
                                        $m++;
                                    }
                                    ?>
                                </tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>รวมยอดสั่งซื้อ</td>
                                    <td></td>
                                    <td class="mt-3 text-center"><?= $sumTotal ?></td>
                                    <td class="mt-3 text-center">&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <?php echo number_format($sumPrice, 2); ?> บาท</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>


                </div>
                <div class=" row">
                    <div class="col-md-6"><a href=' ./show-product.php'>
                            <button type="button" class='btn btn-dark' style='margin-right: 5px;'>
                                <i class='bx bxs-left-arrow'></i>
                                &nbsp; &nbsp; เพิ่มรายการสั่งซื้อ
                            </button></a>
                    </div>
                    <div class="col-md-6 text-right"><button type="submit" class='btn btn-success' style='margin-right: 5px;'>
                            ยืนยันการสั่งซื้อ &nbsp; &nbsp; <i class='bx bxs-right-arrow'></i>
                        </button>
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