<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<body class="mb-5">
<? 
include "./inc_nav.php"; 

$strRecordNo = $_GET["txtRecordNo"];


$query  = " SELECT  A.*, B.UID, B.name  \n";
$query .= " FROM    tbl_gpay_send A, tbl_member B \n"; 
$query .= " WHERE   A.gs_id = '{$strRecordNo}'   \n";
$query .= " AND     A.member_id = B.member_id   \n";
$row = db_select($query);

?>
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
		<h2>Help Desk</h2>
	</div>
</div>
<? include "./inc_help_nav.php"; ?>

<section class="new-arrivals-products-area mb-5">
	<div class="container">
		<div class="category-area2 mt-2 text-center">
			<span class="icon ic-verified color-primary fs-2"></span>
			<h4 class="mt-2 mb-2">성공적으로 전송되었습니다.</h4>
			<div class="text-left border-box p-3 mt-3 mb-2 fs-005">
				<ul>
					<li class="row">
						<div class="col-4 color-6"><?=$dic['Wallet_send_date']?></div>
						<div class="col-8 text-right color-7"><?=$row["send_dt"]?></div>
					</li>
					
					<li class="row mt-2">
						<div class="col-6 color-6">받는사람 UID</div>
						<div class="col-6 text-right"><?=$row["UID"]?> (<?=$row["name"]?>)</div>
					</li>
					<li class="row mt-2 color-primary fw-600">
						<div class="col-6">전송한 G-PAY(GP) 수량</div>
						<div class="col-6 text-right"><?=number_format($row["gs_amount"])?> <small>GP</small></div>
					</li>
				</ul>
				<hr class="color-10 border-dashed">
				<div class="row">
					<div class="col-6">전송 후 G-PAY 잔액</div>
					<div class="col-6 text-right fw-600"><?=number_format($rowMember['gpay'])?> <small>GP</small></div>
				</div>
			</div>				
		</div>
		<? include "./gpay_status.php"; ?>
	</div>
</section>

<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_main.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="wallet"]').addClass('active');
</script>
</html>