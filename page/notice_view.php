<!DOCTYPE HTML>
<html lang="en">
<? 
	$NO_LOGIN = "Y";
?>
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
            <h2>Help Desk</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<? include "./inc_help_nav.php"; ?>

	<section class="alazea-blog-area mt-30">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2><font color="#ff3399">New</font> & Event</h2>
					<p>카페핸즈의 소식과 다양한 이벤트를 알려드립니다.</p>
				</div>			
			</div>

            <div class="row mb-5">				
				<div class="col-12 col-md-12">
					<?
					$rowNotice = db_select("select * from tbl_notice where notice_id='{$_GET['notice_id']}'");
					?>
					<div class="p-3 border-box">
						<div class="notice-title">
							<p class="mb-2 fs--1 color-7"><?=date("Y.m.d",strtotime($rowNotice['regdate']))?></p>
							<h6 class="mb-3 color-3 fs-0 fw-500"><?=$rowNotice['subject']?></h6>
						</div>
						<div class="notice-content mt-3">
							<p class="fs-005"><?=$rowNotice['content']?></p>
						</div>
					</div>
					<div class="my-3">
						<a href="notice.php" class="btn-block btn btn-info fs-0">목록보기</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_main.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="notice"]').addClass('active');
</script>
</html>