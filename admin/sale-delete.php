<?php
ob_start();
session_start();
include '../config/config.php';

if (!isset($_SESSION["intLine2"])) //เช็คว่าแถวเป็นค่าว่างมั๊ย ถ้าว่างให้ทำงานใน {}
{
    $_SESSION["intLine2"] = 0;
    $_SESSION["strProductID2"][0] = $_GET["id"]; //รหัสสินค้า
    $_SESSION["strQty2"][0] = 1; //จำนวนสินค้า
    header("location:cart2.php");
} else {
    $key = array_search($_GET["id"], $_SESSION["strProductID2"]);
    if ((string) $key != "") {
        $_SESSION["strQty2"][$key] = $_SESSION["strQty2"][$key] - 1;
    } else {
        $_SESSION["intLine2"] = $_SESSION["intLine2"] + 1;
        $intNewLine = $_SESSION["intLine2"];
        $_SESSION["strProductID2"][$intNewLine] = $_GET["id"];
        $_SESSION["strQty2"][$intNewLine] = 1;
    }
    header("location:cart2.php");
}
?>