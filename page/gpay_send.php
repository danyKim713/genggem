<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
	<? include "./inc_Head.php"; ?>

<script>
/*
	function go_GEP_전송신청(){
		var 전송할GEP수량 = $("#전송할GEN수량").val();

		$.post("_ajax_gep_send.php",{
			전송할GEN수량: 전송할GEN수량
		},function(data){
			if(data == "MANDATORY_ERROR"){
				alert('전송할 G-PAY 수량을 입력해주세요.');
				$("#전송할GEP수량").focus();
			}else if(data == "NOT_INTEGER"){
				alert('전송할 G-PAY 수량을 정수로 입력해주세요.');
				$("#전송할GEP수량").val('');
				$("#전송할GEP수량").focus();
			}else if(data == "LESS_THAN"){
				alert('전송할 G-PAY 수량이 최소수량(100 G-PAY)보다 작습니다.');
				$("#전송할GEN수량").val('');
				$("#전송할GEN수량").focus();
			}else if(data == "NOT_ENOUGH"){
				alert('전송할 G-PAY 수량이 전화가능 G-PAY수량보다 많습니다.');
				$("#전송할GEP수량").val('');
				$("#전송할GEP수량").focus();
			}else if(data == "SUCCESS"){
				alert('성공적으로 G-PAY가 전송되었습니다.');
				top.location.href = "gpay_send_confirm.php";
			}
		});
	}
*/
</script>

<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[Wallet_wallet];
?>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<script src="/common/script/regexp.js"></script>
<script>
        var chk = false;

        $(document).ready(function () {

            $(document).on('blur', '#txtUID', function(e) {

                if ($.trim($(this).val()) == "") {
                    $('#txtUID').val('');
                    return;
                }

                $.ajax({
                    url: './_ajax_member_uid_confirm.php',
                    type: 'post',
                    data: {
                        txtUID: $('#txtUID').val()
                    },
                    datatype: 'text',
                    success: function(Data) {


                        Data = $.trim(Data);
                        arrData = Data.split("@");

                        if (arrData[0] == "FAILED") {
                            alert(arrData[1]);
                            $('#txtUID').val('');
                        } else if (arrData[0] == "SUCCESS") {
                            $('#divName').html(arrData[1])
                            chk = true;
                        }

                    }

                });


            });

            $(document).on('click', '#btnSend', function(e) {
                var form_data = new FormData($('#frmPay')[0]);
                var pval = $.trim($('#txtGPay').val());

                if ($.trim($('#txtUID').val()) == "") {
                    alert("전송받는 분의 UID를 입력하세요.");
                    $('#txtUID').val('');
                    return;
                }

                if (!chk) {
                    alert("전송받는 분의 UID는 존재하지 않는 UID입니다.");
                    $('#txtUID').val('');
                    return;
                }

                if (pval == "") {
                    alert("전송할 G-PAY의 수량을 입력하세요.");
                    $('#txtGPay').val('');
                    $('#txtGPay').focus();
                    return;
                }

                if (pattern_N.test(pval)) {  
                    alert("전송할 G-PAY의 수량은 숫자만 입력할 수 있습니다.");
                    $('#txtGPay').val('');
                    $('#txtGPay').focus();
                    return;
                }

                if (parseInt(pval) < 100) {
                    alert("전송가능 최소 G-PAY 수량은 100 GP 이상입니다.");
                    $('#txtGPay').val('');
                    $('#txtGPay').focus();
                    return;
                }

                if (parseInt(pval) > <?=$rowMember["gpay"]?>) {
                    alert("전송할 G-PAY가 보유한 G-PAY 보다 큽니다.");
                    $('#txtGPay').val('');
                    $('#txtGPay').focus();
                    return;
                }

                if (confirm("G-PAY를 전송 하시겠습니까?"))                {

                    $.ajax({
                        url: './_ajax_gpay_send_action.php',
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
                                alert('전송이 완료되었습니다');
                                $(location).attr('href', './gpay_send_confirm.php?txtRecordNo='+arrData[1])
                            }

                        },
                        error: function(res) {
                            alert('G-PAY 전송 오류가 발생했습니다.');
                        }   					
                    });
                }

            });

        });
</script>
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

			 <!--GEP 충전신청-->
				<div class="box-round mt-3 mb-2">
					<div class="d-flex align-items-center">
						<h2 class="mr-auto mb-0 fw-600">G-PAY 전송/선물하기</h2>
						<a href="gpay_history.php"  title="이용내역" class="btn btn-xs btn-info">이용내역</a>
					</div>
					<div class="box-change display-table text-center mt-3" style="border: 5px solid #f0f1f4;">
						<div class="display-table-cell p-3">
							<label for="" class="fs-005 fw-600 mb-0">G-PAY 총보유금액</label>
							<p class="fs-05 mb-0 fw-600 color-secondary2"><?=number_format($rowMember['gpay'])?> <small>GP</small></p>
						</div>
					</div>

					
					<div class="mt-2">
						<!-- GEP 포인트로 충전시 -->
                        <form name='frmPay' id='frmPay'>
                        <input type="hidden" name="txtGPay" class="txtGPay" value="">

						<div id="gep">
							<div class="my-2">
								<input type="text" class="form-control background-10" placeholder="받는사람 UID를 입력해 주세요." id="txtUID" name="txtUID">
							</div>
							<div class="my-2">
								<input type="text" class="form-control background-10" placeholder="전송할 G-PAY(GEP) 수량을 입력해 주세요." id="txtGPay" name="txtGPay">
							</div>
							<div class="fs--1">* 전송가능 최소 G-PAY(GP) 수량은 100 GP 이상입니다.<br>
							* 받으실분의 카페핸즈 UID를 입력 해 주세요.</div>
							<div class="d-flex align-items-center mt-2">
								<h3 class="coin-name">받는사람 이름 : <span id="divName">홍길동</span></h3>
							</div>
						</div>
                        </form>
						<!-- GEP 포인트로 충전시 끝 -->


						<button type="button" id="btnSend" class="btn btn-primary btn-block fs-005  mt-3">G-PAY 전송하기</button>
					</div>
					<!--//GEP 충전시 끝-->
				</div>			
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
		alert('<?=$dic[Wallet_copy_alert]?>');
	}
</script>
<script>
	$('.nav_bottom li[data-name="wallet"]').addClass('active');
</script>

</html>