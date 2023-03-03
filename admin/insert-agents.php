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
    <link rel="icon" type="image/x-icon" href="../images/iconfurniture.ico">
</head>

<body>
    <?php
    if (isset($_POST['bt-sm-insert'])) {
        $agent_id = $_POST['agent_id'];
        $agent_name = $_POST['agent_name'];
        $agent_phone = $_POST['agent_phone'];
        $sql_check_agentid = "SELECT * FROM agents WHERE agent_id ='$agent_id'";
        $result1 = mysqli_query($conn, $sql_check_agentid);
        $check_agentid = mysqli_num_rows($result1);
        if ($check_agentid == 1) {
            echo "<script>
                    Swal.fire({
                        title: 'มีรหัสร้านตัวแทนจำหน่ายอยู่แล้ว',
                        icon: 'error',
                        confirmButtonColor: '#138D75 ',
                        confirmButtonText: 'ตกลง',
                    }).then(function() {
                        window.location = 'agents.php';
                    });
                    </script>";
        } else {
            $sql_insert = "INSERT INTO agents (agent_id, agent_name, agent_phone) 
            VALUES ('$agent_id','$agent_name','$agent_phone')";
            $result = mysqli_query($conn, $sql_insert);
            if ($result) {
                echo "<script>
                    Swal.fire({
                        title: 'เพิ่มตัวแทนจำหน่ายสำเร็จ " . $agent_id . " ',
                        icon: 'success',
                        confirmButtonColor: '#138D75 ',
                        confirmButtonText: 'ตกลง',
                    }).then(function() {
                        window.location = 'agents.php';
                    });
                    </script>";
            }
        }
        mysqli_close($conn);
    }
    ?>
</body>

</html>