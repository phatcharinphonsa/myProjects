<?php
if (!$_SESSION['userid']) {
    date_default_timezone_set("Asia/Bangkok");
    header("Location: ../login.php");
}
require('../config/config.php');
?>
<!DOCTYPE html>
<?php

$userid = $_SESSION['userid'];
$sqlUser = "SELECT * FROM users WHERE userid='$userid' ";
$resultsqlUser = mysqli_query($conn, $sqlUser);
$num_rows = mysqli_num_rows($resultsqlUser);
$rowsqlUser = mysqli_fetch_array($resultsqlUser);
$name = $rowsqlUser["name"];

?>

<head>
    <meta charset="UTF-8">
    <!--bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <!-- css -->
    <link rel="stylesheet" href="../css/menu.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        #printable {
            display: none;
        }

        @media print {
            #non-printable {
                display: none;
            }

            #printable {
                display: block;
            }
        }
    </style>
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
    <div class="sidebar" id="non-printable">
        <div class="logo-details">
            <div class="logo_name"><img src="../assets/images/logo1.png" alt="logo" width="150px" height="55px"></div>
            <i class="bx bx-menu" id="btn"></i>
        </div>
        <ul class="nav-list" id="non-printable">
            <li>
                <a href="./index.php">
                    <i class='bx bx-home-alt'></i>
                    <span class="links_name">หน้าแรก</span>
                </a>
                <span class="tooltip">หน้าแรก</span>
            </li>
            <li>
                <a href="./users.php">
                    <i class='bx bx-user'></i>
                    <span class="links_name">จัดการผู้ใช้</span>
                </a>
                <span class="tooltip">จัดการผู้ใช้</span>
            </li>
            <li>
                <a href="./agents.php">
                    <i class='bx bxs-store'></i>
                    <span class="links_name">จัดการร้านตัวแทน</span>
                </a>
                <span class="tooltip">จัดการร้านตัวแทน</span>
            </li>

            <li>
                <a href="./furtypes.php">
                    <i class='bx bxs-cube'></i>
                    <span class="links_name">จัดการประเภทสินค้า</span>
                </a>
                <span class="tooltip">จัดการประเภทสินค้า</span>
            </li>
            <li>
                <a href="./furnitures.php">
                    <i class='bx bx-cabinet'></i>
                    <span class="links_name">จัดการสินค้า</span>
                </a>
                <span class="tooltip">จัดการสินค้า</span>
            </li>
            <li>
                <a href="./customers.php">
                    <i class='bx bxs-user-detail'></i>
                    <span class="links_name">จัดการข้อมูลลูกค้า</span>
                </a>
                <span class="tooltip">จัดการข้อมูลลูกค้า</span>
            </li>
            <li>
                <a href="./report-order-list.php">
                    <i class='bx bx-shopping-bag'></i>
                    <span class="links_name">สั่งซื้อสินค้า</span>
                </a>
                <span class="tooltip">สั่งซื้อสินค้า</span>
            </li>
            <li>
                <a href="./report-sale-delivery.php">
                    <i class='bx bx-package'></i>
                    <span class="links_name">ขายสินค้า</span>
                </a>
                <span class="tooltip">ขายสินค้า</span>
            </li>

            <li>
                <a href="./report.php">
                    <i class='bx bx-notepad'></i>
                    <span class="links_name">รายงานใบสั่งซื้อ</span>
                </a>
                <span class="tooltip">รายงานใบสั่งซื้อ</span>
            </li>
            <li>
                <a href="./report1.php">
                    <i class='bx bxs-report'></i>
                    <span class="links_name">รายงานใบขาย</span>
                </a>
                <span class="tooltip">รายงานใบขาย</span>
            </li>


            <li class="profile">
                <div class="profile-details">
                    <div class="name_job">
                        <div class="name">
                            <?php echo $name; ?>
                        </div>
                        <div class="job">

                        </div>
                    </div>
                </div>
                <a href="../php/login.php" class="links_name"><i class='bx bx-exit' id="log_out"></i></a>
                <span class="tooltip">ออกจากระบบ</span>

            </li>
        </ul>
    </div>

    <script>
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");
        let searchBtn = document.querySelector(".bx-search");

        closeBtn.addEventListener("click", () => {
            sidebar.classList.toggle("open");
            menuBtnChange(); //calling the function(optional)
        });
    </script>
</body>

</html>