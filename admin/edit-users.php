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
    <title>แก้ไขข้อมูลผู้ใช้งาน โดย <?php echo $name; ?></title>
    <link rel="icon" type="image/x-icon" href="../assets/images/logo1.png">
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link rel="stylesheet" href="../css/admin_edit_staff.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php if (isset($_SESSION["process_success"])) : ?>
        <div class="alert alert-success">
            <?php echo $_SESSION["process_success"];
            unset($_SESSION["process_success"]);
            ?>

        </div>
    <?php elseif (isset($_SESSION["process_error"])) : ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION["process_error"];
            unset($_SESSION["process_error"]);
            ?>
        </div>
    <?php endif ?>
    <?php
    $userid = isset($_GET['userid']) ? mysqli_real_escape_string($conn, $_GET['userid']) : "";
    $sqlQuery = "SELECT * FROM users WHERE userid = '$userid'";
    $result = mysqli_query($conn, $sqlQuery);
    $data = mysqli_fetch_array($result);
    ?>
    <div class="wrapper">
        <h2>แก้ไขข้อมูลผู้ใช้งาน</h2>
        <form method="POST" enctype="multipart/form-data" action="#">
            <label class="mb-1">ชื่อผู้ใช้งาน</label>
            <div class="input-box">
                <input class="form-control" type="text" id="userid" name="userid" value="<?php echo $data["userid"]; ?>" required disabled>
                <input class="form-control" type="hidden" id="userid" name="userid" value="<?php echo $data['userid']; ?>">
            </div>
            <label class="mb-1">รหัสผ่าน</label>
            <div class="input-box">
                <input class="form-control" type="password" id="password" name="password" value="<?php echo $data["password"]; ?>" required>
            </div>
            <label class="mb-1">ชื่อ นามสกุล</label>
            <div class="input-box">
                <input class="form-control" type="text" id="name" name="name" value="<?php echo $data["name"]; ?>" required>
            </div>
            <label class="mb-1">เบอร์โทรศัพท์</label>
            <div class="input-box">
                <input class="form-control" type="text" id="phone" name="phone" value="<?php echo $data["phone"]; ?>" pattern="0[0-9]{9}" maxlength="10" OnKeyPress="return chkNumber(this)" required>
            </div>
            <label class="mb-1">ที่อยู่</label>
            <div class="input-box">
                <input class="form-control" type="text" id="address" name="address" value="<?php echo $data["address"]; ?>" required>
            </div>
            <script language="JavaScript">
                function chkNumber(ele) {
                    var vchar = String.fromCharCode(event.keyCode);
                    if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
                    ele.onKeyPress = vchar;
                }
            </script>

            <div class="input-box button text-center">
                <button type="submit" class="btn btn-success" name="edt">ตกลง</button>
                <a href="./users.php">
                    <button type="button" class="btn btn-danger">ยกเลิก</button>
                </a>
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['edt'])) {
        $userid = $_POST['userid'] ?? '';
        $name = $_POST['name'] ?? '';
        $password = $_POST['password'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $status = isset($_POST['status']) ? $_POST['status'] : 1;
        if (!isset($_POST['status'])) {
            $status = 1;
        }
        $sql_edit = "UPDATE users SET 
            name ='$name',
            password ='$password',
            address ='$address',
            phone ='$phone',
            status ='$status'
            WHERE userid ='$userid'
            ";
        $result = mysqli_query($conn, $sql_edit);
        if ($result) {
            echo "<script>
            Swal.fire({
                title: 'แก้ไขสำเร็จ',
                icon: 'success',
                confirmButtonText: 'ตกลง',
                confirmButtonColor: '#138D75',
            }).then(function() {
                window.location = './users.php';
            });
            </script>";
        } else {
            echo mysqli_error($conn);
        }
    }
    ?>
</body>

</html>