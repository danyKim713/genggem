<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<?
$_TITLE = 코치등록신청;
?>
<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>


	<!-- ##### category Area Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h2>아티스트 등록</h2>
				</div>				
			</div>

			<div class="container-fluid mb-5">
				<div class="align-items-center text-center justify-content-center">
					<div class="col-sm-12 col-lg-12 px-4">
						<p class="mt-5 mb-5 fs-005 fw-500"><?=$rowMember['name']?>회원님.<br>
						아티스트 등록신청 해 주셔서 감사드립니다.<br>
						담당자 확인 후 다음 절차로 진행됩니다. <br>
						감사합니다.</p>
						<a href="class_contents.php" class="btn-block btn btn-lightgray fs-005">클래스 홈</a>
					</div>
				</div>
			</div>
		</div>
	</section>

<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="artistapply"]').addClass('active');
</script>
</html>