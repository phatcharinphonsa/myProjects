<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');

$cus_id = $_POST['cus_id'];
$userid = $_SESSION['userid'];
$order_status = $_POST['order_status'];
$sql = "INSERT INTO `sale`( `cus_id`,`userid`, `total_price`, `order_status`) VALUES ('$cus_id','$userid','" . $_SESSION["sumPrice2"] . "','$order_status')";
mysqli_query($conn, $sql);

$saleID = mysqli_insert_id($conn);
$_SESSION["sale_id"] = $saleID;
if ($_POST['order_status'] == 0) {
}

if ($_POST['order_status'] == 1) {
    $_SESSION["sale_id"] = $saleID;
    $sqldalivery = "INSERT INTO `dalivery`(`saleID`, `cusname`) VALUES ('$saleID','$cus_id')";
    mysqli_query($conn, $sqldalivery);
}

for ($i2 = 0; $i2 <= (int) $_SESSION["intLine2"]; $i2++) {
    if ($_SESSION["strProductID2"][$i2] != "") { //ดึงข้อมูลสินค้า
        $sql1 = "select * from furniture where fur_id = '" . $_SESSION["strProductID2"][$i2] . "'";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_array($result1);
        $price2 = $row1["fur_sale"];
        $total2 = $_SESSION["strQty2"][$i2] * $price2;
        $sql2 = "INSERT INTO `sale_detail`( `saleID`, `fur_id`, `salePrice`, `saleQty`, `total`) 
        VALUES ('$saleID', '" . $_SESSION["strProductID2"][$i2] . "','$price2','" . $_SESSION["strQty2"][$i2] . "','$total2')";
        if (mysqli_query($conn, $sql2)) {
            //ตัดสต็อกสินค้า
            $sql3 = "UPDATE furniture SET amount= amount - '" . $_SESSION["strQty2"][$i2] . "' where fur_id ='" . $_SESSION["strProductID2"][$i2] . "'";
            mysqli_query($conn, $sql3);
            echo "<script> window.location='./print-sale.php'; </script>";
        }
    }
}
mysqli_close($conn);
unset($_SESSION["intLine2"]);
unset($_SESSION["strProductID2"]);
unset($_SESSION["strQty2"]);
unset($_SESSION["sumPrice2"]);
?>