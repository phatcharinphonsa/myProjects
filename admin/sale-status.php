<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');

    if (isset($_POST['bt-sm-insert'])) {
        $upDate = $_POST['bt-sm-insert'];
        $sqlupdate = "UPDATE `sale` SET `order_status` = 1 where `saleID` = $upDate";
        mysqli_query($conn, $sqlupdate);
    }
?>