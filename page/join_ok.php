<!DOCTYPE HTML>
<html lang="en">
<?php 
$NO_LOGIN = true;
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

	<body>
		<section class="wrap-join py-0">
			<div class="container-fluid">
				<div class="row align-items-center justify-content-center text-center">
					<div class="col-sm-10 col-lg-6 col-xl-3 my-8 mx-3">
						<div>
							<h3 class="fs-1 lh-3 fw-100"><?=$dic['Biko_join_ok']?><br><strong class="fw-600"><?=$dic['Biko_join_ok2']?></strong></h3>
							<p class="color-5 mt-4 fs-005"><?=$dic['After_login']?></p>
						</div>
						<div class="mt-6">
							<a href="login.php" class="btn-block btn btn-secondary mb-3 fs-0"><?=$dic['Login']?></a>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?// include "./inc_Bottom.php"; ?>
	</body>

</html>