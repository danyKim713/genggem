<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<?
$query = "select * from tbl_store_payment A, tbl_store B where A.pk_store_payment = '{$_SESSION['pk_store_payment']}' and A.store_id = B.store_id";
$rowStore = db_select($query);
?>

<body>
	<header class="header">
		<h2 class="header-title text-center">가맹점 결제완료</h2>
	</header>
	<section class="py-0">
		<div class="container">
			<div class="row align-items-center justify-content-center text-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-4 mt-xl-6 mt-4">
					<span class="icon ic-verified color-primary fs-2"></span>
					<p class="mt-2">결제가 성공적으로 이루어졌습니다.</p>
					<div class="text-left border-box p-3 mb-2 fs-005">
						<ul>
							<li class="row">
								<div class="col-4 color-6">결제일시</div>
								<div class="col-8 text-right fs--1 color-7"><?=$rowStore['결제일시']?></div>
							</li>
							<!--UID 전송-->
							<li class="row mt-2">
								<div class="col-6 color-6">결제상점 UID</div>
								<div class="col-6 text-right font-2"><?=$rowStore['store_code']?></div>
							</li>
							<!--또는 빗코엑스 ID 전송 -->
							<li class="row mt-2">
								<div class="col-6 color-6">결제 상점명</div>
								<div class="col-6 text-right font-2"><?=$rowStore['store_name']?></div>
							</li>
							<li class="row mt-2 color-primary fw-600">
								<div class="col-6">결제한 금액</div>
								<div class="col-6 text-right font-2"><?=$rowStore['코인결제금액']?> <small><?=$rowStore['결제코인']?></small></div>
							</li>
							<li class="row mt-2 color-primary fw-600">
								<div class="col-12 text-right font-2">(<?=number_format($rowStore['원화결제금액'])?> <small>won</small>)</div>
							</li>
						</ul>
						<hr class="color-10 border-dashed">
						<div class="row">
							<div class="col-6">적립포인트</div>
							<div class="col-6 text-right font-2">&#40;+&#41; <span class=""><?=number_format($rowStore['적립포인트'])?></span> <small><?=$rowStore['결제코인']?></small></div>
						</div>
					</div>
					<a href="biko_payment_history.php" class="btn-block btn btn-info fs-0">가맹점 결제 내역보기</a>
				</div>
			</div>
		</div>
	</section>

	<? include "./inc_Bottom.php"; ?>
</body>

</html>