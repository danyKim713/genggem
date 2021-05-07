<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<?
$_TITLE = "가맹점 이용안내";
?>
<body>
	<? include "./inc_Top.php"; ?>
		<section class="py-0">
			<div class="container-fluid header-top">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
						<ul>
							<li>
								<img src="assets/images/f-guide1.jpg" alt="가맹점 이용안내 이미지1" />
							</li>
							<li>
								<img src="assets/images/f-guide2.jpg" alt="가맹점 이용안내 이미지2" />
							</li>
							<li>
								<img src="assets/images/f-guide3.jpg" alt="가맹점 이용안내 이미지3" />
							</li>
							<li>
								<img src="assets/images/f-guide4.jpg" alt="가맹점 이용안내 이미지4" />
							</li>
						</ul>
					</div>
				</div>
			</div>

			<div class="m-3">
				<a href="franchise_list.php" title="가맹점 목록 바로가기" class="btn-block btn btn-primary fs-0">가맹점 목록보기</a>
				<a href="franchise_add.php" title="가맹신청 바로가기" class="btn-block btn btn-outline-secondary fs-0">가맹 신청하기</a>
			</div>
		</section>
		<? include "./inc_Bottom.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>