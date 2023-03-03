<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');
if (isset($_POST['bt-sm-insert']) && isset($_SESSION['userid'])) {
    $upDate = $_POST['bt-sm-insert'];
    $userId = $_SESSION['userid'];
    $sqlupdate = "UPDATE `order` SET `order_status` = 1 where `orderID` = $upDate";
    $sqlpickup = "INSERT INTO `pickup`(`orderID`, `userid`) VALUES ('$upDate'" . ",'" . $userId . "')";
    $sqlorder_detail = "SELECT `fur_id`, `orderQty` FROM `order` JOIN `order_detail` ON `order`.`orderID` = `order_detail`.`orderID` WHERE `order_detail`.`orderID` = $upDate;";
    mysqli_query($conn, $sqlpickup);
    $pickupID = mysqli_insert_id($conn);
    $stock = mysqli_query($conn, $sqlorder_detail);
    while ($row_stock = mysqli_fetch_array($stock)) {
        $sqlUpstock = "UPDATE `furniture` SET amount = amount + '" . $row_stock['orderQty'] . "' WHERE fur_id ='" . $row_stock['fur_id'] . "'";
        mysqli_query($conn, $sqlUpstock);
        $sqlpickup_detail = "INSERT INTO `pickup_detail`(`fur_id`, `pickID`, `pickQty`) VALUES ('" . $row_stock['fur_id'] . "','$pickupID','" . $row_stock['orderQty'] . "')";
        mysqli_query($conn, $sqlpickup_detail);
    }
    mysqli_query($conn, $sqlupdate);
    echo "<script> window.location='./report-order-list.php'; </script>";
}
?>
