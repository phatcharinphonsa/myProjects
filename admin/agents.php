<?php
session_start();
if (!$_SESSION['userid']) {
    header("Location: ../login.php");
}
include "./menu.php";
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
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
    <title>จัดการข้อมูลร้านตัวแทนจำหน่าย โดย <?php echo $name; ?></title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03typeR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1typeK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <!-- datatable -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- highchart -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/data.js"></script>
    <script src="https://code.highcharts.com/modules/drilldown.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</head>
<script>
    $(document).ready(function() {
        $("#myTable").DataTable({
            "language": {
                "sLengthMenu": "แสดง _MENU_ เร็คคอร์ด",
                "search": " ค้นหา : ",
                "zeroRecords": "ไม่พบข้อมูลที่ค้นหา",
                "info": "แสดงผลลัพธ์ _PAGE_ จาก _PAGES_ หน้า",
                "infoEmpty": "ไม่พบตารางที่ค้นหา",
                "infoFiltered": "(ค้นหาจากทั้งหมด_MAX_ตาราง)",
                "searchPlaceholder": "",
                "paginate": {
                    "previous": "ก่อนหน้า",
                    "next": "หน้าถัดไป",

                }
            }
        });
    });
</script>

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
    <section class="home-section justify-center mt-5">
        <div class="con">
            <h3>ข้อมูลร้านตัวแทนจำหน่าย
                <button type="button" class="btn btn-success" data-bs-toggle='modal' data-bs-target="#insertModal">
                    เพิ่มร้านตัวแทนจำหน่าย
                </button>
            </h3>
            <div class="table-responsive">
                <table id="myTable" class="display" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width:5%" class="text-center">ลำดับ</th>
                            <th>รหัสร้านตัวแทนจำหน่าย</th>
                            <th>ชื่อร้านตัวแทนจำหน่าย</th>
                            <th>เบอร์โทรศัพท์</th>
                            <th>แก้ไข</th>
                            <th>ลบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $sql =
                            "SELECT agents.agent_id, agents.agent_name, agents.agent_phone FROM agents  ORDER BY agent_id DESC";
                        $rs = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($rs)) {
                        ?>
                            <tr>
                                <td style="width:5%" class="text-center">
                                    <?php echo $i; ?>
                                </td>
                                <td>
                                    <?php echo $row['agent_id']; ?>
                                </td>
                                <td>
                                    <?php echo $row['agent_name']; ?>
                                </td>
                                <td>
                                    <?php echo $row['agent_phone']; ?>
                                </td>
                                <td>
                                    <a href='./edit-agents.php?agent_id=<?php echo $row['agent_id']; ?>'>
                                        <button type='button' class='btn btn-warning edit_btn' style='margin-right: 5px;'>
                                            <i class='bx bx-edit'></i>
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href='?action=delete&agent_id=<?php echo $row['agent_id']; ?>'>
                                        <button type='button' class='btn btn-danger'>
                                            <i class='bx bx-eraser'></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </section>

    <!-- Modal add agent -->
    <div class="modal fade mt-5" id="insertModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" enctype="multipart/form-data" class="modal-content" action="./insert-agents.php">
                <div class="modal-content">
                    <div class="modal-header">
                        <p class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลร้านตัวแทนจำหน่าย</p>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label class="mb-1">รหัสร้านตัวแทนจำหน่าย</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="agent_id" id="agent_id" maxlength="7" required>
                        </div>
                        <label class="mb-1">ชื่อร้านตัวแทนจำหน่าย</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="agent_name" id="agent_name" required>
                        </div>
                        <label class="mb-1">เบอร์โทรศัพท์</label>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="agent_phone" id="agent_phone" pattern="0[0-9]{9}" maxlength="10" OnKeyPress="return chkNumber(this)" required>
                        </div>
                        <script language="JavaScript">
                            function chkNumber(ele) {
                                var vchar = String.fromCharCode(event.keyCode);
                                if ((vchar < '0' || vchar > '9') && (vchar != '.')) return false;
                                ele.onKeyPress = vchar;
                            }
                        </script>
                    </div>
                    <div class="text-center mb-4">
                        <button type="submit" class="btn btn-success" name="bt-sm-insert">ยืนยัน</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>

                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- Delete agents -->
    <?php
    if (isset($_GET['action']) && $_GET['action'] == 'delete') {
        $agent_id = $_GET['agent_id'];
        echo "<script>";
        echo "
        Swal.fire({
            title: 'คุณต้องการลบ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#138D75 ',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'agents.php?action=confirm&agent_id=" . $agent_id . "'
            }else{
                window.location.href = 'agents.php'
            }
        })
        ";
        echo "</script>";
    }
    if (isset($_GET['action']) && $_GET['action'] == 'confirm') {
        $agent_id = $_GET['agent_id'];
        $sql = "DELETE FROM `agents` WHERE `agent_id`='$agent_id'";
        $rs = mysqli_query($conn, $sql);
        if ($rs) {
            echo "<script>
                Swal.fire({
                    title: 'ลบสำเร็จ',
                    icon: 'success',
                    confirmButtonColor: '#138D75 ',
                    confirmButtonText: 'ตกลง',
                }).then(function() {
                    window.location = 'agents.php';
                });
                </script>";
        }
    }
    ?>
</body>

</html>