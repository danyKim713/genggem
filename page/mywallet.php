<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<script>
	function make_wallet(currency){
		$.post(
			"_ajax_register_deposit_address.php",
			{currency: currency},
			function(data){
				if(data != "FAIL"){
					var txt = data.split("|");
					alert('<?=$dic[Wallet_made_wallet]?> '+txt[1]+'<?=$dic[Wallet_made_wallet2]?>');
					location.reload(true);
				}else{
					alert('<?=$dic[Member_error]?>');
				}
			}
		);
	}
</script>

<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[Wallet_wallet];
?>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
		<h2>Help Desk</h2>
	</div>
</div>
<? include "./inc_help_nav.php"; ?>

<section class="new-arrivals-products-area">
	<div class="container">
		<div class="category-area2 mt-2">
			<article class="p-1">
				<!-- 회원 정보 -->
				<div class="form-group">
					<ul class="list list-border background-white">
						<li class="p-3">
							<div class="d-flex align-items-center justify-content-between">
								<div>
									<h4 class="fs-005 ellipsis mb-1">회원정보</h4>
									<div class="address fs--1 channel-set-address mt-2">
										<p onclick="copyUID('#copyUID')" class="address fs--1">
										<i class="fas fa-medal fs--1 color-success ml-1 mt-2"></i> 회원이름 : <?=$rowMember['name']?><br>
										<i class="fas fa-medal fs--1 color-success ml-1 mt-2"></i> 카페핸즈 UID : <span id="copyUID" class="text-address fw-600"><?=$rowMember['UID']?></span>
										<span class="text-copy">UID 복사</span><br>
										</p>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
				 <!--//정보-->

				<? include "./gpay_status.php"; ?>

				
			</article>
		</div>
	</div>
</section>

<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_main.php"; ?>
</body>

<script>
	//지갑주소복사
	function copyToAddress(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).html()).select();
		document.execCommand("copy");
		$temp.remove();
		alert('지갑주소를 복사했습니다.');
	}
</script>
<script>
	//지갑주소복사
	function copyUID(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).html()).select();
		document.execCommand("copy");
		$temp.remove();
		alert('UID를 복사했습니다.');
	}
</script>
<script>
	$('.nav_category li[data-name="gnb-cloud"]').addClass('active');
	$('.nav_bottom li[data-name="wallet"]').addClass('active');
</script>

</html>