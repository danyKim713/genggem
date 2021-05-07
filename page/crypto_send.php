<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[Crypto_send_title];
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

<?
$coin = array(
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
);

$코인 = array(
	"비케이씨",
	"비케이비",
	"비트코인",
	"비트코인캐시",
	"이더리움",
	"리플",
	"씨더블유아이",
	"라이트코인",
	"퀀텀",
	"대시",
	"이오스",
	"제트티씨",
);
?>

<script>
	var coin = "bkb";
	$(function(){
		$(".coin-class").click(function(){
			
			coin = $(this).attr("data-coin");

			$(".coin-class").removeClass("active");
			$(this).addClass("active");

			코인변경이벤트();
		});

		$(".coin-class").each(function(){
			if($(this).attr("data-coin")=="bkb"){
				$(this).click();
			}
		});

		$("#amount").blur(function(){
			코인변경이벤트();
		});
	});
	
	var coin종류 = new Array();
	var coin보유금액 = new Array();
	var coin전송가능금액 = new Array();

	var 보유금액 = 0;
	var 전송가능금액 = 0;
	var 거래소수수료 = 0;

	var 전송금액 = 0;
	var 앱수수료 = 0;
	var 총수수료 = 0;
	var 전송후금액 = 0;

<? for ($i=0; $i<sizeof($coin); $i++){?>
	coin종류[<?=$i?>] = "<?=$coin[$i]?>";
	coin보유금액[<?=$i?>] = "<?=get_코인_balance($coin[$i], $json)?>";
	coin전송가능금액[<?=$i?>] = "<?=get_코인_available_balance($coin[$i], $json)?>";
<?}?>

	var coin종류수수료용 = new Array();
	var coin수수료 = new Array();
	var coin거래소수수료 = new Array();
<? 
$query = "select * from tbl_coin_fee";
$result = db_query($query);
for ($i=0; $i<mysqli_num_rows($result); $i++){
	$row = mysqli_fetch_array($result);
?>
	coin종류수수료용[<?=$i?>] = "<?=$row['coin']?>";
	coin수수료[<?=$i?>] = "<?=$row['coin_send_withdraw_fee']?>";
	coin거래소수수료[<?=$i?>] = "<?=$row['exchange_fee']?>";
<?
}
?>

	function find_거래소수수료(pCoin){
		for (i=0; i<coin종류수수료용.length; i++){
			if(pCoin == coin종류수수료용[i]){
				return coin거래소수수료[i];
			}
		}
	}

	function find_수수료(pCoin){
		for (i=0; i<coin종류수수료용.length; i++){
			if(pCoin == coin종류수수료용[i]){
				return coin수수료[i];
			}
		}
	}

	function find_보유금액(pCoin){
		for (i=0; i<coin종류.length; i++){
			if(pCoin == coin종류[i]){
				return coin보유금액[i];
			}
		}
	}

	function find_전송가능금액(pCoin){
		for (i=0; i<coin종류.length; i++){
			if(pCoin == coin종류[i]){
				return coin전송가능금액[i];
			}
		}
	}

	function 코인변경이벤트(){

		go_show_hide_email_address();

		$(".coin-upper").html(coin.toUpperCase());
		보유금액 = find_보유금액(coin);
		전송가능금액 = find_전송가능금액(coin);
		거래소수수료 = find_거래소수수료(coin);

		$(".보유금액").html(자리수시세가격포맷팅(전송가능금액,8));
		전체앱수수료 = find_수수료(coin)*전송가능금액 / 100;
		debug("전송가능금액:"+전송가능금액);
		debug("전체앱수수료:"+전체앱수수료);
		debug("거래소수수료:"+find_거래소수수료(coin));
		전송가능금액2 = Number(전송가능금액 - find_거래소수수료(coin)) / (1 + find_수수료(coin)/100) ;
//		전송가능금액 = 자리수시세가격포맷팅(전송가능금액,8);
		debug("전송가능금액2:"+전송가능금액2);
		debug("전송가능금액2:"+자리수시세가격포맷팅(전송가능금액2,8));

		
		$(".전송가능금액").html(자리수시세가격포맷팅(전송가능금액2,8));
		

		$(".거래소수수료").html(거래소수수료);

		전송금액 = $("#amount").val();
		if(전송금액 == ""){
			전송금액 = 0;
		}
		$("#amount").val(전송금액);
		debug("전송금액:"+전송금액);
		앱수수료 = find_수수료(coin)*전송금액 / 100;
		debug("앱수수료:"+앱수수료);
		debug("거래소수수료:"+find_거래소수수료(coin));
		총수수료 = 자리수시세가격포맷팅(Number(앱수수료) + Number(find_거래소수수료(coin)),8);
		$(".총수수료").html(자리수시세가격포맷팅(총수수료,8));

		debug(자리수시세가격포맷팅(Number(총수수료)+Number(전송금액),8));

		전송후금액 = 보유금액 - 전송금액 - 총수수료;
		

	}

	function go_show_hide_email_address(){
		var val = $("#receiver_type option:selected").val();
		$("#email").hide();
		$("#address").hide();

		$("#"+val).show();

		if(val == "address" && (coin == "xrp"  || coin == "eos")){
			$("#destination_tag").show();
		}else{
			$("#destination_tag").hide();				
		}
	}

	$(function(){
		go_show_hide_email_address();
	});

	function crypto_send_confirm(){
		receiver_type = $("#receiver_type option:selected").val();
		email = $("#email").val();
		address = $("#address").val();
		amount = $("#amount").val();
		destination_tag = $("#destination_tag").val();
		otp = $("#otp").val();

		전송가능금액 = 자리수시세가격포맷팅(전송가능금액, 8);

		debug("전송가능금액:"+전송가능금액);
		debug("amount:"+amount);
		debug("총수수료:"+총수수료);
		debug("amount+총수수료:"+자리수시세가격포맷팅(Number(amount)+Number(총수수료),8));

		debug(자리수시세가격포맷팅(Number(총수수료)+Number(전송금액),8));

		$.post("_ajax_crypto_send.php", {
			receiver_type: receiver_type,
			email: email,
			address: address,
			destination_tag: destination_tag,
			amount: amount,
			otp: otp,
			coin: coin,
			전송가능금액: 전송가능금액,
			거래소수수료: 거래소수수료,
			앱수수료: 앱수수료,
			총수수료: 총수수료,
			보유금액: 보유금액,
			전송후금액: 전송후금액
		}, function(data){
			debug("data:"+data);
			 if(data == "MANDATORY_ERROR"){
				alert('필수 정보를 입력하세요.');
				return;
			}if(data == "SAME_TO_ME"){
				alert('본인에게 전송할 수는 없습니다.');
				return;
			}else if(data == "WRONG_AMOUNT"){
				alert('전송할 금액을 정확히 입력해주십시오.');
				return;
			}else if(data == "NOT_ENOUGH_BALANCE"){
				alert('보유량보다 많은 금액을 입력하셨습니다.');
				return;
			}else if(data == "SUCCESS"){
				alert('정상적으로 전송되었습니다.');
				top.location.href = "crypto_send_confirm.php";
			}else{
				alert('오류가 발생했습니다..');
			}
		});
	}

</script>

<body>
	<? include "./inc_Top.php"; ?>
	<section class="wrap-wallet py-0">
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<div class="p-3 bg-gradient-primary color-white">
						<h2 class="font-2 fs-005 fw-300 mb-1">UID <?=$rowMember['UID']?><span class="bar opacity-75"></span><?=$rowMember['name']?></h2>
					<label class="fw-400 mb-0" for=""><?=$dic['Charge_Available']?> BKC</label>
						<span class="font-2 fs-05 fw-600 float-right"><?=소수n자리까지표시(get_TOTAL_BKC_VALUE($json),4)?></span>
					</div>
					<article class="mt-3 p-3">
						<div class="form-group">
							<label class="fw-400" for=""><?=$dic['Crypto_choise_coin']?></label>
							<div class="list-coin-img text-center">
								<ul class="clearfix">

<? for ($i=0; $i<sizeof($coin); $i++){?>
									<li class="coin-class" data-coin="<?=$coin[$i]?>">
										<img src="assets/images/logos/<?=$coin[$i]?>.png" width="28">
										<h4 class="coin-name"><?=$코인[$i]?><span><?=strtoupper($coin[$i])?></span></h4>
									</li>
<?}?>									
								</ul>
							</div>
						</div>

						<article class="mt-3 mb-4" id="section1">
							<label class="fw-400" for=""><span class="coin-upper"></span> 코인보유현황</label>
							<div class="border-box p-3 fs-005">
								<ul>
									<li class="row">
										<div class="col-5 color-6">보유금액</div>
										<div class="col-7 color-6 text-right font-2"><span class="보유금액"></span> <span class="coin-upper"></span></div>
									</li>
									<li class="row mt-2">
										<div class="col-5">전송가능금액</div>
										<div class="col-7 color-primary text-right font-2"><span class="전송가능금액"></span> <span class="coin-upper"></span></div>
									</li>
								</ul>
							</div>
						</article>

						<div class="form-group">
							<label class="fw-400" for=""><?=$dic['Wallet_receive_info']?></label>
							<select class="form-control mb-2" name="receiver_type" id="receiver_type" onChange="go_show_hide_email_address();">
								<option value="email"><?=$dic['Wallet_bitkoex_ID']?></option>
								<option value="address">받는 사람 전자지갑 주소</option>
							</select>
							<input class="form-control text-left" id="email" name="email" type="email" placeholder="받는사람의 빗코엑스 이메일을 입력해 주세요." />
							<p class="find_name font-2 fs--1 mt-1"></p>
							<input class="form-control text-left" id="address" name="address" type="text" placeholder="받는사람의 전자지갑주소를 입력해 주세요." />
							<input class="form-control text-left" id="destination_tag" name="destination_tag" type="text" placeholder="받는사람의 코드를 입력해 주세요." />
						</div>


						<div class="form-group">
							<label class="fw-400" for=""><?=$dic['Crypto_amount']?></label>
							<!--전송코인 표시-->
							<input class="form-control text-left" id="amount" name="amount" type="number" placeholder="<?=$dic['Crypto_amount_write']?>"  />
							<p class="font-2 fs--1 ml-2 mt-1">전송수수료 = <!--보내는 코인단위 및 수수료--><span class="총수수료"></span> <span class="coin-upper"></span></p>
						</div>
						<div class="form-group">
							<label class="fw-400" for=""><?=$dic['Service_otp']?></label>
							<input class="form-control text-left" id="otp" name="otp" type="password" placeholder="<?=$dic['Service_otp2']?>" />
						</div>
					</article>
					<div class="mx-3 mb-4">
						<!--전송코인 표시-->
						<a href="javascript:crypto_send_confirm();" class="btn-block btn btn-primary fs-0"><?=$dic['Service_crypto_send']?></a>
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