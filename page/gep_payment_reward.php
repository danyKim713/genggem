<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="./assets/css/sub.css?20190930">


<?
$_TITLE = QR결제적립내역;
?>

<body>
	<? include "./inc_Top.php"; ?>
	<section class="py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-3 p-0">
					<div class="p-3 bg-gradient-primary color-white">
						<h2 class="font-2 fs-005 fw-300 mb-1">UID <?=$rowMember['UID']?><span class="bar opacity-75"></span><?=$rowMember['name']?></h2>
						<label class="fw-400 mb-0 fs-0" for=""><?=$dic['Charge_title']?></label>
						<span class="font-2 fs-05 fw-600 float-right"><?=number_format(bkp_now($rowMember['email']))?></span>
					</div>
					<div class="font-2 background-10 fs--1 color-5 py-2 px-3 text-right">
						QR적립총금액 : <?=number_format($rowS['QR적립총금액'])?> BKB
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
							<ul>

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

 
$orderBy = " ORDER BY A.pk_store_payment DESC ";


$where = " where A.member_id = '".$rowMember['member_id']."' ";
 
if ($date_start) {
    $where .= " and  left(A.결제일시,10)  >= '$date_start'";
   }
if ($date_end) {
    $where .= " and  left(A.결제일시,10)  <= '$date_end'";
}

//$where .= " and A.type='TransCredit'";

$start = ($pageNo-1)*$pageScale;

$query = "select B.*, A.* from tbl_store_payment A 
				INNER JOIN tbl_store B
                	ON A.store_id = B.store_id
".$where. $orderBy;
$query .= " LIMIT ".$start.", ".$pageScale;

// echo $query;
//echo $where;
$result = db_query($query);
$num=db_result("select count(*) from tbl_store_payment A $where");

$display = $num - ($pageNo-1)*$pageScale;

while($row = db_fetch($result)){
?>

								<li>
									<div class="list-info">
										<span class="fs--1">적립일</span><span class="bar"></span><span class="fs--1 color-7"><?=date("Y-m-d",strtotime($row['결제일시']))?></span>
										<p class="mt-1 mb-0 lh-2"><small>결제금액</small><span class="bar"></span><strong><?=number_format($row['원화결제금액'])?></strong> <small>￦</small></p>
										<span class="fs--1">적립금액</span><span class="bar"></span><span class="fs--1"><?=$row['코인결제금액']?> <?=$row['결제코인']?></span><br>
										<span class="fs--1">사용가맹점명</span><span class="bar"></span><span class="fs--1 color-7"><?=$row['store_name']?> (<?=$row['store_code']?>)</span>
									</div>
								</li>
<?}?>
<?/**
								<li>
									<div class="list-info">
										<span class="fs--1">적립일</span><span class="bar"></span><span class="fs--1 color-7">2019-09-01 13:25:10</span>
										<p class="mt-1 mb-0 lh-2"><small>결제금액</small><span class="bar"></span><strong>35,000</strong> <small>￦</small></p>
										<span class="fs--1">적립금액</span><span class="bar"></span><span class="fs--1">0.12345678 BKB</span><br>
										<span class="fs--1">사용가맹점명</span><span class="bar"></span><span class="fs--1 color-7">대박삼겹살 (S1234567)</span>
									</div>
								</li>
								<li>
									<div class="list-info">
										<span class="fs--1">적립일</span><span class="bar"></span><span class="fs--1 color-7">2019-09-01 13:25:10</span>
										<p class="mt-1 mb-0 lh-2"><small>결제금액</small><span class="bar"></span><strong>1,125,000</strong> <small>￦</small></p>
										<span class="fs--1">적립금액</span><span class="bar"></span><span class="fs--1">0.12345678 BKB</span><br>
										<span class="fs--1">사용가맹점명</span><span class="bar"></span><span class="fs--1 color-7">대박삼겹살 (S1234567)</span>
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
<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>