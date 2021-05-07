<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<?
$_TITLE = "거래내역";
?>
<link rel="stylesheet" href="assets/css/sub.css">
<body>
	<? include "./inc_Top.php"; ?>
	<section class="wrap-crypto py-0">
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<!--tab-->
					<div id="tab-menu" class="tab-sub clearfix">
						<ul class="row align-items-center justify-content-center text-center m-0">
							<li class="col p-0 active"><a href="crypto_trading_history.php" title="거래내역">거래내역</a></li>
							<li class="col p-0"><a href="receive_history.php" title="전송/사용내역">전송/받은내역</a></li>
							<li class="col p-0"><a href="bkc_change_history.php" title="BKC 전환내역">BKC 전환내역</a></li>
						</ul>
					</div>
					<!--tab-->
					<!--date-->
					<div class="con-datepicker clearfix">
						<div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control" name="start" value="2019-01-01" />
							<span class="input-group-addon color-8">-</span>
							<input type="text" class="input-sm form-control" name="end" value="2019-01-01" />
							<select class="form-control ml-1">
								<option value="all">All</option>
								<option value="BKB">BKB</option>
								<option value="BKP">BKP</option>
								<option value="CWI">CWI</option>
							</select>
						</div>
						<div class="btn-date">
							<button type="button" class="btn btn-outline-gray btn-search"><i class="fas fa-search"></i></button>
						</div>
					</div>
					<!--//date-->
					<div class="list-history">
						<ul class="ul-coin">
							<li>
								<div class="list-info">
									<span class="fs--1 color-8">2019-06-30 14:26</span>
									<div class="list-tlt lh-2">
										<h4>BKB<span class="bar"></span>BKC marcket</h4>
										<span class="float-right color-success fs-005">매수</span>
									</div>
									<div class="row">
										<div class="col-6">
											<label class="mb-0">수량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">10,000 <small>BKB</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">수수료</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">0.001 <small>BKB</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">총 매도량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">9,999 <small>BKB</small></p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="list-info">
									<span class="fs--1 color-8">2019-06-30 14:26</span>
									<div class="list-tlt lh-2">
										<h4>BTC<span class="bar"></span>BKC marcket</h4>
										<span class="float-right color-success fs-005">매수</span>
									</div>
									<div class="row">
										<div class="col-6">
											<label class="mb-0">수량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">0.1 <small>BTC</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">수수료</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">0.00001 <small>BTC</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">총 매도량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">0.0999 <small>BTC</small></p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="list-info">
									<span class="fs--1 color-8">2019-06-30 14:26</span>
									<div class="list-tlt lh-2">
										<h4>ETH<span class="bar"></span>BKC marcket</h4>
										<span class="float-right color-danger fs-005">매도</span>
									</div>
									<div class="row">
										<div class="col-6">
											<label class="mb-0">수량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">2 <small>ETH</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">수수료</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">0.001 <small>BKC</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">총 매도량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">1.999 <small>BKC</small></p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="list-info">
									<span class="fs--1 color-8">2019-06-30 14:26</span>
									<div class="list-tlt lh-2">
										<h4>BKB<span class="bar"></span>BKC marcket</h4>
										<span class="float-right color-success fs-005">매수</span>
									</div>
									<div class="row">
										<div class="col-6">
											<label class="mb-0">수량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">540,000 <small>BKB</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">수수료</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">0.2 <small>BKC</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">총 매도량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">1.1000 <small>BKC</small></p>
										</div>
									</div>
								</div>
							</li>
							<li>
								<div class="list-info">
									<span class="fs--1 color-8">2019-06-30 14:26</span>
									<div class="list-tlt lh-2">
										<h4>ETH<span class="bar"></span>BKC marcket</h4>
										<span class="float-right color-danger fs-005">매도</span>
									</div>
									<div class="row">
										<div class="col-6">
											<label class="mb-0">수량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">1 <small>BKC</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">수수료</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">0.0000 <small>BKC</small></p>
										</div>
										<div class="col-6">
											<label class="mb-0">총 매도량</label>
										</div>
										<div class="col-6 text-right">
											<p class="mb-0">1.1000 <small>BKC</small></p>
										</div>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<div class="mt-3">
						<ul class="pagination justify-content-center">
							<li class="page-item"><a class="page-link link-pre" href="#"><span class="icon ic-left-arrow"></span></a></li>
							<li class="page-item"><a class="page-link" href="#">1</a></li>
							<li class="page-item"><a class="page-link" href="#">2</a></li>
							<li class="page-item active"><a class="page-link" href="#">3</a></li>
							<li class="page-item"><a class="page-link" href="#">4</a></li>
							<li class="page-item"><a class="page-link" href="#">5</a></li>
							<li class="page-item"><a class="page-link link-next" href="#"><span class="icon ic-right-arrow"></span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
</body>

</html>