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
$sqlSumPrice = "SELECT SUM(total_price) FROM `order`";
$sqlSaleSumPrice = "SELECT SUM(total_price) FROM `sale`";
$sqlCountSale = "SELECT COUNT(saleID) FROM `sale`";
$resultsqlUser = mysqli_query($conn, $sqlUser);
$rsSumPrice = mysqli_query($conn, $sqlSumPrice);
$rsSaleSumPrice = mysqli_query($conn, $sqlSaleSumPrice);
$rsCountSale = mysqli_query($conn, $sqlCountSale);
$num_rows = mysqli_num_rows($resultsqlUser);
$rowsqlUser = mysqli_fetch_array($resultsqlUser);
$rowSumPrice = mysqli_fetch_row($rsSumPrice);
$rowSaleSumPrice = mysqli_fetch_row($rsSaleSumPrice);
$rowCountSale = mysqli_fetch_row($rsCountSale);
$name = $rowsqlUser["name"];
?>
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
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../assets/css/admin_staff.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<link rel="stylesheet" type="text/css" href="../css/index.css">
	<title>หน้าแรก <?php echo $name; ?></title>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/data.js"></script>
	<script src="https://code.highcharts.com/modules/drilldown.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<script src="https://code.highcharts.com/modules/accessibility.js"></script>
	<script>
		function getOrder(id) {
			$(".oderId").text(id)
			$(".btn-success").val(Number(id))
			console.log(id);
			console.log($(".oderId").text())
			console.log($(".btn-success").val())
		}
	</script>
</head>

<body>
	<section class="home-section">
		<div class="home-content">
			<div class="text-center">
				<img src="../images/logo1.png" height="100">
			</div>
			<div class="sales-boxes mb-5">
				<div class="recent-sales box ">
					<h5 class="mt-5">สินค้าคงเหลือ</h5>
					<div class="table-responsive">
						<table class="table" style="width: 100%;">
							<thead class="table-dark">
								<tr>
									<th class="text-center">#</th>
									<th>รายการสินค้า</th>
									<th class="text-center">คงเหลือ</th>
									<th class="text-right">ราคาต่อชิ้น</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$sum = 0;
								$sql = "SELECT * FROM furniture ORDER BY fur_id";
								$rs = mysqli_query($conn, $sql);
								while ($row = mysqli_fetch_array($rs)) {
									$sum = $row['amount'] * $row['fur_sale'];
								?>
									<tr>
										<td style="width:5%" class="text-center">
											<?php echo $i; ?>
										</td>
										<td><?php echo $row['fur_name']; ?></td>
										<td class="text-center"><?php echo $row['amount']; ?></td>
										<td class="text-right"><?php echo number_format($row['fur_sale'], 2); ?></td>
									<?php
									$i++;
								}
									?>
									</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="top-sales box ">
					<img src="../images/room.png" width="500" >
				</div>
			</div>

		</div>
	</section>
</body>
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

</html>