<?php
session_start();
include("config/config.php");
?>
<!doctype html>
<html lang="en">

<head>
    <title>เข้าสู่ระบบ</title>
    <link rel="icon" type="image/x-icon" href="./images/iconfurniture.ico">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-12 col-lg-10">
                    <div class="wrap d-md-flex">
                        <div class="img" style="background-image: url(images/room.png);">
                        </div>
                        <div class="login-wrap p-4 p-md-5 mb-2">
                            <div><img src="images/logo1.png" height="80" alt="logo">
                            </div>
                            <div class="d-flex">
                                <div class="w-100">
                                    <h5 class="mb-4 mt-3">ยินดีต้อนรับเข้าสู่ระบบ</h5>
                                </div>
                            </div>
                            <form action=".\php\login.php" method="post" class="signin-form">
                                <div class="form-group mb-3">
                                    <label class="label" for="name">ชื่อผู้ใช้</label>
                                    <input type="text" class="form-control" id="userid" name="userid" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="label" for="password">รหัสผ่าน</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-100 text-left">
                                        <label class="checkbox-wrap checkbox-primary mb-0">จดจำชื่อผู้ใช้ รหัสผ่าน
                                            <input type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">เข้าสู่ระบบ
                                    </button>
                                </div>
                            </form>
                            <div class="mb-5"> </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src=" js/jquery.min.js">
    </script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>