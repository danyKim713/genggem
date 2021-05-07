<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
	<? include "./inc_Head.php"; ?>
		<link rel="stylesheet" href="assets/css/sub.css">
<?
if(!$store_code){
	alert('스토어 정보가 없습니다. 잘못된 접근입니다.');
	header("Location: /");
	exit;
}


$_TITLE = $dic[Wallet_pay_title];

$query = "select * from tbl_store where store_code = '$store_code'";
$rowStore = db_select($query);

if(!$_SESSION['_api_secret']){

	$_SESSION['_store_code'] = $store_code;

	?>
	<script>
		top.location.href = "exchange_login.php?go=<?=$_SERVER['PHP_SELF']?>";			
	</script>	
	<?
	exit;
}

require "_inc_wallet_information.php";

$json = json_decode($response, true);

error_debug($json);

if($json['error']!="" || $json['message']=="Unauthenticated."){
	$_SESSION['_store_code'] = $store_code;
	header("Location:exchange_login.php?go=".$_SERVER['PHP_SELF']);
	exit;
}

if(!$_GET['store_code']){
	$store_code = $_SESSION['_store_code'];
}


$query = "select * from tbl_store where store_code = '$store_code'";
$rows = db_select($query);
?>

<script>
	var 지불코인;
	var 코인현재가격; 
	var 지불화폐총금액;

	$(function(){
		$(".coin-select-li").click(function(e){
			$(".coin-select-li").removeClass("active");
			$(this).addClass("active");
			지불코인 = $(this).data("coin");
			$(".지불코인").html(지불코인);

			$("#결제금액원화").keyup();
		});


		$("#결제금액원화").keyup(function(e){
			var market = "krw";
			$(".coin-select-li").each(function(i){
				if($(this).hasClass("active")){
					지불코인 = $(this).data("coin");
					debug(지불코인);
				}
			});
			if(지불코인 == "bkc"){
				url = "_ajax_krw_usd_currency.php";
			}else{
				url = "_ajax_current_price_max_buy_at_specific_market.php";
			}
			$.post(url,{
				market: market,
				coin: 지불코인
			},function(data){
				debug(data);
				코인현재가격 = data;
				
				결제할금액 = $("#결제금액원화").val();

				$("#결제할금액원화").html(자리수시세가격포맷팅(결제할금액,0));

				지불화폐총금액 = 결제할금액 / 코인현재가격;
				$("#지불화폐총금액").html(자리수시세가격포맷팅(지불화폐총금액,0));

				$(".지불코인").html(지불코인);

				$("#적립포인트").html(지불화폐총금액 * <?=$rowStore['cash_point_rate']?> * 0.01);
			});

		});
	});

	function biko_payment_confirm(){

		적립포인트 = 지불화폐총금액 * <?=$rowStore['cash_point_rate']?> * 0.01;

		$.post("_ajax_franchise_pay_action.php", {
			reg_member_id: '<?=$rowStore['reg_member_id']?>',
			coin: 지불코인,
			원화결제금액: $("#결제금액원화").val(),
			지불화폐총금액: 지불화폐총금액,
			적립포인트: 적립포인트
		}, function(data){
			if(data == "NOT_ENOUGH_BALANCE"){
				alert('잔액이 충분하지 않습니다.');
			}else if(data == "EXCEED_TODAY"){
				alert("금일 한도를 초과하였습니다.");
			}else if(data == "OVER_ONCE"){
				alert("1회 한도를 초과하였습니다.");
			}else if(data == "FAIL"){
				alert("오류가 발생했습니다.");
			}else if(data == "SUCCESS"){
				alert("결제가 성공되었습니다.");
				top.location.href = "biko_payment_confirm.php";
			}
		});
	}
</script>

			<body>
				<? include "./inc_Top.php"; ?>
					<section class="wrap-wallet wrap-cryptosend py-0">
						<div class="container header-top">
							<div class="row align-items-center justify-content-center">
								<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
									<div class="p-3 bg-gradient-primary color-white">
										<h2 class="font-2 fs-0 fw-400 mb-0">가맹점명<span class="bar opacity-75"></span><small><?=$rows['store_name']?></small><span class="bar opacity-75"></span><small>(스토어코드 : <?=$rows['store_code']?>)</small></h2>
									</div>

									<article class="mt-3 p-3">
										<div class="form-group">
											<label class="fw-400" for="">결제할 금액&#40;원화로 입력해 주세요&#41;</label>
											<input class="form-control text-left" id="결제금액원화" name="결제금액원화" type="number" placeholder="지불할 결제 금액을 입력해 주세요." />
										</div>

										<div class="form-group">
											<label class="fw-400" for="">결제할 화폐를 선택해 주세요.</label>
											<div class="list-coin-img text-center">
												<ul class="clearfix">

<?
$결제가능코인배열 = array("bkp","bkc","bkb","btc","eth","cwi");

for ($i=0; $i<sizeof($결제가능코인배열); $i++){
	$코인명 = $결제가능코인배열[$i];
	$코인명대문자 = strtoupper($코인명);
?>
													<!--클릭시 li에 active class 추가-->
													<li class="coin-select-li <? if($i==0){ echo 'active';}?>" data-coin="<?=$코인명?>">
														<img src="assets/images/logos/<?=$코인명?>.png" width="28">
														<h4 class="coin-name"><?=get_코인_available_balance(strtolower($코인명),$json)?><span><?=$코인명대문자?></span></h4>
													</li>
<?}?>


													<?/**<li>
														<img src="assets/images/logos/bkc.png" width="28">
														<h4 class="coin-name">123,124.00<span>BKC</span></h4>
													</li>
													<li class="active">
														<img src="assets/images/logos/bkb.png" width="28">
														<h4 class="coin-name">1,245,245,00<span>BKB</span></h4>
													</li>
													<li>
														<img src="assets/images/logos/btc.png" width="28">
														<h4 class="coin-name">1.12345678<span>BTC</span></h4>
													</li>
													<li>
														<img src="assets/images/logos/eth.png" width="28">
														<h4 class="coin-name">201,1205<span>ETH</span></h4>
													</li>
													<li>
														<img src="assets/images/logos/cwi.png" width="28">
														<h4 class="coin-name">354,546.00<span>CWI</span></h4>
													</li>
													**/?>
												</ul>
											</div>
										</div>

										<div class="mb-3">
											<label class="fw-400" for="">결제 정보 확인</label>
											<div class="border-box p-3 fs-005">
												<ul>
													<li class="row">
														<div class="col-6 color-6">결제할 금액</div>
														<div class="col-6 text-right font-2"><span id="결제할금액원화"></span> <small>원</small></div>
													</li>
													<!-- <li class="row mt-2">
														<div class="col-6 color-6">결제 수수료</div>
														<div class="col-6 text-right font-2">0.10 <small>BKB</small></div>
													</li> -->
													<li class="row mt-2 fw-600">
														<div class="col-6">지불화폐 총금액</div>
														<div class="col-6 text-right font-2 color-primary"><span id="지불화폐총금액"></span> <small><span class="지불코인"></span></small></div>
													</li>
													<hr class="color-10 border-dashed" />
													<li class="row mt-2 fs--1">
													<!-- 아래 적립포인트는 관리자/마스터 설정이나 가맹점 자체 적립포인트 설정 금액을 적용합니다 -->
														<div class="col-6 color-7">적립포인트</div>
														<div class="col-6 text-right font-2 color-7">&#40;+&#41; <span class=""><span id="적립포인트"></span></span> <small><span class="지불코인"></span></small></div>
													</li>
												</ul>
											</div>
										</div>
										<!-- <div class="form-group">
							<label class="fw-400" for="">OTP 인증</label>
							<input class="form-control text-left" id="" name="" type="password" placeholder="OTP번호를 입력해 주세요." />
						</div> -->
									</article>
									<div class="my-1 mx-3 mb-5">
										<a href="javascript:biko_payment_confirm();" class="btn-block btn btn-primary fs-0">결제하기</a>
									</div>
								</div>
							</div>
						</div>
					</section>

					<? include "./inc_Bottom.php"; ?>
			</body>
</html>