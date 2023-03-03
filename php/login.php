<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | Hod-Q</title>
    <link rel="icon" type="image/x-icon" href="./assets/images/logo_icon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/login.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    if (isset($_POST['userid'])) {
        include("../config/config.php");
        $userid = $_POST["userid"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM users WHERE userid ='$userid' AND password ='$password'";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        if ($num_rows == 1) {
            $row = mysqli_fetch_array($result);
            $_SESSION['userid'] = $row["userid"];
            $_SESSION['password'] = $row["password"];
            $_SESSION['status'] = $row["status"];

            if ($_SESSION['status'] == '0') {
                header("Location: ../admin/index.php");
            }
            if ($_SESSION['status'] == '1') {
                header("Location: ../employee/index.php");
            }
        } else {
            echo "<script>";
            echo "Swal.fire({
                icon: 'error',
                title: 'ชื่อผู้ใช้ รหัสผ่านไม่ถูกต้อง',
                text: 'กรุณาลองใหม่อีกครั้ง',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#138D75',
            }).then(() => {
                window.history.back();
            });";
            echo "</script>";
        }
    } else {
        header("Location: ../login.php");
    }
    ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.1.js"></script>

</html>