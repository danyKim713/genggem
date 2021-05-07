<? 
include "./inc_program.php";  


// 문화센터 신청강좌중 '입금대기' 주문중에 신청일보다 5일 지난 주문은 자동으로 '주문취소(입금유효기간초과)'로 변경
$query  = " SELECT *, DATE_ADD(신청일, INTERVAL 5 DAY)    \n";
$query .= " FROM   tbl_lecture_order      \n";
$query .= " WHERE  member_id = '{$rowMember['member_id']}'   \n";
$query .= " AND    주문상태 = 'HNCPAWAI'   \n";
$query .= " AND    DATE_ADD(신청일, INTERVAL 5 DAY) < NOW()   \n";

$resultProcess = db_query($query);


$strDT = Date('Y-m-d H:i:s');

for ($i=0; $i<db_num_rows($resultProcess); $i++){
	$row = db_fetch($resultProcess);

	// 해당 강좌를 주문취소(입금유효기간초과)로 수정하고 
	$query  = " UPDATE tbl_lecture_order SET    \n";
	$query .= "        주문상태 = 'HNCPACA1', ";  // 주문취소(입금유효기간초과)
    $query .= "        상태내역      = CONCAT(상태내역, '<br>>> ', '{$strDT}', ' 주문취소(입금유효기간초과)'),  \n";
	$query .= "        관리자메시지   = '입금유효기간초과로 주문이 취소되었습니다.',  \n";
	$query .= "        수정자   = '{$rowMember["member_id"]}',  \n";
	$query .= "        수정일     = '{$strDT}'  \n";
	$query .= " WHERE  o_id = '{$row["o_id"]}'  \n";  // 강좌신청ID
    $result = db_query($query);


	// 해당 강좌 신청시 사용한 마일리지가 있다면 마일리지를 다시 회원에게 되돌려준다.
	if ($row["사용마일리지"] > 0) {  
		//$query = " SELECT * FROM sysT_MemberMileage WHERE member_uid = '{$rowMember["UID"]}' ORDER BY mm_id DESC LIMIT 1 ";
		//$rowM = db_select($query);

		// 잔액 = 마지막잔액 + 사용마일리지
		$nBlance = $rowMember["gpoint"] + $row["사용마일리지"] ;

		$query  = " INSERT INTO sysT_MemberMileage SET    \n";
		$query .= "        member_uid  = '{$rowMember["UID"]}',  \n";
		$query .= "        income      = '{$row["사용마일리지"]}',  \n";
		$query .= "        expenditure = '0',  \n";
		$query .= "        balance     = '{$nBlance}',  \n";  
		$query .= "        od_id       = '{$row["o_id"]}',  \n";  // 강좌신청ID
		$query .= "        memo        = '강좌신청취소-입금기간초과',  \n";
		$query .= "        isrt_user   = '{$rowMember["member_id"]}',  \n";
		$query .= "        isrt_dt     = '{$strDT}'  \n";

		$resultM = db_query($query);

        $query  = " UPDATE tbl_member SET  \n";
        $query .= "        gpoint  = '{$nBlance}' ";
        $query .= " WHERE  member_id   = '{$rowMember["member_id"]}'  \n";
        $resultMem = db_query($query);
	}
}

// 주문정보
$query  = " SELECT A.*, B.강좌명, B.강좌등급, C.cd_nm    \n";
$query .= " FROM   tbl_lecture_order A, tbl_lecture B, sysT_CommonCode C     \n";
$query .= " WHERE  A.member_id = '{$rowMember['member_id']}'   \n";
$query .= " AND    A.강좌PK = B.pk_lecture   \n";
$query .= " AND    A.payment_flg = CONCAT(C.major_cd, C.minor_cd)   \n";
$query .= " ORDER BY 신청일 DESC ";
//echo $query;
$resultOrder = db_query($query);


?>
<!DOCTYPE HTML>
<html lang="en">

<? include "./inc_Head.php"; ?>
<script type="text/javascript">
function popct(url, w, h) {
popw = (screen.width - w) / 2;
poph = (screen.height - h) / 2;
popft = 'height=' + h + ',width=' + w + ',top=' + poph + ',left=' + popw;
window.open(url, '', popft);
}
</script>
<body class="mb-5">
<? include "./inc_nav.php"; ?>
    <div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg1.jpg);">
            <h2>My class - Hanc</h2>
        </div>
    </div>
    <!-- ##### background Area End ##### -->


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


	<div class="container">		
		<div class="single-widget-area">
			<!-- Title -->
			<div class="widget-title ">
				<h4>my class - hanc</h4>
				<p>고객님이 신청한 한국문화센터 강좌 목록입니다.</p>
			</div>
		</div>
	</div>



	<section class="about-us-area">
        <div class="container">
            
			<!-- 내역반복시작 -->
<?
for ($i=0; $i<db_num_rows($resultOrder); $i++){
	$row = db_fetch($resultOrder);
    
	$strColor = "";  // 주문상태 색상
	if ($row["주문상태"] == "HNCPACA1" || $row["주문상태"] == "HNCPACA2") {  // 주문취소(입금유효기간초과) 또는 주문취소
		$strColor = 'color="#cf0044"';
	} else 	if ($row["주문상태"] == "HNCPACOM" || $row["주문상태"] == "HNCPAROK") {  // 결제완료 또는 환불완료
		$strColor = 'color="#0033cc"';
	} 
?>
			<div class="row justify-content-between border-top py-3">

                <div class="col-12 col-lg-4 ">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h5><font color="#cf0044">주문번호: <?=$row["order_id"]?></font></h5>
                        <p><i class="fas fa-book-open color-5"></i> 신청강좌명 : <?=$row["강좌명"]?> - <?=$row["강좌등급"]?></p>
						<p class="fw-500 fs-005"><i class="fas fa-clock color-5"></i> <?=$row["신청일"]?></p>
						<p class="fw-500 fs-005"><i class="fas fa-edit color-5"></i> <?=(trim($row["관리자메시지"]) == "") ? "no message" : $row["관리자메시지"]; ?></p>
                    </div>
                    
                </div>

                <div class="col-12 col-lg-8">
                    <div class="alazea-benefits-area">
                        <div class="row">
                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>결제정보: <font <?=$strColor?>><?=showNameCommonCode($row["주문상태"])?></font> <small>(<?=$row["cd_nm"]?>)</small></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-cart-plus color-5"></i> 상품금액 : <?=$row["강좌비용"]?>원 / 연회비 <?=$row["연회비"]?>원<br>
									<i class="fas fa-credit-card color-5"></i> 결제금액 : <?=number_format($row["총결제금액"])?>원 <br>
									&nbsp;&nbsp;&nbsp;&nbsp;(할인쿠폰 <?=number_format($row["할인쿠폰"])?>원 / 사용포인트 <?=number_format($row["사용마일리지"])?>point)</p>
                                </div>
                            </div>

                            <!-- Single Benefits Area -->
<?
	if ($row["주문상태"] == "HNCPACA1" || $row["주문상태"] == "HNCPACA2") {  // 주문취소(입금유효기간초과) 또는 주문취소
?>
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: <font color="#cf0044">주문취소</font></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : -<br>
									<i class="fas fa-map-marker-alt color-5"></i> - 
									</p>
                                </div>
                            </div>
<?
	} else if ($row["주문상태"] == "HNCPAROK") {  // 환불완료
?>
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: 환불완료</h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : -<br>
									<i class="fas fa-map-marker-alt color-5"></i> - 
									</p>
                                </div>
                            </div>
<?
	} else { 
		if (trim($row["배정문화센터PK"]) == "" || trim($row["배정문화센터PK"]) == "0") {		// 배정전일 경우
?>
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: 배정전</h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : 배정전<br>
									<i class="fas fa-map-marker-alt color-5"></i> 배정이되면 상세정보가 보여집니다.
									</p>
                                </div>
                            </div>
<?
		} else {  // 배정완료일 경우
			// 지부정보
			$query  = " SELECT 지부명, 주소, 전화번호, 위도, 경도   \n";
			$query .= " FROM   tbl_jiboo     \n";
			$query .= " WHERE  pk_jiboo = '{$row["배정문화센터PK"]}'   \n";
			//echo $query;
			$rowJiboo = db_select($query);			
?>
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: 배정완료</h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : <?=$rowJiboo["지부명"]?>  <a href="callto:<?=$rowJiboo["전화번호"]?>" class="color-5"> <?=$rowJiboo["전화번호"]?> (<i class="fas fa-phone-square"></i> 전화걸기)</a> 
									<br>
									<i class="fas fa-map-marker-alt color-5"></i> <?=$rowJiboo["주소"]?> <a href="hanc_map.php?name=<?=rawurlencode($rowJiboo['지부명'])?>&address=<?=rawurlencode($rowJiboo['주소'])?>" title="" onClick="popct(this.href, '500', '700');return false" class="clearfix"> <button type="button" class="btn btn-info3 btn-xs fw-400 ml-1">지도보기</button></a>
									</p>
                                </div>
                            </div>
<?
		}
	} 
?>
                        </div>
                    </div>
                </div>
            </div>
<?
}
?>
<? /*
			<!-- // -->
            <div class="row justify-content-between border-top py-3">
                <div class="col-12 col-lg-4 ">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h5><font color="#cf0044">-----주문번호: cfc200612-126</font></h5>
                        <p><i class="fas fa-book-open color-5"></i> 신청강좌명 : 홈패션 - 기초</p>
						<p class="fw-500 fs-005"><i class="fas fa-clock color-5"></i> 2020-06-12 13:10</p>
						<p class="fw-500 fs-005"><i class="fas fa-edit color-5"></i> no message</p>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="alazea-benefits-area">
                        <div class="row">
                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>결제정보: <font color="#0033cc">결제완료</font> <small>(신용카드)</small></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-cart-plus color-5"></i> 상품금액 : 70,000원 / 연회비 30,000원<br>
									<i class="fas fa-credit-card color-5"></i> 결제금액 : 90,000원 (포인트 10,000 사용)</p>
                                </div>
                            </div>

                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: 배정완료</h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : 강동지부  <a href="" class="color-5"> (02-0000-0000)</a> <a href="">[지도보기]</a><br>
									<i class="fas fa-map-marker-alt color-5"></i> 서울시 강동구 강동동 123. 카페빌딩 2층 202호 
									</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
			<!-- 내역반복시작 // 결제 취소 // 주문후 5일이내 미결제시 자동 주문취소됨 -->
			<div class="row justify-content-between border-top py-3">
                <div class="col-12 col-lg-4 ">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h5><font color="#cf0044">-----주문번호: cfc200608-356</font></h5>
                        <p><i class="fas fa-book-open color-5"></i> 신청강좌명 : 홈패션 - 기초</p>
						<p class="fw-500 fs-005"><i class="fas fa-clock color-5"></i> 2020-06-12 13:10</p>
						<p class="fw-500 fs-005"><i class="fas fa-edit color-5"></i> 주문취소 처리되었습니다.</p>
                    </div>
                    
                </div>

                <div class="col-12 col-lg-8">
                    <div class="alazea-benefits-area">
                        <div class="row">
                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>결제정보: <font color="#cf0044">주문취소</font> <small>(결제유효기간초과)</small></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-cart-plus color-5"></i> 상품금액 : 70,000원 / 연회비 30,000원<br>
									<i class="fas fa-credit-card color-5"></i> 결제금액 : 0 (포인트 10,000 환불완료)</p>
                                </div>
                            </div>

                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: <font color="#cf0044">주문취소</font></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : -<br>
									<i class="fas fa-map-marker-alt color-5"></i> - 
									</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
			<!-- // -->

			<!-- 내역반복시작 ㅣㅣ 무통장일떄 -->
			<div class="row justify-content-between border-top py-3">
                <div class="col-12 col-lg-4 ">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h5><font color="#cf0044">주문번호: cfc200612-236</font></h5>
                        <p><i class="fas fa-book-open color-5"></i> 신청강좌명 : 홈패션 - 기초</p>
						<p class="fw-500 fs-005"><i class="fas fa-clock color-5"></i> 2020-06-12 13:10</p>
						<p class="fw-500 fs-005"><i class="fas fa-edit color-5"></i> 감사합니다. 입금확인되었습니다.</p>
                    </div>
                    
                </div>

                <div class="col-12 col-lg-8">
                    <div class="alazea-benefits-area">
                        <div class="row">
                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>결제정보: <font color="#0033cc">결제완료</font> <small>(무통장)</small></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-cart-plus color-5"></i> 상품금액 : 70,000원 / 연회비 0원<br>
									<i class="fas fa-credit-card color-5"></i> 결제금액 : 70,000원 (포인트 0원 사용)</p>
                                </div>
                            </div>

                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: 배정전</h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : 배정전<br>
									<i class="fas fa-map-marker-alt color-5"></i> 배정이되면 상세정보가 보여집니다.
									</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
			<!-- // -->

			<!-- 내역반복시작 ㅣㅣ 무통장일떄 -->
			<div class="row justify-content-between border-top py-3">
                <div class="col-12 col-lg-4 ">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h5><font color="#cf0044">주문번호: cfc200612-456</font></h5>
                        <p><i class="fas fa-book-open color-5"></i> 신청강좌명 : 홈패션 - 기초</p>
						<p class="fw-500 fs-005"><i class="fas fa-clock color-5"></i> 2020-06-12 13:10</p>
						<p class="fw-500 fs-005"><i class="fas fa-edit color-5"></i> no message</p>
                    </div>
                    
                </div>

                <div class="col-12 col-lg-8">
                    <div class="alazea-benefits-area">
                        <div class="row">
                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>결제정보: 결제전 <small>(무통장)</small></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-cart-plus color-5"></i> 상품금액 : 70,000원 / 연회비 0원<br>
									<i class="fas fa-credit-card color-5"></i> 결제금액 : 70,000원 (포인트 0원 사용)</p>
                                </div>
                            </div>

                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: 배정전</h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : 배정전<br>
									<i class="fas fa-map-marker-alt color-5"></i> 배정이되면 상세정보가 보여집니다.
									</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
			<!-- // -->

			<!-- 내역반복시작 ㅣㅣ 포인트결제 -->
			<div class="row justify-content-between border-top py-3">
                <div class="col-12 col-lg-4 ">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h5><font color="#cf0044">주문번호: cfc200612-123</font></h5>
                        <p><i class="fas fa-book-open color-5"></i> 신청강좌명 : 홈패션 - 기초</p>
						<p class="fw-500 fs-005"><i class="fas fa-clock color-5"></i> 2020-06-12 13:10</p>
						<p class="fw-500 fs-005"><i class="fas fa-edit color-5"></i> 지부에서 별도로 연락을 드릴거에요~</p>
                    </div>
                    
                </div>

                <div class="col-12 col-lg-8">
                    <div class="alazea-benefits-area">
                        <div class="row">
                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>결제정보: <font color="#0033cc">결제완료</font> <small>(GPAY)</small></h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-cart-plus color-5"></i> 상품금액 : 70,000원 / 연회비 30,000원<br>
									<i class="fas fa-credit-card color-5"></i> 결제금액 : 90,000원 (포인트 10,000 사용)</p>
                                </div>
                            </div>

                            <!-- Single Benefits Area -->
                            <div class="col-12 col-sm-6">
                                <div class="single-benefits-area">
                                    <h5>상태: 배정완료</h5>
                                    <p class="fw-500 fs-005"><i class="fas fa-location-arrow color-5"></i> 수강지부 : 강동지부  <a href="" class="color-5"> (02-0000-0000)</a> <a href="">[지도보기]</a><br>
									<i class="fas fa-map-marker-alt color-5"></i> 서울시 강동구 강동동 123. 카페빌딩 2층 202호 
									</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
*/ ?>
            </div>
			<!-- // -->

        </div>
    </section>
    <!-- ##### About Area End ##### -->

	<!-- 지도 -->

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=110f5e83c64a4e55d359a3e3cf1ae2e8&libraries=services,clusterer,drawing"></script>
<script>
$(function(){
	var mapContainer = document.getElementById('kakao-map'), // 지도를 표시할 div 
		mapOption = {
			center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
			level: 3 // 지도의 확대 레벨
		};  

	// 지도를 생성합니다    
	var map = new kakao.maps.Map(mapContainer, mapOption); 

	// 주소-좌표 변환 객체를 생성합니다
	var geocoder = new kakao.maps.services.Geocoder();

	// 주소로 좌표를 검색합니다
	geocoder.addressSearch('<?=$rowJiboo["주소"]?>', function(result, status) {

		// 정상적으로 검색이 완료됐으면 
		 if (status === kakao.maps.services.Status.OK) {

			var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

			// 결과값으로 받은 위치를 마커로 표시합니다
			var marker = new kakao.maps.Marker({
				map: map,
				position: coords
			});

			// 인포윈도우로 장소에 대한 설명을 표시합니다
			var infowindow = new kakao.maps.InfoWindow({
				content: '<div style="width:150px;text-align:center;padding:6px 0;"><?=$rowJiboo["지부명"]?></div>'
			});
			infowindow.open(map, marker);

			// 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
			map.setCenter(coords);
		} 
	});  	
});
</script>


	<div class="md-today remodal hidden" id="md-today" style="width: 100%; height: 650px;">
		<div class="remodal-contents text-left p-3">
			<div>
				<div class="py-0" id="kakao-map" style="width: 100%; height: 510px;">
				</div>
			</div>
		</div>
		<div class="remodal-footer text-center">
			<button class="btn btn-gray fs-0" onclick="hideModal()">닫기</button>
		</div>
	</div>
	<!-- // -->
    
<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_hanc.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="coachapply"]').addClass('active');
</script>
</html>