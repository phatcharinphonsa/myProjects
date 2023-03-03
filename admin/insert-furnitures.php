<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
require('../config/config.php');
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
        $fur_id = $_POST['fur_id'];
        $fur_name = $_POST['fur_name'];
        $fur_price = $_POST['fur_price'];
        $fur_sale = $_POST['fur_sale'];
        $furtype_id = $_POST['furtype_id'];
        $amount = isset($_POST['amount']) ? $_POST['amount'] : 0; // Set default value to 0 if not provided
        $sql_check_furid = "SELECT * FROM furniture WHERE fur_id ='$fur_id'";
        $result1 = mysqli_query($conn, $sql_check_furid);
        $check_furid = mysqli_num_rows($result1);
        if ($check_furid == 1) {
            echo "<script>
                    Swal.fire({
                        title: 'มีรหัสสินค้านี้อยู่แล้ว',
                        icon: 'error',
                         confirmButtonColor: '#138D75 ',    
                    confirmButtonText: 'ตกลง',
                    }).then(function() {
                        window.location = 'furnitures.php';
                    });
                    </script>";
        } else {
            $sql_insert = "INSERT INTO furniture (fur_id, fur_name, fur_price, fur_sale, furtype_id, amount) 
            VALUES ('$fur_id','$fur_name','$fur_price','$fur_sale','$furtype_id','$amount')";
            $result = mysqli_query($conn, $sql_insert);
            if ($result) {
                echo "<script>
                    Swal.fire({
                        title: 'เพิ่มสินค้าสำเร็จ " . $fur_id . " ',
                        icon: 'success',
                    }).then(function() {
                        window.location = 'furnitures.php';
                    });
                    </script>";
            }
        }
        mysqli_close($conn);
    }
    ?>
</body>

</html>