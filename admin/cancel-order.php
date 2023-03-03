<?php
session_start();
include "./menu.php";
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');

$ids=$_GET['id'];
$sql="UPDATE order SET order_status = 3"
?>