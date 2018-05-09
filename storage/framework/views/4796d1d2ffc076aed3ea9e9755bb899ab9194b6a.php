<!DOCTYPE html>
<html lang="en">
<head>
	<title>Thống kê</title>
	<meta charset="UTF-8">
	<base href="<?php echo e(asset('/')); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="shortcut icon" href="search.ico" />
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-table100">
			<h1>Thống kê từ khóa tìm kiếm tháng <?php echo e($thang); ?></h1>

			<div class="wrap-table100">
					<div class="table" style="text-align: center	">

						<div class="row header" style="text-align: center">
							<div class="cell" style="width: 20%">
								STT
							</div>
							<div class="cell">
								Từ Khóa
							</div>
							<div class="cell" style="width: 20%">
								Số Lượng
							</div>
						</div>
						<?php for($i=0;$i<count($tukhoas);$i++): ?>
						<div class="row">
							<div class="cell" data-title="STT">
								<?php echo e($i+1); ?>

							</div>
							<div class="cell" data-title="Từ khóa">
								<?php echo e($tukhoas[$i]->tukhoa); ?>

							</div>
							<div class="cell" data-title="Số lượng">
								<?php echo e($tukhoas[$i]->soluong); ?>

							</div>
						</div>
						<?php endfor; ?>




					</div>
			</div>
		</div>
	</div>


	

<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>