<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<?
if(!$_SESSION['_api_secret']){
	header("Location:exchange_login.php");
	exit;
}
?>

<?
$코인 = array(
	"bkc",
	"bkb",
	"btc",
	"bch",
	"eth",
	"xrp",
	"cwi",
	"ltc",
	"qtum",
	"dash",
	"eos",
	"ztc",
	"trt",
	"lcgc",
	"lc+",
);

//require "_inc_api_login.php";

require "_inc_wallet_information.php";

$json = json_decode($response, true);

error_debug($json);

if($json['error']!="" || $json['message']=="Unauthenticated."){
	header("Location:exchange_login.php");
	exit;
}

?>

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

<? $_TITLE = $dic[Wallet_wallet]; ?>

<body>
<? include "./inc_Top.php"; ?>
<section class="wrap-wallet py-0">
	<div class="container header-top">
		<div class="row align-items-center justify-content-center">
			<div class="col-sm-10 col-lg-6 col-xl-6 p-0">
				<div class="p-3 bg-gradient-primary color-white">
					<h2 class="font-2 fs-005 fw-300 mb-1">UID <?=$rowMember['UID']?><span class="bar opacity-75"></span><?=$rowMember['name']?></h2>
					<label class="fw-400 mb-0" for="">Total BKC Value</label>
					<span class="font-2 fs-05 fw-600 float-right"><?=소수n자리까지표시(get_TOTAL_BKC_VALUE($json),4)?></span>
				</div>
				<p class="mx-3 mt-3 mb-0 color-7 fs--1"><i class="fas fa-info-circle color-8"></i> <?=$dic['Wallet_guide2']?> <span class="text-copy"><?=$dic['Wallet_get_wallet']?></span> <?=$dic['Wallet_guide3']?> <?=$dic['Wallet_guide4']?></p>
				<article class="p-3">
					<ul class="list-wallet">
						<li class="box-ver2 py-3">
							<div class="row  align-items-center justify-content-center m-0">
								<div class="col-2 text-center p-0">
									<img src="../assets/images/logos/bkp.png" width="18" />
									<h3 class="coin-name fw-200">BKP</h3>
								</div>
								<div class="col-6 p-0">
									<span class="font-2 fw-600"><?=number_format($rowMember['bkpoint'])?></span>
									<p onclick="copyToAddress('#copyAddress')" class="address fs--1">
										UID : <span id="copyAddress" class="text-address"><?=$rowMember['UID']?></span>
										<span class="text-copy"><?=$dic['Wallet_uid_copy']?></span>
									</p>
								</div>
								<div class="col-4 text-right pl-0">
									<a href="bkp_charge.php" title="charge" class="btn btn-xs btn-info"><?=$dic['Wallet_charge']?></a>
									<a href="javascript:void(0)" onClick="alert('<?=$dic['Coming_soon']?>')" title="출금 바로가기" class="btn btn-xs btn-info2"><?=$dic['Wallet_withawal']?></a>
								</div>
							</div>
						</li>

<?
for ($i=0; $i<count($코인); $i++){


if(get_코인_wallet_address($코인[$i], $json)){
?>

						<li class="box-ver2 py-3">
							<div class="row align-items-center justify-content-center m-0">
								<div class="col-2 text-center p-0">
									<img src="assets/images/logos/<?=$코인[$i]?>.png" width="18" />
									<h3 class="coin-name fw-200"><?=strtoupper($코인[$i])?></h3>
								</div>
								<div class="col-6 col-md-5 p-0">
									<span class="font-2 fw-600"><?= 소수n자리까지표시(get_코인_balance($코인[$i], $json),4)?></span>
									<p onclick="copyToAddress('#copyAddressy_<?=$i?>')" class="address fs--1">
										<span id="copyAddressy_<?=$i?>" class="text-address"><?= get_코인_wallet_address($코인[$i], $json)?></span>
										<? if(get_blockchain_tag($코인[$i],$json)){?>
										<br/><span class="color-1"><?=get_blockchain_tag($코인[$i],$json)?></span><br>
										<?}?>
										<span class="text-copy"><?=$dic['Charge_copy']?></span>
									</p>
								</div>
								<div class="col-4 col-md-5 text-right pl-0">
									<a href="javascript:void(0)" onClick="alert('<?=$dic['Coming_soon']?>')" title="전송 바로가기" class="btn btn-xs btn-info"><?=$코인[$i]=="bkp"?$dic[Wallet_charge]:$dic[Wallet_send]?></a>
<!--									<a href="<?=$코인[$i]=="bkp"?"charge.php":"crypto_send.php"?>" title="전송 바로가기" class="btn btn-xs btn-info"><?=$코인[$i]=="bkp"?$dic[Wallet_charge]:$dic[Wallet_send]?></a>-->
									<a href="receive.php?coin=<?=$코인[$i]?>" title="받기 바로가기" class="btn btn-xs btn-info2"><?=$dic['Wallet_recieve']?></a>
								</div>
							</div>
						</li>

<?}else{?>
						<li class="box-ver2 py-3">
							<div class="row align-items-center justify-content-center m-0">
								<div class="col-2 text-center p-0">
									<img src="assets/images/logos/<?=$코인[$i]?>.png" width="18" />
									<h3 class="coin-name fw-200"><?=strtoupper($코인[$i])?></h3>
								</div>
								<div class="col-6 col-md-5 p-0">
									<span class="font-2 fw-600"><?= 소수n자리까지표시(get_코인_balance($코인[$i], $json),4)?></span>
									<p class="address fs--1"><?=$dic['Wallet_guide']?></p>
								</div>
								<div class="col-4 col-md-5 text-right pl-0">
									<a href="javascript:make_wallet('<?=$코인[$i]?>');" title="지갑생성" class="btn btn-xs btn-outline-gray"><?=$dic['Wallet_get_wallet']?></a>
								</div>
							</div>
						</li>
<?}?>
<?}?>
					</ul>
				</article>
			</div>
		</div>
	</div>
</section>

<? include "./inc_Bottom.php"; ?>
</body>

<script>
	//지갑주소복사
	function copyToAddress(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).html()).select();
		document.execCommand("copy");
		$temp.remove();
		alert('<?=$dic[Wallet_copy_alert]?>');
	}
</script>
<script>
	$('.nav_bottom li[data-name="wallet"]').addClass('active');
</script>

</html>