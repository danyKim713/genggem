<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css?20190930">

<body>
	<section class="wrap-service py-0">
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<? include "./inc_nav.php"; ?>
					<article>
						<div class="con-info bg-gradient-primary p-3">
							<div class="user-aside">
								<div class="font-2 user-info color-11">
									<h2 class="font-2 fs-005 fw-300 mb-2">UID <?=$rowMember['UID']?><span class="bar opacity-75"></span><?=$rowMember['email']?></h2>
									<label class="fw-400 mb-0 fs-0" for="">Welcome, <?=$rowMember['name']?></label>
									<a href="myinfo_edit.php" title="내정보 수정" class="float-right btn btn-xs btn-transparent">내정보 수정</a>
								</div>
							</div>
						</div>
					</article>
					<!--서비스-->
					<article class="box-bottom">
						<ul class="ul-menu py-3 px-3 pr-sm-0">
							<li class="row pt-0">
								<h2 class="col-12 col-sm-2 mb-xs-2">BKP</h2>
								<ul class="ul-submenu col-12 col-sm-10 row pl-sm-3">
									<li class="col-6">
										<a href="bkp_charge.php" title="BKP charge">
											<img src="assets/images/icon/ic-sv-bkp-charge.svg" alt="BKP Charge" />
											<h3>BKP <?=$dic['Service_charge']?></h3>
										</a>
									</li>
									<li class="col-6">
										<a href="bkp_send.php" title="BKP send">
											<img src="assets/images/icon/ic-sv-bkp-send.svg" alt="BKP send" />
											<h3>BKP <?=$dic['Service_transmission']?></h3>
										</a>
									</li>
									<li class="col-6">
										<a href="bkp_withdraw.php" title="BKP withdraw">
											<img src="assets/images/icon/ic-sv-bkp-withdraw.svg" />
											<h3>BKP <?=$dic['Wallet_withawal']?></h3>
										</a>
									</li>
									<li class="col-6">
											<a href="bkp_charge_history.php">
											<img src="assets/images/icon/ic-sv-history.svg" />
											<h3>BKP 이용내역</h3>
										</a>
									</li>
								</ul>
							</li>
							<li class="row">
								<h2 class="col-12 col-sm-2 mb-xs-2">CLOUD</h2>
								<ul class="ul-submenu col-12 col-sm-10 row pl-sm-3">
									<li class="col-6">
										<a href="cloud.php" title="cloud join">
											<img src="assets/images/icon/ic-sv-cloud.svg"/>
											<h3 class="align-middle">클라우드 참여</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="cloud_list.php" title="cloud list">
											<img src="assets/images/icon/ic-sv-cloud_edit.svg"  />
											<h3 class="align-middle">클라우드 참여내역</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="contact_cloud.php" title="cloud qna">
											<img src="assets/images/icon/ic-sv-cloud-qna.svg" />
											<h3 class="align-middle">클라우드 신청/문의</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="cloud_guide.php" title="cloud guide">
											<img src="assets/images/icon/ic-sv-cloud-guide.svg" />
											<h3 class="align-middle">클라우드 이용안내</h3>
										</a>
									</li>
								</ul>
							</li>
							<li class="row">
								<h2 class="col-12 col-sm-2 mb-xs-2">STORE</h2>
								<ul class="ul-submenu col-12 col-sm-10 row pl-sm-3">
									<li class="col-6">
										<a href="franchise.php" title="franchise list">
											<img src="assets/images/icon/ic-sv-store.svg"  />
											<h3>가맹점 목록보기</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="franchise_own.php" title="franchise add">
											<img src="assets/images/icon/ic-sv-store-admin.svg" />
											<h3>가맹점 등록/수정</h3>
										</a>
									</li>
									<li class="col-6 opacity-25">
										<a href="javascript:void(0)" title="franchise admin" onClick="alert('<?=$dic['Coming_soon']?>')">
											<img src="assets/images/icon/ic-sv-store-set.svg" />
											<h3>가맹점주 Admin</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="franchise_guide.php" title="franchise guide">
											<img src="assets/images/icon/ic-sv-store-guide.svg" />
											<h3>가맹점 이용안내</h3>
										</a>
									</li>
								</ul>
							</li>
							<li class="row">
								<h2 class="col-12 col-sm-2 mb-xs-2">BIKO<br>PAY</h2>
								<ul class="ul-submenu col-12 col-sm-10 row pl-sm-3">
									<li class="col-6">
										<a href="javascript:common_show_qr();" title="">
											<img src="assets/images/icon/ic-sv-qr-scan.svg" alt="QR payment" />
											<h3>QR결제</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="biko_payment_history.php" title="pay history">
											<img src="assets/images/icon/ic-sv-pay-history.svg" alt="pay-history" />
											<h3>QR결제내역</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="biko_payment_reward.php" title="reward">
											<img src="assets/images/icon/ic-sv-reward.svg" alt="reward" />
											<h3>리워드 내역</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="pay_guide.php" title="pay guide">
											<img src="assets/images/icon/ic-sv-pay-guide.svg" alt="pay info" />
											<h3>PAY 이용안내</h3>
										</a>
									</li>
								</ul>
							</li>
							<li class="row">
								<h2 class="col-12 col-sm-2 mb-xs-2">CRYPTO</h2>
								<ul class="ul-submenu col-12 col-sm-10 row pl-sm-3">
									<li class="col-6">
										<a href="javascript:void(0)" title="CRYPTO send" onClick="alert('<?=$dic['Coming_soon']?>')">
											<img src="assets/images/icon/ic-sv-coin-send.svg" alt="CRYPTO send" />
											<h3>암호화폐 전송</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="bkc_change.php" title="BKC charge">
											<img src="assets/images/icon/ic-sv-coin-charge.svg" alt="BKC" />
											<h3>BKC 전환</h3>
										</a>
									</li>
									<li class="col-6">
										<a href="javascript:void(0)" title="CRYPTO history" onClick="alert('<?=$dic['Coming_soon']?>')">
											<img src="assets/images/icon/ic-sv-bkc-history.svg" alt="CRYPTO send list" />
											<h3>암호화폐 거래내역</h3>
										</a>
									</li>
									<li class="col-6 opacity-25">
										<a href="javascript:void(0)" title="CRYPTO" onClick="alert('<?=$dic['Coming_soon']?>')">
											<img src="assets/images/icon/ic-sv-crypto.svg" alt="trading" />
											<h3>암호화폐 트레이딩</h3>
										</a>
									</li>
								</ul>
							</li>
							<li class="row">
								<h2 class="col-12 col-sm-2 mb-xs-2">LIFE &#38;<br>SHOPPING</h2>
								<ul class="ul-submenu col-12 col-sm-10 row pl-sm-3">
									<li class="col-6">

<?
if($rowMember['agency_status'] ==  "N"){
	$link = "agency.php";
}else{
	$link = "agency_detail.php";
}
?>

										<a href="<?=$link?>" title="agency">
											<img src="assets/images/icon/ic-sv-agency.svg" alt="agency" />
											<h3>에이전시</h3>
										</a>
									</li>
									<li class="col-6 opacity-25">
										<a href="javascript:void(0)" title="CRYPTO" onClick="alert('<?=$dic['Coming_soon']?>')">
											<img src="assets/images/icon/ic-sv-shopping.svg" alt="shop deal" />
											<h3>쇼핑딜</h3>
										</a>
									</li>
									<li class="col-6 opacity-25">
											<a href="javascript:void(0)" title="medical" onClick="alert('<?=$dic['Coming_soon']?>')">
											<img src="assets/images/icon/ic-sv-medical.svg" alt="wamedicalllet" />
											<h3>의료</h3>
										</a>
									</li>
									<li class="col-6 opacity-25">
<!--										<a href="javascript:void(0)" title="travel">-->
										<a href="javascript:void(0)" title="travel" onClick="alert('<?=$dic['Coming_soon']?>')">	
											<img src="assets/images/icon/ic-sv-travel.svg" alt="travel" />
											<h3>여행</h3>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</article>
					<!--//서비스-->
					<article>						
						<a href="https://bitkoex.com" target="_blank" title="bitkoex 바로가기"><img src="assets/images/banner_bitkoex.jpg" /></a>
						<a href="franchise_add.php" title="가맹신청 바로가기">
							<img src="assets/images/banner_store.jpg" />
						</a>
					</article>
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
</body>

 
<script>
function common_show_qr(){
<? if( $detect->isAndroidOS() ) {?>
		window.AndroidApp.show_qr();
<?}else if( $detect->isiOS() ){?>
		window.webkit.messageHandlers.show_qr.postMessage(null);
<?}?>
	}
	function set_qr(val){
		top.location.href = "biko_payment.php?store_code="+val;
	}		
</script>


<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>