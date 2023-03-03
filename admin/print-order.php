<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');

$sql = "SELECT *
        FROM `order`
        JOIN `agents` ON `order`.`agent_id` = `agents`.`agent_id`
        WHERE `order`.`orderID` = '" . $_SESSION["order_id"] . "'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error executing query: " . mysqli_error($conn));
}

$rs = mysqli_fetch_array($result);
$total_price = $rs['total_price'];
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
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
                    <h3>เลขที่ใบสั่งซื้อ : <?= $rs['orderID'] ?></h3>
                    <h6>ร้านตัวแทน : <?= $rs['agent_id'] ?> <?= $rs['agent_name'] ?></h6>
                    <h6>เบอร์โทรติดต่อ : <?= $rs['agent_phone'] ?>
                        <h6>วันที่สั่งซื้อ : <?= $rs['reg_date'] ?></h6>
                        <h6>สถานะ : <?= $rs['order_status'] == 0 ? "รอรับสินค้า" : "ได้รับสินค้าแล้ว" ?>
                        </h6>
                        <table class="table mt-5">
                            <thead class="">
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
                                $sql1 = "select * from order_detail as d,furniture as p where d.fur_id=p.fur_id and
                                d.orderID='" . $_SESSION["order_id"] . "'";
                                $result1 = mysqli_query($conn, $sql1);
                                while ($row = mysqli_fetch_array($result1)) {
                                ?> <tr>
                                        <td style="width:5%" class="text-center"><?php echo $i++; ?></td>
                                        <td><?= $row["fur_id"] . $_SESSION["order_id"] ?></td>
                                        <td><?= $row["fur_name"] ?></td>
                                        <td class="text-right"><?php echo number_format($row['orderPrice'], 2); ?></td>
                                        <td class="text-center"><?= $row["orderQty"] ?></td>
                                        <td class="text-right"> <?php echo number_format($row['total'], 2); ?></td>
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
                            <td class="text-right"><?php echo  number_format($total_price, 2); ?></td>
                        </tr>
                        </table>

                </div>
                <div id="non-printable" class="text-left mt-5 ">
                    <div class="row">
                        <div class="col-xl-11 col-lg-4 col-md-4 col-sm-6 col-12">
                            <a href=' ./report-order-list.php'>
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