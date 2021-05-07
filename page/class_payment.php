<? 
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

// 쿠폰
$query  = " SELECT B.c_id, B.쿠폰명, B.할인금액    \n";
$query .= " FROM   tbl_coupon \n";
$query .= " WHERE  사용여부 = 'AD005001'   \n";   
$resultCoupon = db_query($query);   

// 레슨목록
$query  = " SELECT A.l_id, A.member_id, A.l_title, A.l_tag, A.l_price, A.마일리지, A.l_area, A.l_intro, B.c_id, B.쿠폰명, B.할인금액    \n";
$query .= " FROM    tbl_lesson  A LEFT OUTER JOIN tbl_coupon B  ON  A.쿠폰사용여부 = 'AD005001' AND B.사용여부 = 'AD005001' AND A.쿠폰 = B.c_id \n";
$query .= " WHERE  l_id = '{$strRecordNo}'   \n";
$query .= " AND      sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
$rowLesson = db_select($query);   


// 회원의 적립금 잔액 구하기
$query  = " SELECT balance \n";
$query .= " FROM   sysT_MemberMileage    \n";
$query .= " WHERE  member_uid = '{$rowMember["UID"]}'  \n";
$query .= " ORDER BY mm_id DESC LIMIT 1 ";
$rowMileage = db_select($query);


// 오더ID(주문번호) 생성
$strUniqueID = make_uniq_id_prefix('ODR');

// 주문번호가 23자리가 아니면 
if (strlen($strUniqueID) != 23) {
    msg_page("비정상적인 접근입니다.");
    exit;
}

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<script src="/common/script/regexp.js"></script>
<script src="https://cdn.bootpay.co.kr/js/bootpay-3.0.2.min.js" type="application/javascript"></script>
<link rel="stylesheet" href="assets/css/sub.css">
<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
		<h2 class="header-title text-center">결제하기</h2>
	</header>
	<section class="wrap-channelmade py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center mb-5">
				<div class="col-sm-10 col-lg-8 col-xl-6 p-3">
					<p class="my-3 fs-05 text-center">주문 클래스명: <span class="color-primary fw-600"><?=$rowLesson["l_title"]?></span></p>
                    <form name="frmPayment" id="frmPayment" method="post">
                    <input type="hidden" name="txtRecordNo" id="txtRecordNo" value="<?=$strRecordNo?>">
                    <input type="hidden" name="txtOPrice" id="txtOPrice" value="<?=$rowLesson["l_price"]?>">
					<input type="hidden" name="txtPrice" id="txtPrice" value="<?=$rowLesson["l_price"]?>">
					<input type="hidden" name="txtSaveMileage" id="txtSaveMileage" value="<?=$rowLesson['마일리지']?>"> <? // 적립될 적립금 ?>
                    <input type="hidden" name="txtCoupon" id="txtCoupon" value="<?=$rowLesson['c_id']?>">
                    <input type="hidden" name="txtCouponPrice" id="txtCouponPrice" value="<?=$rowLesson['할인금액']?>">
                    <input type="hidden" name="txtGEP" id="txtGEP" value="<?=$rowMember['gpay']?>">
                    <input type="hidden" name="txtOrderID" id="txtOrderID" value="<?=$strUniqueID?>">

					<div class="mt-4">
						<label class="fs-0">결제수단을 선택해 주세요.</label>
						<div class="list-price d-flex text-center">
							<div class='col-6 p-0 radiobox'>
								<input type="radio" id="rdoPayment1" name="rdoPayment" value="LOPAYBNK" class="invisible"/>
								<label for="rdoPayment1" class="d-block">
									<div class="card border color-9 mr-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">무통장입금</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">농협</h2>
											<p class="fw-400 fs--1 color-5">302-1450-9326-91 <br> (예금주: 카페핸즈)</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>
<? /*
							<div class='col-4 p-0 radiobox'>
								<input type="radio" id="rdoPayment2" name="rdoPayment" value="LOPAYVBN" class="invisible"/>
								<label for="rdoPayment2" class="d-block">
									<div class="card border color-9 mr-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">가상계좌</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">가상계좌결제</h2>
											<p class="fw-400 fs--1 color-5">가상계좌를 <br>이용한 결제</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>
*/ ?>
							<!-- <div class='col-4 p-0 radiobox'>
								<input type="radio" id="rdoPayment3" name="rdoPayment" value="LOPAYCAD" class="invisible"/>
								<label for="rdoPayment3" class="d-block">
									<div class="card border color-9">
										<div class="card-header">
											<h4 class="m-0 fs-005">신용카드</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">신용카드결제</h2>
											<p class="fw-400 fs--1 color-5">신용카드로 안전하게<br> 즉시 결제</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div> -->
							<div class='col-6 p-0 radiobox'>
								<input type="radio" id="rdoPayment4" name="rdoPayment" value="LOPAYGEN" class="invisible"/>
								<label for="rdoPayment4" class="d-block">
									<div class="card border color-9 ml-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">G-PAY</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">G-PAY 결제</h2>
											<p class="fw-400 fs--1 color-5">G-PAY로 결제시 <br>포인트 3% 추가적립 됩니다.</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>

							<?/*<div class='col-3 p-0 radiobox'>
								<input type="radio" id="rdoPayment5" name="rdoPayment" value="LOPAYCEL" class="invisible"/>
								<label for="rdoPayment5" class="d-block">
									<div class="card border color-9 ml-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">휴대폰</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">휴대폰 소액결제</h2>
											<p class="fw-400 fs--1 color-5">휴대폰을<br>이용한 결제</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>
							*/?>
						</div>
					</div>

					<div class="form-group mt-4 mb-4">
						<ul class="list-wallet">
							<li class="box-ver2 py-3 mb-2">
								<div class="row  align-items-center justify-content-center m-0">
									<div class="col-3 p-1">
										<h3 class="coin-name">클래스 금액</h3>
									</div>
									<div class="col-8 p-0">
										<span class="color-primary fs-05 fw-600"  id="결제금액표시" data-결제금액="<?=$rowLesson["l_price"]?>"><?=number_format($rowLesson["l_price"])?>원</span>
									</div>
								</div>
							</li>
						</ul>
					</div>

					<div class="box-round mt-3 mb-3">
						<div class="box-change display-table text-center" style="border: 5px solid #f0f1f4;">
							<div class="display-table-cell p-3">
								<label for="" class="fs-005 fw-600 mb-0">G-PAY 보유금액</label>
								<p class="fs-05 mb-0 fw-600" ><?=number_format($rowMember['gpay'])?> <small>GP</small></span></p>
							</div>
							<div class="display-table-cell p-3">
								<label for="" class="fs-005 fw-600 mb-0">G-Point 보유수량</label>
								<p class="fs-05 mb-0 fw-600" id="보유적립금표시" data-보유적립금="<?=$rowMember["gpoint"]?>"><?=number_format($rowMember['gpoint'])?> <small>Point</small></span></p>
							</div>
						</div>
					</div>

					<!-- <div class="mt-3">
						<label for="" class="mr-2">결제금액</label>
						<span class="color-primary fs-05 fw-600"  id="결제금액표시" data-결제금액="<?=$rowLesson["l_price"]?>"><?=number_format($rowLesson["l_price"])?>원</span>
					</div> -->
					<div class="mt-3">
						<!-- <label for="" class="mr-2">보유 GPOINT</label>
						<span class="color-primary fs-1 fw-600" id="보유적립금표시" data-보유적립금="<?=$rowMember["gpoint"]?>"><?=number_format($rowMember["gpoint"])?></span> point<br> -->
						<label for="" class="mr-2 mt-2">사용할 G-POINT</label>
						<input type="text" name="txtMileage" id="txtMileage" maxlength="10" class="form-control" placeholder="사용할 G-POINT를 입력해 주세요." />
						<label for="" class="fs--1 mr-2 mt-2">* 1회 사용가능한 최대 포인트는 50,000 Point 입니다.</label>
					</div>

					<div class="mt-3 border-top" <? if (trim($rowLesson["할인금액"]) == "") echo "style='display:none'" ?>>
						<label for="" class="mr-2">쿠폰금액</label>
						<span class="color-primary fs-1 fw-600" id="쿠폰금액표시" data-쿠폰금액="<?=($rowLesson["할인금액"] == "") ? "0" : $rowLesson["할인금액"]; ?>"><?=number_format($rowLesson["할인금액"])?>원</span>
					</div>
					<div class="mt-3 border-top">
						<label for="" class="mr-2">실결제금액</label>
						<span class="color-danger fs-1 fw-600" id="실결제금액표시"><?=number_format($rowLesson["l_price"] - $rowLesson["할인금액"])?>원</span>
					</div>

					<div class="con-article background-white p-3 mt-3 border-top border-left border-right">
						<? include "_terms3".($_COOKIE['dic_lang']!="ko"?"_en":"").".php";?>
					</div>
					<div class="py-2 border-top color-10">
						<div class="checkbox check-square">
							<input type="checkbox" id="chkAgree" name="chkAgree" class="invisible 동의" data-alert="<?=$dic['Privacy_alert']?>">
							<label for="chkAgree" class="color-5 fs--1 mb-0 fw-400"><i class="biko-check color-5 mr-1"></i> 결제약관에 동의합니다<span class="color-6">&#40;<?=$dic['Essential']?>&#41;</span></label>
						</div>
					</div>
                    </form>					
					<div class="mt-4 mb-3">
<!--						<a href="class_pay_confirm.php" class="btn-block btn btn-primary fs-0">결제하기</a> -->
						<button id="btnPayment" class="btn-block btn btn-danger fs-0">결제하기</button>
					</div>
				</div>
				
			</div>
		</div>
	</section>

</body>
<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');

    var 실결제금액 = $('#txtPrice').val();

	$(document).ready(function(){
        // 문의글 삭제 클릭시
        $(document).on('click', '#btnPayment', function(event) {
			var myMileage = parseInt($("#보유적립금표시").data("보유적립금"));
			var useMileage = parseInt($("#txtMileage").val()); 

            var strPaymentMethod = "";
			if (!$('input:radio[name=rdoPayment]').is(':checked')) {
				alert("결제수단을 선택해주세요."); 
				return;
			}

			if (!$("#chkAgree").is(":checked")) {
				alert("결제약관 동의에 체크해 주세요."); 
				return;
			}

			$('#txtPrice').val(실결제금액);
            // 결제수단이 무통장 입금이거나 GEP이면 PG를 거치치 않고 결제처리함.
            // 다른결제 수단이 추가되면 아래 if문에 추가할것
			if ($('input:radio[name=rdoPayment]:checked').val() == "LOPAYBNK") {   // 무통장입금

    			if (confirm("결제를 진행하시겠습니까?")) {
                    goPayment('0');
                    return;
    			} else {
					return;
				}

            } else if ($('input:radio[name=rdoPayment]:checked').val() == "LOPAYGEN") {  // GEP

                var nPrice = parseInt($('#txtPrice').val(), 10)
                var nGep = parseInt($('#txtGEP').val(), 10)

                if (nPrice > nGep) {
                    alert("보유한 G-PAY가 결제금액보다 적습니다. 충전 후 결제 해 주세요.");
                    return;
                }

    			if (confirm("결제를 진행하시겠습니까?")) {
                    goPayment('0');
                    return;
    			} else {
					return;
				}

<? /*
            } else if ($('input:radio[name=rdoPayment]:checked').val() == "LOPAYVBN") {  //가상계좌이면 결제수단값 변경
                strPaymentMethod = "vbank";
*/ ?>
			} else if ($('input:radio[name=rdoPayment]:checked').val() == "LOPAYCAD") {   // 카드이면 결제수단값 변경
                strPaymentMethod = "card";
            } else if ($('input:radio[name=rdoPayment]:checked').val() == "LOPAYCEL") {   // 휴대폰소액결제이면 결제수단값 변경
                strPaymentMethod = "phone";
            } 


            if (strPaymentMethod == "") {
                alert("결제수단이 선택되지 않았습니다. 다시 선택해주세요.");
                return;
            }

			if (confirm("결제를 진행하시겠습니까?")) {

                //실제 복사하여 사용시에는 모든 주석을 지운 후 사용하세요
                BootPay.request({
                    price: $('#txtPrice').val(), //실제 결제되는 가격
                    application_id: "5ef084b78f075100278d8f28",
                    name: '<?=$rowLesson["l_title"]?>', //결제창에서 보여질 이름
                    pg: '',
                    method: strPaymentMethod, //결제수단, 입력하지 않으면 결제수단 선택부터 화면이 시작합니다.
                    show_agree_window: 0, // 부트페이 정보 동의 창 보이기 여부
                    items: [
                        {
                            item_name: '<?=$rowLesson["l_title"]?>', //상품명
                            qty: 1, //수량
                            unique: '<?=$rowLesson["l_id"]?>', //해당 상품을 구분짓는 primary key
                            price: <?=$rowLesson["l_price"]?>, //상품 단가
                            cat1: '', // 대표 상품의 카테고리 상, 50글자 이내
                            cat2: '', // 대표 상품의 카테고리 중, 50글자 이내
                            cat3: '', // 대표상품의 카테고리 하, 50글자 이내
                        }
                    ],
                    user_info: {
                        username: '<?=$rowMember['name']?>',
                        email: '<?=$rowMember['email']?>',
                        addr: '',
                        phone: '<?=$rowMember['hp']?>'
                    },
                    order_id: '<?=$strUniqueID?>', //고유 주문번호로, 생성하신 값을 보내주셔야 합니다.
                    params: {callback1: '그대로 콜백받을 변수 1', callback2: '그대로 콜백받을 변수 2', customvar1234: '변수명도 마음대로'},
                    account_expire_at: '<?=date("Y-m-d",mktime(0,0,0,date("m"),date("d")+7,date("Y")))?>', // 가상계좌 입금기간 제한 ( yyyy-mm-dd 포멧으로 입력해주세요. 가상계좌만 적용됩니다. )
                    extra: {
                        start_at: '<?=date("Y-m-d")?>', // 정기 결제 시작일 - 시작일을 지정하지 않으면 그 날 당일로부터 결제가 가능한 Billing key 지급
                        end_at: '2022-05-10', // 정기결제 만료일 -  기간 없음 - 무제한
                        vbank_result: 1, // 가상계좌 사용시 사용, 가상계좌 결과창을 볼지(1), 말지(0), 미설정시 봄(1)
                        quota: '0,2,3' // 결제금액이 5만원 이상시 할부개월 허용범위를 설정할 수 있음, [0(일시불), 2개월, 3개월] 허용, 미설정시 12개월까지 허용
                    }
                }).error(function (data) {
                    alert('결제가 실패했습니다.');
                    //결제 진행시 에러가 발생하면 수행됩니다.
                    console.log(data);
                }).cancel(function (data) {
                    alert('결제가 취소되었습니다.');
                    //결제가 취소되면 수행됩니다.
                    console.log(data);
                }).ready(function (data) {
                    // 가상계좌 입금 계좌번호가 발급되면 호출되는 함수입니다.
                    console.log(data);
                }).confirm(function (data) {
                    //결제가 실행되기 전에 수행되며, 주로 재고를 확인하는 로직이 들어갑니다.
                    //주의 - 카드 수기결제일 경우 이 부분이 실행되지 않습니다.
                    console.log(data);
                    var enable = true; // 재고 수량 관리 로직 혹은 다른 처리
                    if (enable) {
                        BootPay.transactionConfirm(data); // 조건이 맞으면 승인 처리를 한다.
                    } else {
                        BootPay.removePaymentWindow(); // 조건이 맞지 않으면 결제 창을 닫고 결제를 승인하지 않는다.
                    }
                }).close(function (data) {
                    // 결제창이 닫힐때 수행됩니다. (성공,실패,취소에 상관없이 모두 수행됨)
                    console.log(data);
                }).done(function (data) {
                    //결제가 정상적으로 완료되면 수행됩니다
                    //비즈니스 로직을 수행하기 전에 결제 유효성 검증을 하시길 추천합니다.
                    console.log("SUCCESS");
                    console.log(data);
                    goPayment(data);
                });	


			}
        });

        // 사용적립금 입력시
        $(document).on('blur', '#txtMileage', function(event) {
			var myMileage = parseInt($("#보유적립금표시").data("보유적립금"));
			var nCoupon = parseInt($("#쿠폰금액표시").data("쿠폰금액"));
			var useMileage = parseInt($("#txtMileage").val()); 

            var nPaymentAmount = parseInt($('#결제금액표시').data("결제금액"));

            if (pattern_N_D.test($(this).val())) {  // 사용적립금이 숫자가 아닐 경우
				alert("사용할 GPOINT는 숫자만 입력할 수 있습니다.");
				$(this).val('');

				$('#실결제금액표시').html((nPaymentAmount - nCoupon).toString().replace(regexp, ',') + "원"); 
				return;
			} else if ($.trim($(this).val()) =="") {  // 사용적립금이 빈 공백일 경우

				$('#실결제금액표시').html((nPaymentAmount - nCoupon).toString().replace(regexp, ',') + "원");
				return;
			}


			if (useMileage <= 0) {
				alert('사용할 GPOINT는 0보다 커야 합니다.');
				$('#txtMileage').val('');
				$('#txtMileage').focus();
				return;
			}

			if (useMileage > 50000) {
				alert('GPOINT는 50,000point까지 사용 가능합니다.');
				$('#txtMileage').val('');
				$('#txtMileage').focus();
				return;
			}

			if (myMileage < useMileage) {
				alert('보유한 GPOINT보다 사용하는 GPOINT가 많습니다.');
				$('#txtMileage').val('');
				$('#txtMileage').focus();
				return;
			}

			if ((nPaymentAmount - nCoupon) < useMileage) {
				alert("사용할 GPOINT가 결제할 금액보다 많습니다.");
				$('#txtMileage').val('');
				$('#txtMileage').focus();
				return;
			}

<? 
	if (trim($rowLesson["할인금액"]) != "") {
?>
			// 실결제금액 = 결제금액 - 사용적립금 - 쿠폰할인금액
			실결제금액 = nPaymentAmount - useMileage - nCoupon;
<?
    } else {
?>
			// 실결제금액 = 결제금액 - 사용적립금
			실결제금액 = nPaymentAmount - useMileage;
<?
    }
?>			


			$('#실결제금액표시').html(실결제금액.toString().replace(regexp, ',') + "원")

         });
	});

    function goPayment(jsonString) {
		var form_data = new FormData($('#frmPayment')[0]);

		if(jsonString != "0"){
			var receipt_id = jsonString.receipt_id;
			form_data.append("txtReceiptID", receipt_id);

		}else{
			form_data.append("txtReceiptID", "");
		}

		$.ajax({
			url: "./class_payment_action.php",
			type: "POST",
			data: form_data,
			processData: false,
			contentType: false,
			success: function(Data) {
                Data = $.trim(Data);
                arrData = Data.split("@");

                if (arrData[0] == "SUCCESS") {
					alert('성공적으로 구매가 이루어졌습니다.');

                    $(location).attr('href', 'class_pay_confirm.php?txtRecordNo='+arrData[1]);
                } else {
                    alert(Data);
                }
			},       
			error: function(res) {
				alert('결제 오류가 발생했습니다.');
			}       
		});

    }

</script>

<? include "./inc_Bottom_class.php"; ?>

<script>
	$('.nav_bottom li[data-name="classlist"]').addClass('active');
</script>
</html>