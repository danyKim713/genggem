<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<?php 
$NO_LOGIN = true;
include "./inc_program.php";
?>
<body>
	<header class="header top_fixed">
		<h2 class="header-title text-center"><?=$dic['ID_search_title']?></h2>
	</header>
	<section class="py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center text-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-4">
<? if($_SESSION['_found_email']){?>
					<div>
						<h3 class="fs-005 fw-300 lh-5"><!-- <strong>0100000000</strong><br> --><?=$dic['Matching_memberinfo']?></h3>
						<p class="mt-3 color-primary fw-600"><?=$_SESSION['_found_email']?></p>
					</div>
					<div class="mt-5">
						<a href="login.php" class="btn-block btn btn-secondary fs-005"><?=$dic['Login']?></a>
						<a href="user_pw.php" class="btn-block btn btn-outline-secondary fs-005"><?=$dic['Login_pwr']?></a>
					</div>
  <?}else{?>
					<!--일치하는 아이디가 없을때-->
					<div>
						<h3 class="fs-005 fw-300 lh-5"><!-- <strong>0100000000</strong><br> --><?=$dic['No_matching_memberinfo']?></h3>
					</div>
					<div class="mt-5">
						<a href="user_id.php" class="btn-block btn btn-secondary fs-005"><?=$dic['Login_fogot_ID']?></a>
						<a href="join.php" class="btn-block btn btn-outline-secondary fs-005"><?=$dic['Login_join']?></a>
					</div>
					<!--일치하는 아이디가 없을때 end -->
<?}?>
				</div>
			</div>
		</div>
	</section>

  <?// include "./inc_Bottom.php"; ?>
</body>

</html>