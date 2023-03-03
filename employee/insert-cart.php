<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');
$agent_id = $_POST['agent_id'];
$sql = "INSERT INTO `order`( `agent_id`, `total_price`, `order_status`) VALUES ('$agent_id','" . $_SESSION["sumPrice"] . "','0')";
mysqli_query($conn, $sql);
$orderID = mysqli_insert_id($conn);
$_SESSION["order_id"] = $orderID;
for ($i = 0; $i <= (int) $_SESSION["intLine"]; $i++) {
    if ($_SESSION["strProductID"][$i] != "") { 
        $sql1 = "select * from furniture where fur_id = '" . $_SESSION["strProductID"][$i] . "'";
        $result1 = mysqli_query($conn, $sql1);
        mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_array($result1);
        $price = $row1["fur_price"];
        $total = $_SESSION["strQty"][$i] * $price;
        $sql2 = "INSERT INTO `order_detail`( `orderID`, `fur_id`, `orderPrice`, `orderQty`, `total`) 
        VALUES ('$orderID', '" . $_SESSION["strProductID"][$i] . "','$price','" . $_SESSION["strQty"][$i] . "','$total')";
        mysqli_query($conn, $sql2);
    }
    echo "<script> window.location='print-order.php'; </script>";  
}
mysqli_close($conn); 
unset($_SESSION["intLine"]);
unset($_SESSION["strProductID"]);
unset($_SESSION["strQty"]);
unset($_SESSION["sumPrice"]);
?>