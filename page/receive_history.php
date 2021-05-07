<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="./assets/css/sub.css">

<?/**
<!-- 코인 및 BKP 수신일때 예시 화면입니다. -->
<!-- 각 코인을 선택하여 들어오면 선택한 코인의 수신 내역을 보여줌 -->
<!-- 암호화폐 외부수신일때는 TXID(트랜잭션 아이디)값이 있음: TXID 노출 -->
<!-- 암호화폐 내부수신일때는 보낸사람 이메일(아이디) 노출 -->
<!-- 리스트 중간에 BKP 수신일때 예제 있음: BKP는 사이버머니이기 때문에 전송자 UID와 이름 표기합니다. -->
**/?>

<?
$_TITLE = $dic[Charge_receive];
?>

<?php

if(!$date_start){
	$date_start = date("Y-m-d", mktime(0,0,0,date("m")-1, date("d"), date("Y")));
}
if(!$date_end){
	$date_end = date("Y-m-d");
}

if(!$pageNo){
	$pageNo = 1;
}
 
$pageScale = 5;

$pageStartNo = ($pageNo -1)*$pageScale;

 
$orderBy = " ORDER BY A.charge_dt DESC ";


$where = " where A.recipient_id = '".$rowMember['email']."' ";
 
if ($date_start) {
    $where .= " and  left(A.charge_dt,10)  >= '$date_start'";
   }
if ($date_end) {
    $where .= " and  left(A.charge_dt,10)  <= '$date_end'";
}

//$where .= " and A.type='TransCredit'";

$start = ($pageNo-1)*$pageScale;

$query = "select B.*, A.* from sysT_CoinHistory A 
				INNER JOIN tbl_member B
                	ON A.recipient_id = B.email
".$where. $orderBy;
$query .= " LIMIT ".$start.", ".$pageScale;

// echo $query;
//echo $where;
$result = db_query($query);
$num=db_result("select count(*) from sysT_CoinHistory A $where");

$display = $num - ($pageNo-1)*$pageScale;
?>

<?
$query = "select sum(전환BKC) as 총전환금액 from tbl_bkc_change_history A $where";
$row_총 = db_select($query);
?>

<?
if(!$_SESSION['_api_secret']){
	header("Location:exchange_login.php?go=".$_SERVER['PHP_SELF']);
	exit;
}

require "_inc_wallet_information.php";

$json = json_decode($response, true);

error_debug($json);

if($json['error']!="" || $json['message']=="Unauthenticated."){
	header("Location:exchange_login.php?go=".$_SERVER['PHP_SELF']);
	exit;
}
?>
<body>
	<? include "./inc_Top.php"; ?>
		<section class="py-0">
			<div class="container-fluid header-top">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-3 p-0">
					<!--tab-->
					<div id="tab-menu" class="tab-sub clearfix">
						<ul class="row align-items-center justify-content-center text-center m-0">
							<li class="col p-0"><a href="crypto_trading_history.php" title="거래내역">거래내역</a></li>
							<li class="col p-0 active"><a href="receive_history.php" title="전송/사용내역">전송/받은내역</a></li>
							<li class="col p-0"><a href="bkc_change_history.php" title="BKC 전환내역">BKC 전환내역</a></li>
						</ul>
					</div>
					<!--tab-->
						<div class="m-3">
						 <p class="color-6 fs--1 mb-2 text-left"><i class="color-8 fas fa-arrow-alt-circle-down"></i> 받은내역을 확인할 코인을 선택해 주세요.</p>
							<select class="form-control color-primary fw-600" size="1">
								<option value="" selected>코인을 선택해 주세요.</option>
								<option value="01">BKP</option>
								<option value="02">BKC</option>
								<option value="03">BKB</option>
								<option value="04">BTC</option>
								<option value="05">BCH</option>
								<option value="06">ETH</option>
								<option value="06">XRP</option>
								<option value="06">CWI</option>
								<option value="06">LTC</option>
								<option value="06">QTUM</option>
								<option value="06">DASH</option>
								<option value="06">EOS</option>
							</select>
						</div>
						<div class="p-3">
							<div class="list-history">
								<h3 class="fs-005 d-inline color-4">보유 BKB</h3>
								<span class="float-right fs-005 lh-5"><strong class="color-primary">200,000.1234</strong></span>
								<ul>
									<li>
										<div class="list-info">
										<p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
											<p class="mb-0 lh-2"><strong>300,000.1234</strong> <small>BKB</small></p>
											<span class="fs--1 color-primary">수신완료</span><span class="bar"></span><span class="fs--1 color-7">보낸사람 bikopay@daum.net</span>
										</div>
									</li>

									<!-- BKP일때-->
									<li>
										<div class="list-info">
										<p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
											<p class="mb-0 lh-2"><strong>300,000</strong> <small>BKP</small></p>
											<span class="fs--1 color-primary">수신완료</span><span class="bar"></span><span class="fs--1 color-7">UID 234567 홍길동</span>
										</div>
									</li>
									<!--bkp 일때 끝-->

									<li>
										<div class="list-info">
										<p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
											<p class="mb-0 lh-2"><strong>200,000.3200</strong> <small>BKB</small></p>
											<span class="fs--1 color-primary">수신완료</span><span class="bar"></span><span class="fs--1 color-7">보낸사람 bikopay@daum.net</span>
										</div>
									</li>
									<li>
										<div class="list-info">
										<p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
											<p class="mb-0 lh-2"><strong>10,000.0000</strong> <small>BKB</small></p>
											<span class="fs--1 color-primary">수신완료</span><span class="bar"></span><span class="fs--1 color-7">보낸사람 bikopay@daum.net</span>
										</div>
									</li>
									<li>
										<div class="list-info">
										  <p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
											<p class="mb-0 lh-2"><strong>50,000.1245</strong> <small>BKB</small></p>
											<span class="fs--1 color-primary">수신완료</span><span class="bar"></span><span class="fs--1 color-7">TXID dsfdsfdsafdsfd34dsf8ds8fds</span>
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
			</div>
		</section>
		<? include "./inc_Bottom.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>