<? 
//	$NO_LOGIN = "Y";
include "./inc_program.php";  

// 할인쿠폰정보 가져오기(사용유무가 '예'일때)
$query = "select * from tbl_promotion where 사용여부 = 'Y' ";
$rowP = db_select($query);

if (trim($rowP['할인금액']) == "") {
	$nDCost = 0;
} else {
	$nDCost = $rowP['할인금액'];
}

?><!DOCTYPE HTML>
<html lang="en">

<? include "./inc_Head.php"; ?>
<script src="/common/script/regexp.js"></script>
<script>
	var 강좌비용 = 0;
	var 적립금 = 0;
	var 총결제금액 = 0;



	function go_결제(){
		if ($.trim($('#신청자이름').val()) == "") {
			alert("신청자이름을 입력하세요.");
			$('#신청자이름').focus()
			return;
		}

		if ($.trim($('#전화번호').val()) == "") {
			alert("전화번호를 입력하세요.");
			$('#전화번호').focus()
			return;
		}

		if ($.trim($('#수강강좌').val()) == "" || $.trim($('#강좌비용표시').html()) == "") {
			alert("수강할 강좌를 선택하세요.");
			$('#수강강좌').focus()
			return;
		}

		if ($.trim($('#연회비').val()) == "" || $.trim($('#연회비표시').html()) == "") {
			alert("연회비를 선택하세요.");
			$('#연회비').focus()
			return;
		}

		if ($.trim($('#문화센터지부').val()) == "") {
			alert("수강할 문화센터 지부를 선택하세요.");
			$('#문화센터지부').focus()
			return;
		}

		if (총결제금액표시 <= 0) {
			alert("총결제금액이 정상적이지 않습니다. 강좌 및 기타부분을 다시 선택해주세요.");
			return;
		}

		$('#강좌비용').val(강좌비용);
		$('#적립금').val(적립금);
		$('#총결제금액').val(총결제금액);

		$('#frmPay').submit();

	}

	function 포인트사용(){
	}


	function 재계산(){
		var 할인금액 = parseInt($("#할인금액").val());

		if (parseInt($("#수강강좌 option:selected").data("강좌비용")) <= 0 || $.trim($("#수강강좌 option:selected").data("강좌비용")) == "") {
			강좌비용 = 0;
			적립금 = 0;
		} else {
			강좌비용 = parseInt($("#수강강좌 option:selected").data("강좌비용"));
			적립금 = parseInt($("#수강강좌 option:selected").data("적립금"));
		}

		if ($.trim($("#연회비 option:selected").val()) == "") {
			연회비 = 0;
		} else {
			연회비 = parseInt($("#연회비 option:selected").val());
		}

		$('#강좌비용표시').html("\\ "+강좌비용.toString().replace(regexp, ','));
		$('#적립금표시').html("\\ "+적립금.toString().replace(regexp, ','));
        $('#연회비표시').html("\\ "+연회비.toString().replace(regexp, ','));
//		$('#할인금액').html("\\ "+할인금액.toString().replace(regexp, ',') );
		$('#총결제금액표시').html("\\ "+(강좌비용 + 연회비 - 할인금액).toString().replace(regexp, ','));
		총결제금액 = parseInt(강좌비용 + 연회비 - 할인금액);
	}

	$(function(){
		//$('#수강강좌').val('');
		$('#연회비').val('');
		지부목록();
<?      
		echo (trim($pk_lecture) != "" ?  "재계산()" :  ""); 
?>


	});

	var lat_now;
	var lng_now;
	var is_show = false;

	
	window.setTimeout(function(){
		if(!is_show){
			// 없는 브라우저라면, 
			lat_now = "37.5642135";
			lng_now = "127.0016985";

			$.post("/page/_ajax_jiboo_list.php",{
				lat: lat_now,
				lng: lng_now
			},function(html){
				is_show = true;
				$("#문화센터지부").html(html);
			});		
		}
	},2000);
	

	function 지부목록(){
		if(navigator.geolocation) { 
			// Geolocation API가 있는 브라우저라면, 
			navigator.geolocation.getCurrentPosition(function(position) { 
				lat_now = position.coords.latitude;
				lng_now = position.coords.longitude; 

				$.post("/page/_ajax_jiboo_list.php",{
					lat: lat_now,
					lng: lng_now
				},function(html){
					is_show = true;
					$("#문화센터지부").html(html);
				});

			});
		} else { 
			// 없는 브라우저라면, 
			lat_now = "37.5642135";
			lng_now = "127.0016985";

			$.post("/page/_ajax_jiboo_list.php",{
				lat: lat_now,
				lng: lng_now
			},function(html){
				is_show = true;
				$("#문화센터지부").html(html);
			});

		}
	}
</script>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
	<!-- ##### Breadcrumb Area Start ##### -->
    <!-- ##### background Area Start ##### -->
    <div class="breadcrumb-area">
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg1.jpg);">
            <h2>About HANC</h2>
        </div>
    </div>
	<section id="m_bnr2">
		<div>
			<ul>
				<li class="wow fadeInDown">
					<a href="hanc_lecture.php">
						<div><i class="fa fa-list" aria-hidden="true"></i></div>
						<p class="txt_tit">강좌안내</p>
					</a>
				</li>
				<li class="wow fadeInUp">
					<a href="hanc_apply.php">
						<div><i class="fa fa-user" aria-hidden="true"></i></div>
						<p class="txt_tit">수강신청</p>
					</a>
				</li>
				<li class="wow fadeInDown">
					<!-- <a href="hanc_online.php"> -->
					<a href='javascript:void(0)' title='온라인강좌' onClick="alert('서비스 준비중입니다')">
						<div><i class="fas fa-edit" aria-hidden="true"></i></div>
						<p class="txt_tit">온라인강좌</p>
					</a>
				</li>
				<li class="wow fadeInUp">
					<a href="hanc_my.php">
						<div><i class="fas fa-desktop" aria-hidden="true"></i></div>
						<p class="txt_tit">내강좌관리</p>
					</a>
				</li>
			</ul>
		</div>
	</section>


	<!-- ##### Cart Area Start ##### -->
    <div class="cart-area section-padding-0-100 clearfix">
        <div class="container">
            <div class="row">

                <!-- Coupon Discount -->
                <div class="col-12 col-lg-6">
                    <div class=" mt-50">
					<div class="coupon-discount map-area py-3 px-3 fs--1">
                        <h5><i class="fas fa-question"></i> 문화센터 수강 신청전 확인해 주세요.</h5>
                        <!-- <p><img src="./assets/img/bg-img/hanc_event.jpg"></p> -->
                        <i class="fas fa-check"></i> 한국문화센터 회원이 아니신분은 <font color="#ff0000"><strong>연회비</strong></font>를 함께 결제해 주셔야 합니다.<br>
						&nbsp;&nbsp; (기존 한국문화센터 회원이면서 기간이 유효한 분은 연회비 결제 필요없습니다.)<br>
						<i class="fas fa-check"></i> 연회비는 1년에 1회(최초 50,000원 - 재신청시 30,000원) 납부하며, 납부 후 전체 강좌를 선택하여 수강할 수 있습니다.<br>
						<i class="fas fa-check"></i> 한국문화센터 비회원이 본 수강신청을 접수할 경우 수강신청한 지부회원으로 등록됩니다.<br>
						<i class="fas fa-check"></i> 납부후 회원증이 발급되며, 연회비는 환불되지 않습니다.<br>
						<i class="fas fa-check"></i> 신청하신 강좌는 강좌가 진행되는 모든 지부에서 선택적으로 수강할 수 있습니다.</p>
                    </div>
					</div>
                </div>

                <!-- Cart Totals -->

                <div class="col-12 col-lg-6">
                    <div class="cart-totals-area mt-50">
                        <h5 class="title--">한국문화센터 수강신청/접수</h5>
						<span>수강신청 접수/결제 하시면 관리자 확인후 상담드립니다.</span>
						<form name="frmPay" id="frmPay" action="./hanc_payment.php" method="post" style="display:inline">
						<input type="hidden" name="강좌비용" id="강좌비용" value="">
						<input type="hidden" name="할인금액" id="할인금액" value="<?=$nDCost?>"/>
						<input type="hidden" name="적립금" id="적립금" value="">
						<input type="hidden" name="총결제금액" id="총결제금액" value="">
                        <div class="shipping d-flex justify-content-between">
                            <div class="shipping-address mt-3">
                                <form action="#" method="post">
									<input type="text" name="신청자이름" id="신청자이름" placeholder="신청자이름" value="<?=$rowMember["name"]?>">
									<input type="text" name="전화번호" id="전화번호" placeholder="전화번호" value="0<?=$rowMember["hp"]?>">
                                    <select class="custom-select" name="수강강좌" id="수강강좌" onChange="재계산();">
										<option value="">수강할 강좌를 선택해 주세요.</option>
<?
$query = "select * from tbl_lecture where 사용유무 = 'Y' order by 출력순서 ASC";

$result = db_query($query);

for ($i=0; $i<db_num_rows($result); $i++){
	$row = db_fetch($result);
?>
										<option value="<?=$row['pk_lecture']?>" <?=$pk_lecture==$row['pk_lecture']?"selected":""?> data-강좌비용="<?=$row['강좌비용']?>" data-적립금="<?=$row['마일리지']?>"><?=$row['강좌명']?>-<?=$row['강좌등급']?> (<?=number_format($row['강좌비용'])?>원)</option>
<?}?>						
                                    </select>
									
                                    <select class="custom-select" name="연회비" id="연회비" onChange="재계산();">
                                            <option value="">연회비를 선택해 주세요.</option>
											<option value="0">기존 한국문화센터 지부회원(결제 필요없음)</option>
											<option value="50000">신규회원(50,000원)</option>
											<option value="30000">재가입(30,000원)</option>
                                    </select>
									<span class="fs--1"><strong>수강할 지부 선택</strong><br>
									<i class="fas fa-map-marker-alt"></i> 고객님의 현재위치와 가까운 지부순으로 보여줍니다.</span>
									<select class="form-control" size="1" id="문화센터지부" name="문화센터지부">
										<option value="">수강할 지부를 선택해 주세요.</option>
									</select>
									<textarea class="form-control" name="문의사항" id="문의사항" cols="30" rows="5" placeholder="남기실 메시지나 문의사항이 있을 경우 작성해 주세요."></textarea>
                                    <!-- <button type="submit">Update Total</button> -->
                                </form>
                            </div>
                        </div>

						
						
						<!-- 선택한 강좌 비용 -->
						<div class="subtotal d-flex justify-content-between">
                            <h5>강좌비용</h5>
                            <h5 id="강좌비용표시"></h5>
                        </div>
						<!-- // 선택한 강좌 비용 끝 -->
						<!-- 연회비 선택시에만 보여줌 -->
						<div class="subtotal d-flex justify-content-between">
                            <h5>연회비</h5>
                            <h5 id="연회비표시"></h5>
                        </div>
						<!-- // 연회비 선택 끝 -->
<?
if($rowP['사용여부']=="Y"){
?>
						<!-- 할인 프로모션 진행중일때만 보여줌 -->
						<div class="subtotal d-flex justify-content-between">
                            <h5>할인이벤트</h5>
                            <h5 id="할인금액표시"><font color="#ff0033">\ <?=number_format($rowP['할인금액'])?></font></h5>
                        </div>
						<!-- // 연회비 선택 끝 -->					
<?}?>

                        <!-- 선택한 적립금 -->
						<div class="subtotal d-flex justify-content-between">
                            <h5>적립포인트</h5>
                            <h5 id="적립금표시"></h5>
                        </div>
						<!-- // 선택한 적립금 끝 -->
						
						<!-- 합계 계산 -->
						<div class="total d-flex justify-content-between">
                            <h5>총결제금액</h5>
                            <h5 id="총결제금액표시"></h5>
                        </div>
						<!-- // 합계 계산 끝 -->

                        <div class="checkout-btn mt-3">
                            <a href="javascript:go_결제();" class="btn alazea-btn w-100">결제/수강신청</a>
							<!-- 결제창 링크 payment.php-->
                        </div>
      				    </form>

                    </div>

                </div>

            </div>

        </div>
    </div>
    <!-- ##### Cart Area End ##### -->

    
<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_hanc.php"; ?>
<script>
	$('.nav_bottom li[data-name="coachapply"]').addClass('active');
</script>