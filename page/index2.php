<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
	<? include "./inc_Head.php"; ?>
		<link rel="stylesheet" href="assets/css/main.css">

		<?
$secret = $_SESSION['_api_secret'];
$access_token = $_SESSION['_api_access_token'];

$_SIGNATURE = hash_hmac('sha256', "GET api/v2/balance",  $secret);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "{$_EXCHANGE_SERVER_URL}/api/v2/balance?signature={$_SIGNATURE}",
  CURLOPT_USERAGENT => $_USER_AGENT,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "authorization: Bearer {$access_token}",
    "cache-control: no-cache",
	"User-Agent: {$_USER_AGENT}"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
//  echo "cURL Error #:" . $err;
} else {
//  echo $response;
}

$json = json_decode($response, true);
if($json['message']=="Unauthenticated." || $json['error']!=""){
	$거래소로그인필요 = true;
}else{
	$거래소로그인필요 = false;
}
?>

			<body>
				<section class="py-0">
					<div class="container header-top">
						<div class="row align-items-center justify-content-center">
							<div class="col-sm-10 col-lg-6 col-xl-4 p-0 pb-4">
								<? include "./inc_nav.php"; ?>
									<article class="border-coin bg-gradient-primary pt-4 pb-3">
										<div class="ml-4 mr-3 mb-1 clearfix">
											<h2 class="color-white fs-05 fw-300 d-inline">Welcome, <?=$rowMember['name']?></h2>
											<? if (trim($_SESSION['_api_username']) != "") {
											echo "<a href='wallet.php' title='my wallet' class='btn-exchannge-login color-10 float-right'>내지갑</a>";
											} else {
												echo "<a href='exchange_login.php' title='exchange login' class='btn-exchannge-login color-10 float-right'>거래소 로그인</a>";
											} 
											?>
										</div>
										<div>
											<ul class="slider-coin">
												<li class="coin-box">
													<div class="coin-tlt">
														<div class="coin-icon mb-2"><img src="assets/images/logos/bkp.png" width="16" class="vertical-sub mr-1">BKP 보유금액</div>
														<a href="javascript:void(0)" title="이용내역보기" class="fs--1 color-6 d-block"><span class="color-1 fs-2 fw-500 ls--1 mr-2"><?=number_format($rowMember['bkpoint'])?></span>BKP 이용내역보기<span class="icon ic-right-arrow"></span></a>
														<p onclick="copyToAddress('#copyAddress')" class="address mt-1"><span id="copyAddress" class="text-address">UID: <?=$rowMember['UID']?></span><i class="far fa-clone fs--1 ml-1 color-8"></i>
														</p>
													</div>
													<div class="bkp-btn background-info">
														<div class="row m-0">
															<div class="col-6 p-0">
																<a href="bkp_charge.php" role="button"><img src="assets/images/icon/ic-sv-bkp-charge.svg" alt="BKP Charge" width="25">
																<span class="fs-005 fw-500 color-1">충전하기</span>
																</a>
															</div>
															<div class="col-6 p-0">
																<a href="bkp_withdraw.php" role="button"><img src="assets/images/icon/ic-sv-bkp-withdraw.svg" width="25">
																<span class="fs-005 fw-500 color-1">출금하기</span>
																</a>
															</div>
														</div>
													</div>
												</li>
												<li class="coin-box">
													<div class="coin-tlt">
														<div class="coin-icon mb-2"><img src="assets/images/logos/bkc.png" width="16" class="vertical-sub mr-1">BKC 보유금액</div>
														<a href="javascript:void(0)" title="이용내역보기" class="fs--1 color-6 d-block"><span class="color-1 fs-2 fw-500 ls--1 mr-2">0.0000</span> BKC내역보기<span class="icon ic-right-arrow"></span></a>
														<p class="address fs--1">지갑이 없습니다. 지갑을 생성해 주세요.</p>
													</div>
													<div class="bkp-btn background-info">
														<div class="row m-0">
															<div class="col-6 p-0">
																<a href="javascript:void(0)" role="button">
																	<img src="assets/images/icon/ic-sv-coin-send.svg" alt="crypto send" width="25">
																<span class="fs-005 fw-500 color-1">전송하기</span>
																</a>
															</div>
															<div class="col-6 p-0">
																<a href="receive.php" role="button">
																	<img src="assets/images/icon/ic-sv-qr-code.svg" alt="receive" width="25">
                  								<span class="fs-005 fw-500 color-1">받기</span>
                								</a>
              								</div>
														</div>
													</div>
												</li>
												<li class="coin-box">
													<div class="coin-tlt">
													<div class="coin-icon mb-2"><img src="assets/images/logos/bkb.png" width="16" class="vertical-sub mr-1">BKB 보유금액</div>
														<a href="javascript:void(0)" title="이용내역보기" class="fs--1 color-6 d-block"><span class="color-1 fs-2 fw-500 ls--1 mr-2">1,123.123456</span>BKB내역보기<span class="icon ic-right-arrow"></span></a>
														<p onclick="copyToAddress('#copyAddress2')" class="address mt-1 ellipsis"><span id="copyAddress2" class="text-address">0xa2a36D281B72fCC17eaB7Bff3e991400d995E946</span></p>
														<i class="far fa-clone fs--1 ml-1 color-8"></i>
													</div>
													<div class="bkp-btn background-info">
														<div class="row m-0">
															<div class="col-6 p-0">
																<a href="javascript:void(0)" role="button">
																	<img src="assets/images/icon/ic-sv-coin-send.svg" alt="crypto send" width="25">
                  								<span class="fs-005 fw-500 color-1">전송하기</span>
                								</a>
              								</div>
															<div class="col-6 p-0">
																<a href="receive.php" role="button">
																	<img src="assets/images/icon/ic-sv-qr-code.svg" alt="receive" width="25">
                  								<span class="fs-005 fw-500 color-1">받기</span>
                								</a>
              								</div>
														</div>
													</div>
												</li>
											</ul>
										</div>
										<!--공지사항-->
										<div class="notice-box">
											<span class="icon ic-notice color-white fs-005 mr-1"></span>
											<a href="notice.php" title="공지사항 바로가기" class="fs-005 d-inline-block color-white fw-500"><?
											$resultNotice = db_query("select * from tbl_notice order by regdate DESC LIMIT 0,1");
											while($rowNotice = db_fetch($resultNotice)){
											?>
											<?=$rowNotice['subject']?>
											<?}?>
											</a>
										</div>
										<!--//공지사항-->
									</article>

									<article class="box-bottom">
										<div class="main-menu text-center">
											<ul class="row p-3">
												<li class="col-3 p-0">
													<a href="javascript:void(0)" title="qr" onClick="alert('<?=$dic['Coming_soon']?>')">
														<img src="assets/images/icon/ic-sv-qr-scan.svg" alt="link send" />
														<h3>QR결제</h3>
													</a>
												</li>
												<li class="col-3 p-0">
													<a href="cloud.php" title="cloud">
														<img src="assets/images/icon/ic-sv-cloud.svg" alt="receive" width="24"/>
														<h3>클라우드</h3>
													</a>
												</li>
												<li class="col-3 p-0">
													<a href="myinfo_edit.php" title="myinfo">
														<img src="assets/images/icon/ic-myinfo.svg" width="24" />
														<h3>내정보</h3>
													</a>
												</li>

												<li class="col-3 p-0">
													<a href="javascript:void(0).php" title="add">
														<img src="assets/images/icon/ic-sv-shopping-deal.svg">
														<h3>쇼핑딜</h3>
													</a>
												</li>
											</ul>
										</div>
									</article>



									<!--배너-->
									<article>
										<ul class="slider slider-banner">
											<?
							$resultBanner = db_query("select * from tbl_banner where use_yn='Y' and position='앱메인페이지(슬라이딩)'");
							while($rowBanner = db_fetch($resultBanner)){
							?>
												<li>
													<a href="<?=$rowBanner['link_url']?$rowBanner['link_url']:" # "?>" title="<?=$rowBanner['subject']?>">
									<img src="/_UPLOAD/<?=rawurlencode($rowBanner['filename'])?>" />
								</a>
												</li>
												<?}?>
										</ul>
									</article>
									<? include "./inc_Bottom.php"; ?>
										<?
$rowPopup = db_select("select * from tbl_popup where use_yn = 'Y' and open_from <= '".date("Y-m-d")."' and open_to >= '".date("Y-m-d")."' order by regdate DESC LIMIT 0,1");
if($rowPopup['popup_id'] && $_COOKIE['ck_today_'.$rowPopup[popup_id]]!="Y"){
?>
											<script>
												function do_not_open_today(popup_id) {
													setCookie('ck_today_' + popup_id, "Y", 1);
													hideModal();
												}
											</script>
											<?}?>
							</div>
						</div>
					</div>
				</section>
			</body>
			<script>
				$('.slider-banner').slick({
					dots: true,
					arrows: false,
					autoplay: true,
					autoplaySpeed: 4000,
					fade: true
				});

				
					$('.slider-coin').slick({
					dots: false,
					arrows: false,
					autoplay: false,
					slidesToShow: 1,
					slidesToScroll: 1,
					responsive: [
						{
							breakpoint: 768,
							settings: {
								arrows: false,
								centerMode: true,
								centerPadding: '15px',
								slidesToShow: 1
							}
						},
						{
							breakpoint: 480,
							settings: {
								arrows: false,
								centerMode: true,
								centerPadding: '15px',
								slidesToShow: 1
							}
						}
					]
				});
				
			</script>
			<script>
				$('.nav_bottom li[data-name="home"]').addClass('active');
			</script>
</html>