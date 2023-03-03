<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');
?>
<?php

$userid = $_SESSION['userid'];
$sqlUser = "SELECT * FROM users WHERE userid='$userid' ";
$resultsqlUser = mysqli_query($conn, $sqlUser);
$num_rows = mysqli_num_rows($resultsqlUser);
$rowsqlUser = mysqli_fetch_array($resultsqlUser);
$name = $rowsqlUser["name"];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลตัวแทนจำหน่าย <?php echo $name; ?></title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    if (isset($_POST['bt-sm-insert'])) {
        $furtype_id = $_POST['furtype_id'];
        $furtype_name = $_POST['furtype_name'];
        $sql_check_furtypeid = "SELECT * FROM furnituretype WHERE furtype_id ='$furtype_id'";
        $result1 = mysqli_query($conn, $sql_check_furtypeid);
        $check_furtypeid = mysqli_num_rows($result1);
        if ($check_furtypeid == 1) {
            echo "<script>
                    Swal.fire({
                        title: 'มีรหัสประเภทสินค้านี้อยู่แล้ว',
                        icon: 'error',
                        confirmButtonColor: '#138D75 ',    
                    confirmButtonText: 'ตกลง',
                    }).then(function() {
                        window.location = 'furtypes.php';
                    });
                    </script>";
        } else {
            $sql_insert = "INSERT INTO furnituretype (furtype_id, furtype_name) 
            VALUES ('$furtype_id','$furtype_name')";
            $result = mysqli_query($conn, $sql_insert);
            if ($result) {
                echo "<script>
                    Swal.fire({
                        title: 'เพิ่มประภทสินค้าสำเร็จ " . $furtype_id . " ',
                        icon: 'success',
                         confirmButtonColor: '#138D75 ',    
                        confirmButtonText: 'ตกลง',
                    }).then(function() {
                        window.location = 'furtypes.php';
                    });
                    </script>";
            }
        }
        mysqli_close($conn);
    }
    ?>
</body>

</html>