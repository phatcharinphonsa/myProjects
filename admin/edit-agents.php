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
    <title>แก้ไขข้อมูลร้านตัวแทน โดย </title>
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
    $agent_id = isset($_GET['agent_id']) ? mysqli_real_escape_string($conn, $_GET['agent_id']) : "";
    $sqlQuery = "SELECT * FROM agents WHERE agent_id = '$agent_id'";
    $result = mysqli_query($conn, $sqlQuery);
    $data = mysqli_fetch_array($result);
    ?>
    <div class="wrapper">
        <h2>แก้ไขข้อมูลตัวแทนจำหน่าย</h2>
        <form method="POST" enctype="multipart/form-data" action="#">
            <label class="mb-1">รหัสตัวแทนจำหน่าย</label>
            <div class="input-box">
                <input class="form-control" type="text" id="agent_id" name="agent_id" value="<?php echo $data["agent_id"]; ?>" required disabled>
                <input class="form-control" type="hidden" id="agent_id" name="agent_id" value="<?php echo $data['agent_id']; ?>">
            </div>
            <label class="mb-1">ชื่อตัวแทนจำหน่าย</label>
            <div class="input-box">
                <input class="form-control" type="text" id="agent_name" name="agent_name" value="<?php echo $data["agent_name"]; ?>" required>
            </div>
            <label class="mb-1">เบอร์โทรศัพท์</label>
            <div class="input-box">
                <input class="form-control" type="text" id="agent_phone" name="agent_phone" value="<?php echo $data["agent_phone"]; ?>" pattern="0[0-9]{9}" maxlength="10" OnKeyPress="return chkNumber(this)" required>
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
                <a href="./agents.php">
                    <button type="button" class="btn btn-danger">ยกเลิก</button>
                </a>
            </div>
        </form>
    </div>
    <?php
    if (isset($_POST['edt'])) {
        $agent_id = $_POST['agent_id'];
        $agent_name = $_POST['agent_name'];
        $agent_phone = $_POST['agent_phone'];
        $sql_edit = "UPDATE agents SET 
        agent_name ='$agent_name',
        agent_phone ='$agent_phone'
        WHERE agent_id ='$agent_id'
        ";
        $result = mysqli_query($conn, $sql_edit);
        if ($result) {
            echo "<script>
                Swal.fire({
                    title: 'แก้ไขสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#138D75 ',
                    confirmButtonText: 'ตกลง',
                }).then(function() {
                    window.location = './agents.php';
                });
                </script>";
        } else {
            echo "<script>
                Swal.fire({
                    title: 'แก้ไขไม่สำเร็จ',
                    text: '" . mysqli_error($conn) . "',
                    icon: 'error',
                    confirmButtonColor: '#138D75 ',
                    confirmButtonText: 'ตกลง',
                });
                </script>";
        }
    }
    ?>
</body>

</html>