<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<style type="text/css">
	article.my-3 {
		display: none;
	}
	article.block-important {
		display: block !important;
	}
</style>

<!-- 암호화폐 및 BKP(사이버머니) 수신 화면 : 기본 로딩은 BKC를 무조건 기본으로 가져옴 -->
<!-- 아래 코인 리스트에서 코인 선택하면 상단에 해당 코인 정보 가져옴 -->
<!-- when selected bkp : BKP 수신 화면 : BKP는 회원의 UID 노출 -->
<!-- when selected xrp : 리플(xrp)는 주소 + 구분숫자 4자리로 표현합니다. 두개를 위 아래로 보여 줌 : 주소복사는 지갑 주소만 복사하면 됨 -->
<!-- no wallet : 생성한 지갑이 없을 경우 거래소 API를 이용하여 바로 지갑을 생성하도록 함 -->

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

<?
$코인 = array(
"bkp",
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
"eos"
);
?>

<?
if(!$coin){
	$coin = "bkc";
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

<?
$_TITLE = $dic[Service_receive];
?>

<body>
	<? include "./inc_Top.php"; ?>
	<section class="py-0">
		<div class="container-fluid mt-5 text-center">
			<div class="row align-items-center justify-content-center">
				<!-- <div class="col-sm-10 col-lg-6 col-xl-6 p-0">
					<div class="p-3 bg-gradient-primary color-white">
						<h2 class="font-2 fs-005 fw-300 mb-2"><?=$dic['Wallet_bitkoex']?><span class="bar opacity-75"></span><?=$_SESSION['_api_username']?></h2>
					</div>
				</div> -->
				<div class="col-sm-10 col-lg-6 col-xl-4">
					<!-- <article class="my-3">
						<div class="box-qr">
							<h4 class="fs-0 color-4"><img src="assets/images/logos/bkc.png" width="15"> BKC</h4>
							<img src="assets/images/ex_qr.png" alt="QR-code" width="130" />
							<p onclick="copyToAddress('#copyAddress')" class="address mt-3 text-center" data-aleft="eee">
								<span id="copyAddress" class="text-address">0xee1EE5fc40574dD02373F877aFE60b944e81Fc12</span> <span class="text-copy"><?=$dic['Charge_copy']?></span></p>
						</div>
					</article> -->

					<!-- when selected bkp -->
					<article class="my-3 <?=$coin=="bkp"?"block-important":""?>" id="article-bkp">
						<div class="box-qr">
							<h4 class="fs-0 color-4"><img src="assets/images/logos/bkp.png" width="15"> BKP</h4>
							<img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?=urlencode($rowMember['UID'])?>&choe=UTF-8" title="UID" width="130"/>
							<p onclick="copyToAddress('#copyAddress2')" class="address mt-3 text-center" data-aleft="eee">
								UID : <span id="copyAddress2" class="text-address"> <?=$rowMember['UID']?></span> <span class="text-copy"><?=$dic['Wallet_uid_copy']?></span></p>
						</div>
					</article>

<?
for ($i=0; $i<count($코인); $i++){
	if($코인[$i]=="bkp"){
		continue;
	}


if(get_코인_wallet_address($코인[$i], $json)){
?>
					<!-- when selected bkp end -->

					<!-- when selected xrp -->
					<article class="my-3 <?=$coin==$코인[$i]?"block-important":""?>" id="article-<?=$코인[$i]?>">
						<div class="box-qr">
							<h4 class="fs-0 color-4"><img src="assets/images/logos/<?=$코인[$i]?>.png" width="15"> <?=strtoupper($코인[$i])?></h4>
							<img src="https://chart.googleapis.com/chart?chs=250x250&cht=qr&chl=<?=urlencode(get_코인_wallet_address($코인[$i], $json))?>&choe=UTF-8" title="get_코인_wallet_address($코인[$i], $json)" width="130"/>
							<p onclick="copyToAddress('#copyAddress3')" class="address mt-3 text-center" data-aleft="eee">
								<span id="copyAddress3" class="text-address"><?=get_코인_wallet_address($코인[$i], $json)?></span><br>
								<? if(get_blockchain_tag($코인[$i],$json)){?>
								<span class="color-1"><?=get_blockchain_tag($코인[$i],$json)?></span><br>
								<?}?>
								<span class="text-copy"><?=$dic['Charge_copy']?></span>
								</p>
						</div>
					</article>
					<!-- when selected xrp end -->

<?}else{?>

					<!-- no wallet -->
					<article class="my-3 <?=$coin==$코인[$i]?"block-important":""?>" id="article-<?=$코인[$i]?>">
						<div class="box-qr">
							<h4 class="fs-0 color-4"><img src="assets/images/logos/<?=$코인[$i]?>.png" width="15"> <?=strtoupper($코인[$i])?></h4>
							<p class="address mt-3 text-center"><span><?=$dic['Charge_no_wallet']?></span></p>
							<a href="javascript:make_wallet('<?=$코인[$i]?>');" title="get address" class="btn btn-outline-gray btn-sm mt-3"><?=$dic['Charge_wallet']?></a>
						</div>
					</article>
					<!--//지갑이 없을 때-->
<?}?>

<?}?>

					<article class="list-coin-img">
						<p class="color-6 fs--1 mb-2 text-left"><i class="color-8 fas fa-arrow-alt-circle-down"></i> <?=$dic['Charge_select_wallet']?></p>
						<ul class="clearfix" id="coin-list">
							<!--클릭시 li에 active class 추가-->
<? for ($i=0; $i<count($코인); $i++){?>
							<li data-코인="<?=$코인[$i]?>" <?=$coin == $코인[$i]?'class="active"':''?>>
								<img src="assets/images/logos/<?=$코인[$i]?>.png" width="28">
								<h4 class="coin-name"><?=$dic['Charge_'.$코인[$i]]?><span><?=strtoupper($코인[$i])?></span></h4>
							</li>
<?}?>
						</ul>
					</article>
					<div class="my-3">
						<a href="javascript:void(0)" onClick="alert('<?=$dic['Coming_soon']?>')" title="받은 내역보기" class="btn-block btn btn-info fs-0"><?=$dic['Charge_receive']?></a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
</body>
<script>
	$(function(){
		$("#coin-list li").click(function(){
			$("#coin-list li").removeClass("active");
			$(this).addClass("active");
			top.location.href = "receive.php?coin="+$(this).attr("data-코인");
		});
	});

	//지갑주소복사
	function copyToAddress(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).html()).select();
		document.execCommand("copy");
		$temp.remove();
		alert('지갑주소를 복사했습니다.');
	}

	$(function(){
//		$("#article-<?=$coin?>").show();
	});
</script>
<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>