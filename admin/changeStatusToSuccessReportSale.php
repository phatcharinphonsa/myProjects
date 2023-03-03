<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');

if (isset($_POST['bt-sm-insert']) && isset($_SESSION['userid'])) {
    $saleID = $_POST['bt-sm-insert'];
    $userID = $_SESSION['userid'];
    $sqlUpdate = "UPDATE `sale` SET `order_status` = 0, `userid` = '$userID' WHERE `saleID` = $saleID";
    mysqli_query($conn, $sqlUpdate);

    echo "<script> window.location = './report-sale-delivery.php'; </script>";
}
?>