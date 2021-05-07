<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<?
$_TITLE = $dic[Service_crypto];
?>
<body class="light-crypto">
	<? include "./inc_Top.php"; ?>
	<section class="wrap-crypto py-0">
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<div class="crypto-wallet d-flex text-center">
						<div class="crypto-wallet-box">
							<h4 class="tlt-coin">BTC wallet</h4>
							<p class="text-count mb-0 font-2">213,545.0000</p>
						</div>
						<div class="crypto-wallet-box">
							<h4 class="tlt-coin">BKC 평가액</h4>
							<p class="text-count mb-0 font-2">213,545.0000</p>
						</div>
						<div class="crypto-wallet-box">
							<h4 class="tlt-coin">BKC 보유수량</h4>
							<p class="text-count mb-0 font-2">213,545.0000</p>
						</div>
					</div>

					<section class="crypto-box m-2">
						<div class="position-ab btn-right-top">
							<label class="form-switch">
								Day <input type="checkbox"/><i></i>Night
							</label>
						</div>
						<div class="text-center p-3">
							<h2 class="fs-1"><img src="assets/images/logos/btc.png" width="24" class="mr-1"> Bitcoin<span class="bar opacity-75"></span>BTC</h2>
							<div class="btn-group my-1">
								<input id="buying" value="buying" name="transaction" type="radio" class="invisible" checked>
								<label for="buying" class="fs-005 btn btn-xs mb-0">Buy</label>
								<input id="selling" value="selling" name="transaction" type="radio" class="invisible">
								<label for="selling" class="fs-005 btn btn-xs mb-0">Sell</label>
							</div>
							<div class="row mt-3 text-center">
								<div class="col-6 pr-0">
									<label class="mr-1">시장가격</label>
									<span class="font-2 fs-005 color-success">6,335.843 <small>BKC</small></span>
								</div>
								<div class="col-6 pl-0">
									<label class="mr-1">시장수량</label>
									<span class="font-2 fs-005 color-success">1.1234 <small>BTC</small></span>
								</div>
							</div>
						</div>
						<div class="crypto-exchange px-3 py-4">
							<div class="form-group row align-items-center">
								<label class="col-4 fs-005 fw-200">Amount</label>
								<div class="col-8">
									<div class="d-flex">
										<input type="number" name="" id="" class="form-control input-sm text-right" placeholder="Min 0.0001BTC" />
										<button type="button" class="btn-apply btn btn-xs p-1 ml-1 radius-2">Apply</button>
									</div>
								</div>
							</div>
							<hr />
							<div class="row">
								<label class="col-5 fs-005 fw-200">매수 금액</label>
								<div class="col-7 text-right">
									<span class="fw-600 font-2">0.000 <span class="fw-100 fs--1">BKC</span></span>
								</div>
							</div>
							<div class="row">
								<label class="col-5 fs-005 fw-200">수수료</label>
								<div class="col-7 text-right">
									<span class="fw-600 font-2">0.000 <span class="fw-100 fs--1">BKC</span></span>
								</div>
							</div>
							<div class="row my-2">
								<label class="col-5 fs-005">Total amount</label>
								<div class="col-7 text-right">
									<span class="fw-600 font-2">0 <span class="fw-100 fs--1">BKC</span></span>
								</div>
							</div>
							<div class="btn-transaction">
								<button type="button" class="btn btn-secondary btn-block fs-0" data-id="md-confirm" data-toggle="biko-modal">Buying</button>
							</div>
						</div>
					</section>
					<!--list-->
					<div class="my-3 mx-2">
						<p class="btn-block btn btn-primary fs-0">거래코인 선택</p>
					</div>
					<div class="crypto-coin my-3 mx-2">
						<ul class="ul-coin">
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/bkc.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>BKC</h4>
										<p class="fs--1 mb-0">비케이씨</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-success fs--1"><i class="fas fa-caret-up"></i> + 0.12%</span>
										<p class=" fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>

							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/bkb.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>BKB</h4>
										<p class="fs--1 mb-0">비케이비</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-danger fs--1"><i class="fas fa-caret-down"></i> - 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li class="active">
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/btc.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>BTC</h4>
										<p class="fs--1 mb-0">비트코인</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-success fs--1"><i class="fas fa-caret-up"></i> + 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/bch.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>BCH</h4>
										<p class="fs--1 mb-0">비트코인캐시</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-danger fs--1"><i class="fas fa-caret-down"></i> - 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/eth.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>ETH</h4>
										<p class="fs--1 mb-0">이더리움</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-success fs--1"><i class="fas fa-caret-up"></i> + 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/xrp.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>XRP</h4>
										<p class="fs--1 mb-0">리플</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-success fs--1"><i class="fas fa-caret-up"></i> + 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/cwi.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>CWI</h4>
										<p class="fs--1 mb-0">씨더블유아이</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-danger fs--1"><i class="fas fa-caret-down"></i> - 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/ltc.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>LTC</h4>
										<p class="fs--1 mb-0">라이트코인</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-danger fs--1"><i class="fas fa-caret-down"></i> - 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/qtum.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>QTUM</h4>
										<p class="fs--1 mb-0">퀀텀</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-danger fs--1"><i class="fas fa-caret-down"></i> - 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/dash.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>DASH</h4>
										<p class="fs--1 mb-0">대시</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-success fs--1"><i class="fas fa-caret-up"></i> + 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
							<li>
								<div class="row m-0">
									<div class="col-2 p-0 text-center">
										<img src="assets/images/logos/eos.png" width="24">
									</div>
									<div class="col-4 p-0">
										<h4>EOS</h4>
										<p class="fs--1 mb-0">이오스</p>
									</div>
									<div class="crypto-price col-6 pl-0 text-right font-2">
										<span class="color-success fs--1"><i class="fas fa-caret-up"></i> + 0.12%</span>
										<p class="fs-005 mb-0">141,616.0000</p>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<!-- <div class="my-3 mx-2">
						<a href="crypto_trading_history.php" title="거래 내역보기" class="btn-block btn btn-primary fs-0">거래 내역보기</a>
					</div> -->
				</div>
			</div>
		</div>
	</section>
	<div class="remodal hidden" id="md-confirm">
		<div class="remodal-contents p-4">
			<span class="icon ic-verified color-primary fs-2"></span>
			<p class="mt-2">거래가 성공적으로 이루어 졌습니다.</p>
		</div>
		<div class="remodal-footer text-center">
			<button class="btn color-primary" onclick="hideModal()">확인</button>
		</div>
	</div>
	<? include "./inc_Bottom.php"; ?>
</body>
<script>
	//테마 변경 체크박스
	$('.form-switch input').change(function(){
		if($(this).is(":checked")) {
				$('body').addClass("dark-crypto").removeClass("light-crypto");
		} else {
				$('body').removeClass("dark-crypto").addClass("light-crypto");
		}
	});
	$('.ul-coin li').click(function() {
		$(this).addClass('active').siblings('li').removeClass('active');
		$('html, body').animate({
			scrollTop: 0
		}, 500);
		return false;
	});
</script>
</html>