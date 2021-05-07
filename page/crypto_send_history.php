<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[Crypto_send_title];
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

 
$orderBy = " ORDER BY A.pk_crypto_send_history DESC ";


$where = " where A.member_id = '".$rowMember['member_id']."' ";
 
if ($date_start) {
    $where .= " and  left(A.regdate,10)  >= '$date_start'";
   }
if ($date_end) {
    $where .= " and  left(A.regdate,10)  <= '$date_end'";
}

//$where .= " and A.type='TransCredit'";

$start = ($pageNo-1)*$pageScale;

$query = "select B.*, A.* from tbl_crypto_send_history A 
				INNER JOIN tbl_member B
                	ON A.member_id = B.member_id
".$where. $orderBy;
$query .= " LIMIT ".$start.", ".$pageScale;

// echo $query;
//echo $where;
$result = db_query($query);
$num=db_result("select count(*) from tbl_crypto_send_history A $where");

$display = $num - ($pageNo-1)*$pageScale;
?>

<body>
	<? include "./inc_Top.php"; ?>
	<section class="py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-3 p-0">
					<div class="p-3 bg-gradient-primary color-white">
						<h2 class="font-2 fs-005 fw-300 mb-1">UID <?=$rowMember['UID']?><span class="bar opacity-75"></span><?=$rowMember['name']?></h2>
						<label class="fw-400 mb-0" for=""><?=$dic['Charge_Available']?> BKC</label>
						<span class="font-2 fs-05 fw-600 float-right"><?=소수n자리까지표시(get_TOTAL_BKC_VALUE($json),4)?></span>
					</div>
					<div class="font-2 background-10 fs--1 color-5 py-2 px-3 text-right">
						<?=$dic['Wallet_today_amount']?> : 100,000 BKP
					</div>
					<!--date-->
					<form name="frm_page" id="frm_page">
					<input type="hidden" name="pageNo" id="pageNo" value="<?=$pageNo?>"/>
					<div class="con-datepicker clearfix">
						<div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control" name="date_start" value="<?=$date_start?>">
                          <span class="input-group-addon color-8">-</span>
                          <input type="text" class="input-sm form-control" name="date_end" value="<?=$date_end?>">
						</div>
						<div class="btn-date">
							<button type="submit" class="btn btn-outline-gray btn-search"><i class="fas fa-search"></i></button>
						</div>
					</div>
					</form>
					<!--//date-->
					<div class="p-3">
						<div class="list-history">
							<h3 class="fs--1 d-inline color-4"><?=$dic['Wallet_send_history']?></h3>
							<ul>

<?php

if (mysqli_num_rows($result) ==0) { ?>
						<div class="m-5 text-center">
							<span class="fs-005 color-7">BKP 전송 내역이 없습니다. </span>
						</div>
<? } ?>
<?php
	while($row = db_fetch($result)){		
?>

								<!-- 외부지갑 전송일때 txid 발생함 -->
								<li>
									<div class="list-info">
										<p class="fs--1 color-8 mb-1"><?=$row['regdate']?></p>
										<p class="mb-0 lh-2">
											<img src="assets/images/logos/<?=$row['coin']?>.png" alt="btc" width="16" class="vertical-bottom mr-1" /><strong><?=$row['amount']?></strong> <small><?=strtoupper($row['coin'])?></small>
										</p>
										<p class="mt-1 mb-1 lh-2"><span class="fs--1 
<? 
	switch($row['진행상태']){
		case "전송대기":
			echo "color-primary";
			break;
		case "전송실패":
			echo "color-danger";
			break;
	}
?>">

<? 
	switch($row['진행상태']){
		case "전송대기":
			echo $dic['Wallet_send_completed2'];
			break;
		case "전송실패":
			echo $dic['Wallet_send_fail'];
			break;
	}
?>
										</span><span class="bar"></span><span class="fs--1 color-7"><?=$row['email'] ? "ID(E-mail) : ". $row['email'] : ""?><?=$row['address'] ? "Address : " . $row['address'] : ""?></span></p>
										<? if($row['destination_tag']){?><p class="fs--1 color-7 mb-0">TXID : <?=$row['destination_tag']?></p><?}?>
									</div>
								</li>
								<!-- 빗코엑스에서 전송거부 했을때 : 전송거부하면 보낸 금액이 자동 환불 됨:거래소 로직 -->

<?}?>

<?/**

								<li>
									<div class="list-info">
										<p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
										<p class="mb-0 lh-2">
											<img src="assets/images/logos/bkc.png" alt="btc" width="16" class="vertical-bottom mr-1" /><strong>300,000</strong> <small>BKC</small>
										</p>
										<p class="mt-1 mb-1 lh-2"><span class="fs--1 color-danger"><?=$dic['Wallet_send_fail']?></span></p>
										<p class="fs--1 color-7 mb-0">Address : df15das1f5das1f5adsf45adsfsdf54dsaf</p>
									</div>
								</li>
								<!-- 이메일 전송 또는 빗코엑스 내부전송일때 : txid 발생하지 않음 -->
								<li>
									<div class="list-info">
										<p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
										<p class="mb-0 lh-2">
											<img src="assets/images/logos/bkc.png" alt="btc" width="16" class="vertical-bottom mr-1" /><strong>300,000</strong> <small>BKC</small>
										</p>
										<p class="mt-1 mb-1 lh-2"><span class="fs--1 color-primary"><?=$dic['Wallet_send_completed2']?></span><span class="bar"></span><span class="fs--1 color-7">0xee1EE5fc40574dD02373F8aFE60b944e81Fc12</span></p>
										<p class="fs--1 color-7 mb-0">ID(E-mail) : decomix@naver.com</p>
									</div>
								</li>
								<!-- 기타 오류로 인한 전송실패 일때 -->
								<li>
									<div class="list-info">
										<p class="fs--1 color-8 mb-1">2019-06-30 14:26</p>
										<p class="mb-0 lh-2">
											<img src="assets/images/logos/bkc.png" alt="btc" width="16" class="vertical-bottom mr-1" /><strong>300,000</strong> <small>BKC</small>
										</p>
										<p class="mt-1 mb-1 lh-2"><span class="fs--1 color-danger"><?=$dic['Wallet_send_fail']?></span></p>
										<p class="fs--1 color-7 mb-0">ID(E-mail) : decomix@naver.com</p>
									</div>
								</li>
**/?>
							</ul>
						</div>
						<div class="mt-3">
							<? include ("_paging.php");?>
						</div>
					</div>
				</div>


			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
</body>

</html>