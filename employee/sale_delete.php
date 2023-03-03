<?php
ob_start();
session_start();

if (isset($_GET["Line2"])) {
    $Line = $_GET["Line2"];
    $_SESSION["strProductID2"][$Line] = "";
    $_SESSION["strQty2"][$Line] = "";
}
header("location:cart2.php");
?>