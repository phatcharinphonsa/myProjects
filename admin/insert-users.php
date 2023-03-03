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
    <title>เพิ่มข้อมูลผู้ใช้งาน <?php echo $name; ?></title>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    if (isset($_POST['bt-sm-insert'])) {
        $userid = $_POST['userid'] ?? '';
        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $status = isset($_POST['status']) ? $_POST['status'] : 1;
        if (!isset($_POST['status'])) {
            $status = 1;
        }
        $sql_check_userid = "SELECT * FROM users WHERE userid='$userid'";
        $result1 = mysqli_query($conn, $sql_check_userid);
        $check_userid = mysqli_num_rows($result1);
        if ($check_userid == 1) {
            echo "<script>
                    Swal.fire({
                        title: 'มีชื่อผู้ใช้นี้อยู่แล้ว',
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#138D75',
                    }).then(function() {
                        window.location = 'users.php';
                    });
                    </script>";
        } else {
            $sql_insert = "INSERT INTO users (userid, name, password, address, phone, status ) 
            VALUES ('$userid','$name','$password','$address','$phone','1')";
            $result = mysqli_query($conn, $sql_insert);
            if ($result) {
                echo "<script>
                    Swal.fire({
                        title: 'สมัครสมาชิกสำเร็จ คุณ" . $name . " ',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                        confirmButtonColor: '#138D75',
                    }).then(function() {
                        window.location = 'users.php';
                    });
                    </script>";
            }
        }
        mysqli_close($conn);
    }
    ?>
</body>

</html>