<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');


if (isset($_POST['bt-sm-insert'])) {
    $orderId = $_POST['bt-sm-insert'];
    $sqlUpdate = "UPDATE `order` SET `order_status` = 2 WHERE `orderID` = $orderId";
    mysqli_query($conn, $sqlUpdate);

    echo "<script> window.location = './report-order-pickup.php'; </script>";
}
?>