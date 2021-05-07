<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<?
$_TITLE = "PAY 이용안내";
?>
<body>
	<? include "./inc_Top.php"; ?>
		<section class="py-0">
			<div class="container-fluid header-top">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
						<ul>
							<li>
								<img src="assets/images/pay-guide1.jpg" alt="pay 이용안내" />
							</li>
							<li>
								<img src="assets/images/pay-guide2.jpg" alt="pay 이용안내" />
							</li>

						</ul>
					</div>
				</div>
			</div>
			<div class="m-3">
				<a href="exchange_login.php" title="거래소 로그인" class="btn-block btn btn-primary fs-0">거래소 로그인</a>
				<a href="wallet.php" title="내 지갑" class="btn-block btn btn-outline-secondary fs-0">내 지갑보기</a>
			</div>
		</section>
		<? include "./inc_Bottom.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>