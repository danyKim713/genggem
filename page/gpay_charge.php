<!DOCTYPE HTML>
<html lang="en">
<? 
include "./inc_program.php"; 

include "./inc_Head.php"; 




?>
		<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[Wallet_wallet];
?>

<body class="mb-5">
<? 
include "./inc_nav.php"; 

$query = "select exchange_rate from tbl_site_config ";
$rowConfig = db_select($query);

if ($rowConfig[exchange_rate] == 0 || $rowConfig[exchange_rate] == "") {
    $nExchangeRate = 0;
} else {
    $nExchangeRate = $rowConfig[exchange_rate];
}

?>
<script src="/common/script/regexp.js"></script>
<script>
    nExchangeRate = <?=$nExchangeRate?>


        $(document).ready(function () {
            // 충전수단 라디오 버튼 클릭시     
            $('.rdoStatus').bind('click', function(event) {
                if ($(this).val() == "CM516GPT") {
                    $('.divCharge1').show();
                    $('.divCharge2').hide();
                    $('.divCharge3').hide();
                } else if ($(this).val() == "CM516GEN") {
                    $('.divCharge1').hide();
                    $('.divCharge2').show();
                    $('.divCharge3').hide();
                } else if ($(this).val() == "CM516CAS") {
                    $('.divCharge1').hide();
                    $('.divCharge2').hide();
                    $('.divCharge3').show();
                }

            });

            // 수량입력한 후
            $(document).on('keyup', '.txtChargeAmount', function(e) {
                var idx = $('.txtChargeAmount').index(this);
                var nAmount = parseInt($(this).val());

                if (pattern_N.test($(this).val())) {  
                    alert("충전할 수량은 숫자만 입력할 수 있습니다.");
                    $(this).val('');
                    $(this).focus();
                    $('.divAmount').eq(idx).html('GP');
                    return;
                }

                if (idx == 1) {
                    var nPay = nAmount * nExchangeRate;
                    $('.divAmount').eq(idx).html(nPay.toString().replace(regexp, ',') + ' GP');
                    $('.txtGPay').eq(idx).val(nPay);

                } else {
                    var nPay = parseInt($(this).val());
                    $('.divAmount').eq(idx).html(nPay.toString().replace(regexp, ',') + ' GP');
                    $('.txtGPay').eq(idx).val(nPay);
                }

            });

            // 충전하기 버튼 클릭시
            $(document).on('click', '#btnApply', function(e) {
                var chkStatus = $('input:radio[name=rdoStatus]:checked').val();


                if (chkStatus == "CM516GPT") {
                    var form_data = new FormData($('#frmPay1')[0]);

                    pval = $.trim($('#frmPay1 [name=txtChargeAmount]').val()); 
                    pval2 = $.trim($('#frmPay1 [name=txtGPay]').val()); 

                    if (pval == "") {
                        alert("충전할 G-POINT 수량을 입력하세요.");
                        $('#frmPay1 [name=txtChargeAmount]').val('');
                        $('#frmPay1 [name=txtChargeAmount]').focus();
                        return;
                    }

                    if (pattern_N.test(pval)) {  
                        alert("충전할 G-POINT는 숫자만 입력할 수 있습니다.");
                        $('#frmPay1 [name=txtChargeAmount]').val('');
                        $('#frmPay1 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(0).html('GP');
                        return;
                    }


                    if (parseInt(pval) > <?=$rowMember["gpoint"]?>) {
                        alert("충전할 G-POINT가 보유한 G-POINT 수량보다 큽니다.");
                        $('#frmPay1 [name=txtChargeAmount]').val('');
                        $('#frmPay1 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(0).html('GP');
                        return;
                    }

                    if (parseInt(pval2) < 1000) {
                        alert("충전가능 최소 G-PAY 수량은 1,000 GP 입니다.");
                        $('#frmPay1 [name=txtChargeAmount]').val('');
                        $('#frmPay1 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(0).html('GP');
                        return;
                    }

                    if (parseInt(pval2) > 2000000) {
                        alert("최대충전 가능 G-PAY는 2,000,000 GP 입니다.");
                        $('#frmPay1 [name=txtChargeAmount]').val('');
                        $('#frmPay1 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(0).html('GP');
                        return;
                    }


                } else if (chkStatus == "CM516GEN") {
                    var form_data = new FormData($('#frmPay2')[0]);

                    pval = $.trim($('#frmPay2 [name=txtChargeAmount]').val()); 
                    pval2 = $.trim($('#frmPay2 [name=txtGPay]').val()); 

                    if (pval == "") {
                        alert("전송할 GEN 코인 수량을 입력하세요.");
                        $('#frmPay2 [name=txtChargeAmount]').val('');
                        $('#frmPay2 [name=txtChargeAmount]').focus();
                        return;
                    }

                    if (pattern_N.test(pval)) {  
                        alert("전송할 GEN 코인 수량은 숫자만 입력할 수 있습니다.");
                        $('#frmPay2 [name=txtChargeAmount]').val('');
                        $('#frmPay2 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(1).html('GP');
                        return;
                    }

                    if (parseInt(pval) < 100) {
                        alert("충전가능 최소 GEN 코인 수량은 100 GEN 입니다");
                        $('#frmPay2 [name=txtChargeAmount]').val('');
                        $('#frmPay2 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(1).html('GP');
                        return;
                    }

                    if (parseInt(pval2) > 2000000) {
                        alert("최대충전 가능 G-PAY는 2,000,000 GP 입니다.");
                        $('#frmPay2 [name=txtChargeAmount]').val('');
                        $('#frmPay2 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(1).html('GP');
                        return;
                    }

                    if ($.trim($('#frmPay2 [name=txtGenTXID]').val()) == "") {
                        alert("GEN코인을 전송한 TXID를 입력해 주세요.");
                        $('#frmPay2 [name=txtGenTXID]').val('');
                        $('#frmPay2 [name=txtGenTXID]').focus();
                        return;
                    }


                } else if (chkStatus == "CM516CAS") {
                    var form_data = new FormData($('#frmPay3')[0]);
                    pval = $.trim($('#frmPay3 [name=txtChargeAmount]').val()); 
                    pval2 = $.trim($('#frmPay3 [name=txtGPay]').val()); 

                    if (pval == "") {
                        alert("충전할 금액을 입력하세요.");
                        $('#frmPay3 [name=txtChargeAmount]').val('');
                        $('#frmPay3 [name=txtChargeAmount]').focus();
                        return;
                    }

                    if (pattern_N.test(pval)) {  
                        alert("충전할 금액은 숫자만 입력할 수 있습니다.");
                        $('#frmPay3 [name=txtChargeAmount]').val('');
                        $('#frmPay3 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(2).html('GP');

                        return;
                    }

                    if (parseInt(pval2) < 1000) {
                        alert("충전가능 최소 G-PAY 금액은 1,000 GP 입니다");
                        $('#frmPay2 [name=txtChargeAmount]').val('');
                        $('#frmPay2 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(2).html('GP');
                        return;
                    }

                    if (parseInt(pval2) > 2000000) {
                        alert("최대충전 가능 G-PAY는 2,000,000 GP 입니다.");
                        $('#frmPay2 [name=txtChargeAmount]').val('');
                        $('#frmPay2 [name=txtChargeAmount]').focus();
                        $('.divAmount').eq(2).html('GP');
                        return;
                    }

                    if ($.trim($('#frmPay3 [name=txtDepositor]').val()) == "") {
                        alert("입금자 이름을 입력하세요.");
                        $('#frmPay3 [name=txtDepositor]').val('');
                        $('#frmPay3 [name=txtDepositor]').focus();
                        return;
                    }


                } else {
                    alert("충전수단을 선택하세요.");
                    return;
                }

                if (confirm("충전신청을 하시겠습니까?"))                {
                    form_data.append("txtChargeMethod", chkStatus);

                    $.ajax({
                        url: './_ajax_gen_charge_action.php',
                        type: 'post',
                        data: form_data,
                        processData: false,
                        contentType: false,
                        success: function(Data) {

                            Data = $.trim(Data);
                            arrData = Data.split("@");

                            if (arrData[0] == "FAILED") {
                                alert(arrData[1]);
                            } else if (arrData[0] == "SUCCESS") {
                                alert(arrData[1]);
                                $(location).attr('href', './gpay_charge_history.php')
                            }
                        },
                        error: function(res) {
                            alert('충전신청 오류가 발생했습니다.');
                        }   					
                    });
                }

            });

        });
</script>
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
		<h2>G-PAY (GP) 충전</h2>
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
										<p onclick="copyToAddress('#copyAddress')" class="address fs--1">
										<i class="fas fa-medal fs--1 color-success ml-1 mt-2"></i> 회원이름 : <?=$rowMember['name']?><br>
										<i class="fas fa-medal fs-005 color-success ml-1 mt-2"></i> 카페핸즈 UID : <span id="copyAddress" class="text-address fw-600"><?=$rowMember['UID']?></span>
										<span class="text-copy">UID 복사</span><br>
										</p>
									</div>
								</div>
							</div>
						</li>
					</ul>
				 </div>
				 <!--//정보-->
<!--<textarea id="aa"></textarea>-->
				 <!--GEP 충전신청-->
				<div class="box-round mt-3 mb-2">
					<div class="d-flex align-items-center">
						<h2 class="mr-auto mb-0">G-Pay (GP) 충전하기</h2>
						<a href="gpay_charge_history.php"  title="거래내역" class="btn btn-xs btn-info">충전내역</a>
				 	</div>
					<div class="form-group mt-2">


						<label>충전수단 선택</label>
						<ul class="list list-border background-white">
							<li class="p-3 d-flex align-items-center">
								<div>
                                    <input type="radio" name="rdoStatus" class="rdoStatus" id="gpay1" value="CM516GPT" />&nbsp;
								</div>
								<h4 class="fs-005 mb-0"><label for="gpay1">G-Point</label></h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div>
                                    <input type="radio" name="rdoStatus" class="rdoStatus" id="gpay2" value="CM516GEN" />&nbsp;
								</div>
								<h4 class="fs-005 mb-0"><label for="gpay2">GEN 코인</label></h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div>
                                    <input type="radio" name="rdoStatus" class="rdoStatus" id="gpay3" value="CM516CAS" />&nbsp;
								</div>
								<h4 class="fs-005 mb-0"><label for="gpay3">현금</label></h4>
							</li>
						</ul>
					</div>




					<!-- G 포인트로 충전시 -->
                    <form name='frmPay1' id='frmPay1'>
                    <input type="hidden" name="txtGPay" class="txtGPay" value="">
					<div class="align-items-center divCharge1" style="display:none;">
						<h2 class="mr-auto mb-0">G-POINT로 충전</h2>
				 	</div>
					<div class="box-change display-table text-center mt-1 divCharge1" style="border: 5px solid #f0f1f4; display:none">
						<div class="display-table-cell p-2">
							<label for="" class="fs-005 fw-600 mb-0">G-POINT</label>
							<p class="fs-0 mb-0 fw-600"><?=number_format($rowMember['gpoint'])?> <small>Point</small></p>
						</div>
						<div class="text-center" style="width:20px;"><img src="assets/images/icon-change.png" width="18" class="mt-3"></div>
						<div class="display-table-cell p-2">
							<label for="" class="fs-005 fw-600 mb-0 color-secondary2">G-PAY</label>
							<p class="fs-0 mb-0 fw-600 color-secondary2"><?=number_format($rowMember['gpay'])?> <small>GP</small></p>
						</div>
					</div>					
					<div class="mt-2 divCharge1" style="display:none">
						<div id="gep">
							<div class="my-2">
								<input type="text" name="txtChargeAmount" class="form-control background-10 txtChargeAmount" placeholder="G-PAY로 충전할 G-POINT 수량을 입력해 주세요" >
							</div>
							<div class="fs--1">* 1,000 G-POINT = 1000 GP = 1,000원 입니다.<br>
                            * 충전가능 최소 G-PAY 수량은 1,000 GP 입니다.<br>
							* 최대충전 가능 G-PAY는 2,000,000 GP 입니다. </div>
							<div class="d-flex align-items-center mt-2">
								<h3 class="coin-name">충전되는 G-PAY 금액</h3>
								<span class="coin-amount ml-auto fw-600 divAmount"> GP</span>
							</div>
						</div>
					</div>
                    </form>
					<!-- G 포인트로 충전시 끝 -->

					<!-- GEN coin으로 충전시 -->
                    <form name='frmPay2' id='frmPay2'>
                    <input type="hidden" name="txtGPay" class="txtGPay" value="">
                    <input type="hidden" name="txtERate" class="txtERate" value="<?=$nExchangeRate?>">
					<div class="align-items-center divCharge2" style="display:none">
						<h2 class="mr-auto mb-0">GEN 코인으로 충전</h2>
				 	</div>
					<div class="box-change display-table text-center mt-1 divCharge2" style="border: 5px solid #f0f1f4; display:none">
						<div class="display-table-cell p-2">
							<label for="" class="fs-005 fw-600 mb-0"><img src="assets/images/logo2.png" width="33"></label>
							<p class="fs-0 mb-0 fw-600">GEN</p>
						</div>
						<div class="text-center" style="width:20px;"><img src="assets/images/icon-change.png" width="18" class="mt-3"></div>
						<div class="display-table-cell p-2">
							<label for="" class="fs-005 fw-600 mb-0 color-secondary2">G-Pay</label>
							<p class="fs-0 mb-0 fw-600 color-secondary2"><?=number_format($rowMember['gpay'])?> <small>원</small></p>
						</div>
					</div>					
					<div class="mt-2 divCharge2" style="display:none">
						<div id="gep">
							<div class="my-2">
								<input type="text" class="form-control background-10 txtChargeAmount" placeholder="전송한 GEN 코인 수량을 입력하세요." name="txtChargeAmount">
							</div>
							<div class="my-2">
								<input type="text" class="form-control background-10" placeholder="GEN코인을 전송한 TXID를 입력해 주세요." name="txtGenTXID">
							</div>
							<div class="fs--1"><p onclick="copyToAddress('#copyAddress2')" class="address fs--1">* GEN 코인 입금 주소: <span id="copyAddress2" class="text-address fw-600">0xb2DA1c6342B76A120473E3EA9452fb97B24c968e</span> <span class="text-copy">주소복사</span><br></div>
							<div class="fs--1">* <strong>100 GEN coin = <?=number_format($nExchangeRate * 100)?> GP = <?=number_format($nExchangeRate * 100)?> 원</strong> 입니다.<br>
                            * 충전가능 최소 GEN 코인 수량은 100 GEN 입니다.<br>
                            * 최대충전 가능 G-PAY는 2,000,000 GP입니다. <br>
							* 반드시 위 주소로 GEN을 전송해 주셔야 합니다.<br>
							* 전송 후 TXID를 꼭 입력해 주시기 바랍니다.<br>
							</div>
							<div class="d-flex align-items-center mt-2">
								<h3 class="coin-name">충전되는 G-PAY 금액</h3>
								<span class="coin-amount ml-auto fw-600 divAmount"> GP</span>
							</div>
						</div>
					</div>
                    </form>
					<!-- 끝 -->
 
					<!-- 현금으로 충전시 -->
                    <form name='frmPay3' id='frmPay3'>
                    <input type="hidden" name="txtGPay" class="txtGPay" value="">
					<div class="align-items-center divCharge3" style="display:none">
						<h2 class="mr-auto mb-0">현금으로 충전</h2>
				 	</div>
					<div class="box-change display-table text-center mt-1 divCharge3" style="border: 5px solid #f0f1f4; display:none">
						<div class="display-table-cell p-2">
							<label for="" class="fs-0 fw-600 mb-0">현금입금</label>
							<p class="fs-005 mb-0 fw-600">(무통장)</p>
						</div>
						<div class="text-center" style="width:20px;"><img src="assets/images/icon-change.png" width="18" class="mt-3"></div>
						<div class="display-table-cell p-2">
							<label for="" class="fs-005 fw-600 mb-0 color-secondary2">G-Pay</label>
							<p class="fs-0 mb-0 fw-600 color-secondary2"><?=number_format($rowMember['gpay'])?> <small>원</small></p>
						</div>
					</div>	
					<div id="cash" class="divCharge3" style="display:none">
						<div class="my-2">
							<input type="text" class="form-control background-10 txtChargeAmount" placeholder="입금(충전)할 금액을 입력해 주세요" name="txtChargeAmount">
						</div>
						<div class="my-2">
							<input type="text" class="form-control background-10" placeholder="입금자 이름을 입력해 주세요." name="txtDepositor">
						</div>
						<div class="fs--1">* 1,000원 = 1,000 GP 입니다.<br>
                        * 충전가능 최소 G-PAY는 1,000 GP 입니다.<br>
						* 최대충전 가능 G-PAY는 2,000,000 GP입니다. <br>
						
						* 충전시 입금계좌 : <strong>농협 302-1450-9326-91 (예금주: 카페핸즈 이은정)</strong><br>
						* 반드시 회원님의 실명으로 입금해 주셔야 합니다.</div>
						<div class="d-flex align-items-center mt-2">
							<h3 class="coin-name">충전되는 G-PAY 금액</h3>
							<span class="coin-amount ml-auto fw-600 divAmount"> GP</span>
						</div>
					</div>
                    </form>
				    <!-- 현금으로 충전시 끝-->


					<button type="button" id="btnApply" class="btn btn-primary btn-block fs-005  mt-3">G-PAY (GP) 충전신청</button>
					
					<!--//GEP 충전시 끝-->
				</div>				

				
				 <? include "./gpay_status.php"; ?>

				</article>
			</div>
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
		alert('<?=$dic[Wallet_copy_alert]?>');
	}
</script>
<script>
	//지갑주소복사
	function copyToAddress2(element) {
		var $temp = $("<input>");
		$("body").append($temp);
		$temp.val($(element).html()).select();
		document.execCommand("copy");
		$temp.remove();
		alert('지갑주소를 복사했습니다.');
	}
</script>
<script>
	$('.nav_category li[data-name="gnb-cloud"]').addClass('active');
	$('.nav_bottom li[data-name="wallet"]').addClass('active');
</script>

</html>