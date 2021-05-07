<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[Crypto_send_title];
?>

<body>
	<header class="header">
		<h2 class="header-title text-center">암호화폐 전송완료</h2>
	</header>
	<section class="py-0">
		<div class="container">
			<div class="row align-items-center justify-content-center text-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-4 mt-xl-6 mt-4">
					<span class="icon ic-verified color-primary fs-2"></span>
					<!--전송코인 표시-->
					<p class="mt-2"><?=strtoupper($_SESSION['cs_coin'])?>를 전송하였습니다.</p>
					<div class="text-left border-box p-3 mb-2 fs-005">
						<ul>
							<li class="row">
								<div class="col-4 color-6">전송일시</div>
								<div class="col-8 text-right fs--1 color-7"><?=date("Y-m-d H:i:s")?></div>
							</li>
							<li class="row mt-2">
								<!--또는 빗코엑스 ID-->
								<div class="col-12 color-6">받는사람</div>
								<div class="col-12 font-2 lh-2 my-2"><?=$_SESSION['cs_receiver_type']=="email"?$_SESSION['cs_email']:$_SESSION['cs_address']?></div>
							</li>
							<li class="row mt-2">
								<div class="col-4 color-6">보유 <?=strtoupper($_SESSION['cs_coin'])?></div>
								<div class="col-8 text-right font-2"><?=소수n자리까지표시($_SESSION['cs_보유금액'],4)?></div>
							</li>
							<li class="row mt-2 color-primary fw-600">
								<div class="col-4">전송 <?=strtoupper($_SESSION['cs_coin'])?></div>
								<div class="col-8 text-right font-2"><?=($_SESSION['cs_amount'])?></div>
							</li>
							<li class="row mt-2">
								<div class="col-4 color-6">수수료</div>
								<div class="col-8 text-right font-2"><?=소수n자리까지표시($_SESSION['cs_총수수료'],4)?></div>
							</li>

						</ul>
						<hr class="color-10 border-dashed">
						<div class="row">
							<div class="col-5">전송 후 <?=strtoupper($_SESSION['cs_coin'])?></div>
							<div class="col-7 text-right font-2"><?=소수n자리까지표시($_SESSION['cs_전송후금액'],4)?></div>
						</div>
					</div>
					<a href="crypto_send_history.php" class="btn-block btn btn-info fs-0">암호화폐 전송내역보기</a>
				</div>
			</div>
		</div>
	</section>

	<? include "./inc_Bottom.php"; ?>
</body>

</html>