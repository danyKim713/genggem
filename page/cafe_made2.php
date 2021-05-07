<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
		<h2 class="header-title text-center">채널생성</h2>
	</header>
	<section class="wrap-channelmade py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-3">
					<p class="my-4 fs-05 text-center">채널의 원활한 모임을 위해<br>50명을 자동으로 초대합니다.</p>
					<div class="form-group">
						<label class="fs-0">채널 정원을 선택해주세요</label>
						<div class="list-price d-flex text-center">
							<div class='col-4 p-0 radiobox'>
								<input id="type01" type="radio" name="channelType" class="invisible"/>
								<label for="type01" class="d-block">
									<div class="card border color-9 mr-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">Basic</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">무료</h2>
											<p class="fw-400 fs--1 color-5">20명,30일 사용</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>
							<div class='col-4 p-0 radiobox'>
								<input id="type02" type="radio" name="channelType" class="invisible" checked/>
								<label for="type02" class="d-block">
									<div class="card border color-9">
										<div class="card-header">
											<h4 class="m-0 fs-005">Premium</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">13,200원</h2>
											<p class="fw-400 fs--1 color-5">1000명,매월</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>
							<div class='col-4 p-0 radiobox'>
								<input id="type03" type="radio" name="channelType" class="invisible"/>
								<label for="type03" class="d-block">
									<div class="card border color-9 ml-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">Premium</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">132,000원</h2>
											<p class="fw-400 fs--1 color-5">1000명,매년</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>
						</div>
						<div class="mt-2">
							<ul class="ul-notice">
								<li>신규 채널이 만들어지면 신규채널 상단에 노출됩니다.</li>
								<li>채널을 생성하시면 매월/매년 정기적으로 자동 결제 됩니다.</li>
								<li>원하실때 언제든 해지가 가능합니다.</li>
								<li>단, 해지시 채널이 운영중지됩니다.</li>
							</ul>
						</div>
					</div>

					<div class="form-group">
						<label for="" class="mr-2">결제금액</label>
						<span class="color-primary fs-1 fw-600">13,200원</span>
					</div>
					<div class="form-group">
						<label for="">결제수단</label>
						<div class="row m-0">
							<div class="col-6 check-rbox">
								<input type="radio" id="pay1" name="channelPay" class="invisible"/>
								<label for="pay1">무통장입금</label>
							</div>
							<div class="col-6 check-rbox">
								<input type="radio" id="pay2" name="channelPay" class="invisible"/>
								<label for="pay2">휴대폰결제</label>
							</div>
							<div class="col-6 check-rbox">
								<input type="radio" id="pay3" name="channelPay" class="invisible"/>
								<label for="pay3">GEP 포인트결제</label>
							</div>
							<div class="col-6 check-rbox">
								<input type="radio" id="pay4" name="channelPay" class="invisible"/>
								<label for="pay4">GEN 코인결제</label>
							</div>
						</div>
					</div>
					<div class="mt-4">
						<a href="channel_made3.php" class="btn-block btn btn-primary fs-0"><?=$dic['Next']?></a>
					</div>
				</div>
				<? include "./inc_Bottom_channel.php"; ?>
			</div>
		</div>
	</section>
</body>

<script>
 $('.nav_bottom li[data-name="channelmade"]').addClass('active');
</script>
</html>