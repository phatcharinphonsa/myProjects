<?php
require_once __DIR__ . '/vendor/autoload.php';

$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$mpdf = new \Mpdf\Mpdf([
    'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/tmp',
    ]),
    'fontdata' => $fontData + [
        'sarabun' => [
            'R' => 'THSarabunNew.ttf',
            'I' => 'THSarabunNew Italic.ttf',
            'B' => 'THSarabunNew Bold.ttf',
            'BI' => 'THSarabunNew BoldItalic.ttf'
        ]
    ],
    'default_font' => 'sarabun'
]);
// สิ้นสุดคำสั่ง Export ไฟล์ PDF ในส่วนบน เริ่มกำหนดตำแหน่งเริ่มต้นในการนำเนื้อหามาแสดงผลผ่าน
$mpdf->SetFont('sarabun', '', 14);
ob_start();  //ฟังก์ชัน ob_start()
?>
<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
    <link rel="icon" type="image/x-icon" href="../assets/images/logo_icon.ico">
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
</head>

<body>
    <section class="home-section mt-5">

        <div class="text-right ">
            <h6 class="text-right">เลขทะเบียน : 0405563003376
            </h6>
            <h6 class="text-right">บริษัท ยิ่งเจริญอินทีเรีย จำกัด 1079 หมู่ที่ 1 ตำบลชุมแพ อำเภอชุมแพ จังหวัดขอนแก่น 40130
            </h6>
            <h6 class="text-right">1079 หมู่ที่ 1 ตำบลชุมแพ อำเภอชุมแพ จังหวัดขอนแก่น 40130
            </h6>
        </div>
        <h5 class="mt-2 mb-5 text-center">รายการสั่งซื้อสินค้า</h5>

        <table class="table" style="width: 100%;">
            <thead>
                <tr>
                    <th style="width:5%" class="text-center">ลำดับ</th>
                    <th class="text-center">เลขที่ใบสั่งซื้อ</th>
                    <th class="text-center">สินค้า</th>
                    <th class="text-center">จำนวน</th>
                    <th class="text-center">ราคา/หน่วย</th>
                    <th class="text-center">ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $total_price = 0;
                $sql = "SELECT `order_detail`.`orderID`, `furniture`.`fur_name`, `order_detail`.`orderQty`, `order_detail`.`orderPrice`, `order_detail`.`total` FROM `order_detail` JOIN `furniture` ON `order_detail`.`fur_id` = `furniture`.`fur_id`;";
                $rs = mysqli_query($conn, $sql);
                if (!$rs) {
                    die("Query failed: " . mysqli_error($conn));
                }
                while ($row = mysqli_fetch_array($rs)) {
                    $total_price = $total_price + $row['total'];
                ?>
                    <tr>
                        <td style="width:5%" class="text-center">
                            <?php echo $i; ?>
                        </td>
                        <td class="text-center">
                            <?= $row['orderID'] ?>
                        </td>
                        <td>
                            <?= $row['fur_name']  ?>
                        </td>
                        <td class="text-center">
                            <?= $row['orderQty'] ?>
                        </td>
                        <td class="text-center">
                            <?php echo number_format($row['orderPrice'], 2); ?>
                        </td>
                        <td class="text-center">
                            <?php echo number_format($row['total'], 2); ?>
                        </td>
                    </tr>
                <?php
                    $i++;
                }
                ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center">
                        <h6>รวมยอดสุทธิ</h6>
                    </td>
                    <td class="text-center">
                        <h6><?= number_format($total_price, 2) ?> บาท</h6>
                    </td>
                </tr>
            </tbody>
        </table> <?php
                    // คำสั่งการ Export ไฟล์เป็น PDF
                    $html = ob_get_contents();      // เรียกใช้ฟังก์ชัน รับข้อมูลที่จะมาแสดงผล
                    $mpdf->WriteHTML($html);        // รับข้อมูลเนื้อหาที่จะแสดงผลผ่านตัวแปร $html
                    $mpdf->Output('report-order-sum.pdf');  //สร้างไฟล์ PDF ชื่อว่า myReport.pdf
                    ob_end_flush();                 // ปิดการแสดงผลข้อมูลของไฟล์ HTML ณ จุดนี้
                    ?>
        <div class="input-box button text-center mb-5">
            <a href="report-order-sum.pdf"><button class="btn btn-success">แปลงไฟล์ PDF</button> </a>
            <a href="index.php"><button class="btn btn-danger">กลับ</button> </a>
            </a>
        </div>


    </section>

</body>

</html>