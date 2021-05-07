<? 
include "./inc_program.php";

$strName       = $_POST["신청자이름"];
$strTel        = $_POST["전화번호"];
$strLecture    = $_POST["수강강좌"];
$nLectureCost  = $_POST["강좌비용"];
$nDiscountCost = $_POST["할인금액"];
$nMileage      = $_POST["적립금"];
$nYearCost     = $_POST["연회비"];
$strHancID     = $_POST["문화센터지부"];
$strMemo       = $_POST["문의사항"];
$nTotCost      = $_POST["총결제금액"];

// 구매할 강좌내역 가져오기
$query  = " SELECT pk_lecture, 분류명, 강좌명, 마일리지, 사용유무, 카페코드, 강좌등급, 강좌비용     \n";
$query .= " FROM   tbl_lecture    \n";
$query .= " WHERE  pk_lecture = '{$strLecture}'   \n";
$rowLecture = db_select($query);   

/*
// 회원의 적립금 잔액 구하기
$query  = " SELECT balance \n";
$query .= " FROM   sysT_MemberMileage    \n";
$query .= " WHERE  member_uid = '{$rowMember["UID"]}'  \n";
$query .= " ORDER BY mm_id DESC LIMIT 1 ";
$rowMileage = db_select($query);   
*/

// 오더ID(주문번호) 생성
$strUniqueID = make_uniq_id_prefix_Date('cfc');

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
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-3">
					<p class="my-3 fs-05 text-center">주문상품명: <span class="color-primary fs-1 fw-600"><?=$rowLecture["강좌명"]."[".$rowLecture["강좌등급"]."]"?></span></p>
                    <form name="frmPayment" id="frmPayment" method="post">
                    <!--<input type="text" name="txtRecordNo" id="txtRecordNo" value="<?//=$strRecordNo?>">-->
                    <input type="hidden" name="txtOPrice" id="txtOPrice" value="<?=($nLectureCost + $nYearCost - $nDiscountCost)?>">
                    <input type="hidden" name="txtPrice" id="txtPrice" value=""> <? // 결제금액 ?>
                    <input type="hidden" name="txtGEP" id="txtGEP" value="<?=MemGep($rowMember['member_id'])?>">
                    <input type="hidden" name="txtOrderID" id="txtOrderID" value="<?=$strUniqueID?>">  <? // 주문번호 ?>
                    <input type="hidden" name="txtName" id="txtName" value="<?=$strName?>"> <? // 신청자이름 ?>
                    <input type="hidden" name="txtTel" id="txtTel" value="<?=$strTel?>"> <? // 전화번호 ?>
                    <input type="hidden" name="txtLecture" id="txtLecture" value="<?=$strLecture?>"> <? // 수강강좌 ?>
					<input type="hidden" name="txtSaveMileage" id="txtSaveMileage" value="<?=$nMileage?>"> <? // 적립될 적립금 ?>
					<input type="hidden" name="txtLectureCost" id="txtLectureCost" value="<?=$nLectureCost?>"> <? // 강좌비용 ?>
					<input type="hidden" name="txtDiscountCost" id="txtDiscountCost" value="<?=$nDiscountCost?>"> <? // 할인쿠폰 ?>
					<input type="hidden" name="txtYearCost" id="txtYearCost" value="<?=$nYearCost?>"> <? // 연회비 ?>
					<input type="hidden" name="txtHancID" id="txtHancID" value="<?=$strHancID?>"> <? // 문화센터지부 ?>
					<input type="hidden" name="txtMemo" id="txtMemo" value="<?=$strMemo?>"> <? // 문의사항 ?>
					<div class="mt-4">
						<label class="fs-0">결제수단을 선택해 주세요.</label>
						<div class="list-price d-flex text-center">
							<div class='col-4 p-0 radiobox'>
								<input type="radio" id="rdoPayment1" name="rdoPayment" value="LOPAYBNK" class="invisible"/>
								<label for="rdoPayment1" class="d-block">
									<div class="card border color-9 mr-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">무통장입금</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">국민은행</h2>
											<p class="fw-400 fs--1 color-5">599701040683<br> (예금주: 미니위크 민승연)</p>
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
							<div class='col-4 p-0 radiobox'>
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
							</div>
							<div class='col-4 p-0 radiobox'>
								<input type="radio" id="rdoPayment4" name="rdoPayment" value="LOPAYGEN" class="invisible"/>
								<label for="rdoPayment4" class="d-block">
									<div class="card border color-9 ml-1">
										<div class="card-header">
											<h4 class="m-0 fs-005">GPAY</h4>
										</div>
										<div class="card-block">
											<h2 class="fw-400 color-1 fs-0">GPAY</h2>
											<p class="fw-400 fs--1 color-5">GPAY를 <br>이용한 결제</p>
										</div>
										<div class="card-footer">
											<span class="btn btn-outline-secondary btn-sm">선택</span>
										</div>
									</div>
								</label>
							</div>
							<!-- <div class='col-3 p-0 radiobox'>
								<input type="radio" id="rdoPayment5" name="rdoPayment" value="LOPAYCEL" class="invisible"/>
								<label for="rdoPayment5" class="d-block">
									<div class="card border color-9">
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
							</div> -->
						</div>
					</div>

					<div class="mt-3">
						<label for="" class="mr-2">결제금액</label>
						<span class="color-primary fs-1 fw-600" id="결제금액표시" data-결제금액="<?=$nLectureCost+$nYearCost?>"><?=number_format($nLectureCost+$nYearCost)?>원</span>
					</div>

					<!-- 포인트결제 선택시 보여줌 -->
					<div>
						<label for="" class="mr-2">보유 G-PAY</label>
						<span class="color-primary fs-1 fw-600" id="보유GPAY표시" data-보유GPAY="<?=$rowMember['gpay']?>"><?=number_format($rowMember['gpay'])?> <small>GP</small></span>
					</div>
					<!-- // -->

					<div class="mt-3 border-top">
						<label for="" class="mr-2">보유 적립금</label>
						<span class="color-primary fs-1 fw-600" id="보유적립금표시" data-보유적립금="<?=$rowMember["gpoint"]?>"><?=number_format($rowMember["gpoint"])?></span> point<br>
						<label for="" class="mr-2">적립금 사용금액</label>
						<input type="text" name="txtMileage" id="txtMileage" maxlength="10" class="form-control" placeholder="사용할 GPOINT를 입력해 주세요." />
					</div>
					<div class="mt-3 border-top">
						<label for="" class="mr-2">할인쿠폰</label>
						<span class="color-primary fs-1 fw-600" id="할인쿠폰표시"><?=number_format($nDiscountCost)?>원</span>
					</div>

					<div class="mt-3 border-top">
						<label for="" class="mr-2">실결제금액</label>
						<span class="color-primary fs-1 fw-600" id="실결제금액표시"><?=number_format($nTotCost)?>원</span>
					</div>
					<div class="con-article background-white p-3 mt-3">
						<? include "_terms3".($_COOKIE['dic_lang']!="ko"?"_en":"").".php";?>
					</div>
					<div class="py-2 border-top color-10">
						<div class="checkbox check-square">
							<input type="checkbox" id="chkAgree" name="chkAgree" class="invisible 동의" data-alert="<?=$dic['Privacy_alert']?>">
							<label for="chkAgree" class="color-5 fs--1 mb-0 fw-400"><i class="biko-check color-5 mr-1"></i> 결제약관에 동의합니다<span class="color-6">&#40;<?=$dic['Essential']?>&#41;</span></label>
						</div>
					</div>
                    </form>					
					<div class="mt-4">
<!--						<a href="class_pay_confirm.php" class="btn-block btn btn-primary fs-0">결제하기</a> -->
						<button id="btnPayment" class="btn-block btn btn-primary fs-0">결제하기</button>
					</div>
				</div>
				<? include "./inc_Bottom_lesson.php"; ?>
			</div>
		</div>
	</section>
<!--	<textarea id="aa"></textarea>   -->
</body>

<script>

	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');

    var 실결제금액 = <?=$nTotCost?>;
	$(document).ready(function(){
        // 결제 수단 클릭시
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
                    price: <?=$nTotCost?>, //실제 결제되는 가격
                    application_id: "5ef084b78f075100278d8f28",
                    name: '<?=$rowLecture["강좌명"]?>', //결제창에서 보여질 이름
                    pg: '',
                    method: strPaymentMethod, //결제수단, 입력하지 않으면 결제수단 선택부터 화면이 시작합니다.
                    show_agree_window: 0, // 부트페이 정보 동의 창 보이기 여부
                    items: [
                        {
                            item_name: '<?=$rowLecture["강좌명"]?>', //상품명
                            qty: 1, //수량
                            unique: '<?=$rowLecture["pk_lecture"]?>', //해당 상품을 구분짓는 primary key
                            price: <?=$rowLecture["강좌비용"]?>, //상품 단가
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
			var nDCost = parseInt($('#txtDiscountCost').val());
			var useMileage = parseInt($("#txtMileage").val()); 

            var nPaymentAmount = parseInt($('#결제금액표시').data("결제금액"));


            if (pattern_N_D.test($(this).val())) {  // 사용적립금이 숫자가 아닐 경우
				alert("사용할 GPOINT는 숫자만 입력할 수 있습니다.");
				$(this).val('');
				$('#실결제금액표시').html((nPaymentAmount - nDCost).toString().replace(regexp, ',')+'원')
				return;
			} else if ($.trim($(this).val()) =="") {  // 사용적립금이 빈 공백일 경우
				$('#실결제금액표시').html((nPaymentAmount - nDCost).toString().replace(regexp, ',')+'원')
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
				alert('보유한 GPOINT보다 사용할 GPOINT가 많습니다.');
				$('#txtMileage').val('');
				$('#txtMileage').focus();
				return;
			}

			if ((nPaymentAmount - nDCost) < useMileage) {
				alert("사용할 GPOINT가 결제할 금액보다 많습니다.");
				$('#txtMileage').val('');
				$('#txtMileage').focus();
				return;
			}

			// 실결제금액 = 결제금액 - 할인금액 - 사용적립금
			실결제금액 = parseInt($('#결제금액표시').data("결제금액")) - nDCost - useMileage;
		
			$('#실결제금액표시').html(실결제금액.toString().replace(regexp, ',')+'원')
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
			url: "./hanc_payment_action.php",
			type: "POST",
			data: form_data,
			processData: false,
			contentType: false,
			success: function(Data) {

//				$('#aa').val(Data)
//				return;
                Data = $.trim(Data);
                arrData = Data.split("@");

                if (arrData[0] == "SUCCESS") {
					alert('강좌신청이 성공적으로 이루어졌습니다.');
                    $(location).attr('href', 'hanc_apply_confirm.php?txtRecordNo='+arrData[1]);
                } else {
                    alert(Data);
                }
			},       
			error: function(res) {
				alert('강좌신청(결제 오류)가 발생했습니다.');
			}       
		});

    }

</script>
</html>
