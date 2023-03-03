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
    <title>เพิ่มข้อมูลลูกค้า <?php echo $name; ?></title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    if (isset($_POST['bt-sm-insert'])) {
        $cus_id = $_POST['cus_id'];
        $cus_name = $_POST['cus_name'];
        $cus_phone = $_POST['cus_phone'];
        $cus_add = $_POST['cus_add'];
        $sql_check_cusid = "SELECT * FROM customers WHERE cus_id ='$cus_id'";
        $result1 = mysqli_query($conn, $sql_check_cusid);
        $check_cusid = mysqli_num_rows($result1);
        if ($check_cusid == 1) {
            echo "<script>
                    Swal.fire({
                        title: 'มีชื่อผู้ใช้นี้อยู่แล้ว',
                        icon: 'error',
                         confirmButtonColor: '#138D75 ',    
                    confirmButtonText: 'ตกลง',
                    }).then(function() {
                        window.location = 'customers.php';
                    });
                    </script>";
        } else {
            $sql_insert = "INSERT INTO customers (cus_id, cus_name, cus_phone, cus_add) 
            VALUES ('$cus_id','$cus_name','$cus_phone','$cus_add')";
            $result = mysqli_query($conn, $sql_insert);
            if ($result) {
                echo "<script>
                    Swal.fire({
                        title: 'เพิ่มตัวแทนจำหน่ายสำเร็จ " . $cus_id . " ',
                        icon: 'success',
                         confirmButtonColor: '#138D75 ',    
                    confirmButtonText: 'ตกลง',
                    }).then(function() {
                        window.location = 'customers.php';
                    });
                    </script>";
            }
        }
        mysqli_close($conn);
    }
    ?>
</body>

</html>