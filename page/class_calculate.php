<?
include "./inc_program.php";

    // 코치인지 조회
    $query = "SELECT co_id, commission_rate FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";

    $resultCoach = db_query($query);
	$rowCoach = mysqli_fetch_array($resultCoach);   
    $cntCoach = mysqli_num_rows($resultCoach); 

    if ($cntCoach <= 0) {  // 코치이면  
        msg_page("코치회원만 이용할 수 있습니다.");
        exit;
    }


	$strSearchCalc = $_GET["txtSearchCalc"];

	// 나의 주문목록
	$query  = " SELECT A.lo_id, A.l_id, A.coach_id, A.member_id, A.member_uid, A.payment_flg, A.order_price, A.original_price, A.order_dt, A.order_id, A.쿠폰, A.쿠폰금액, A.l_point, A.status_flg, A.complete_flg, A.calc_dt, A.calc_flg, TRUNCATE(order_price * ((100-{$rowCoach["commission_rate"]})/100), 0) AS real_price,   \n";
	$query .= "            A.start_dt, A.start_tm, A.end_dt, A.end_tm,   \n";
	$query .= "            B.l_title, B.l_area,  B.cat_id, D.cat_nm, E.lesson_title,  F.name, F.hp     \n";
	$query .= " FROM    tbl_lesson_order A, tbl_lesson B, tbl_lesson_category D, tbl_lesson_setup E, tbl_member F    \n";
	$query .= " WHERE   A.coach_id = '{$ck_login_member_pk}'   \n";  
	$query .= " AND     A.status_flg = 'LOSTATCC'  \n";  // 수강완료된 주문
	if ($strSearchCalc == "Y") {
		$query .= " AND     A.calc_flg = 'AD001001'  \n";  
	} else if ($strSearchCalc == "N") {
		$query .= " AND     A.calc_flg = 'AD001002'  \n";  
	}
	$query .= " AND      A.l_id = B.l_id   \n";  
	$query .= " AND      A.coach_id = E.member_id   \n";  
	$query .= " AND      B.cat_id = D.cat_id   \n";
	$query .= " AND      A.member_id = F.member_id   \n";
	$query .= " ORDER BY A.lo_id DESC   \n";

	$resultOrder = db_query($query);   

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_artist.php"; ?>

	<section class="new-arrivals-products-area">
        <div class="container">

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h4>클래스 판매 정산관리</h4>
					<p class="fs-005 fw-500">* 주문관리에서 상태가 '<font color="#ff0033"><strong>수강완료</strong></font>'인 경우 상태변경일로부터 3영업일 후 자동 정산됩니다.<br>
					* 클래스가 수강완료 되었다면 반드시 주문상태를 '<font color="#ff0033"><strong>수강완료</strong></font>'로 변경해 주시기 바랍니다.</p>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='class_calculate.php' class="form-inline">
						<select class="custom-select" id="txtSearchCalc" name="txtSearchCalc" style="width:160px" onchange="javascript:frmSearch.submit()">
							<option value="">--정산상태 선택--</option>
							<option <?=($strSearchCalc == "N") ? "selected" : "";?> value="N">미정산 내역</option>
							<option <?=($strSearchCalc == "Y") ? "selected" : "";?> value="Y">정산완료 내역</option>
						</select>
						<button class="btn btn-secondary ml-2" id="btnSearch" style="font-size:14px; height:38px;">검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->
			</div>

				<div class="row">
					<div class="col-sm-12 col-lg-12">

					<!-- 등록클래스 리스트 -->
					<article class="mb-2">
						
						<div class="list list-schedule">
							<ul>
								<!-- 정산완료인 경우 -->
<?
	while ($rowOrder = mysqli_fetch_array($resultOrder)) {
        // 코치별 정산합계금액 계산
        $strSQL  = " SELECT A.coach_id, SUM(A.order_price) AS price, COUNT(A.lo_id) AS cnt, B.commission_rate, TRUNCATE(order_price * ((100-commission_rate)/100), 0) AS rprice   \n";
        $strSQL .= " FROM    tbl_lesson_order A, tbl_coach B   \n";
        $strSQL .= " WHERE  lo_id  IN ({$strID})   \n"; 
        $strSQL .= " AND      A.coach_id  = B.member_id   \n"; 
        $strSQL .= " GROUP BY A.coach_id, B.commission_rate    \n";

?>
								<li>
									<div class="d-flex">
										<div class="col-5 lh-3">
											<p class="color-1 fw-600 fs-05 ellipsis-2 my-1"><?=$rowOrder["l_title"]?></p>
											<button type="button" class="btn btn-outline-secondary fs-005"><li class="fas fa-check"> <?=(trim($rowOrder["calc_flg"]) =="AD001001") ? "정산완료" : "정산진행중";?></li></button>
										</div>
										<div class="col-7 border-left">
											<dl>
												<dd class="color-3 fs-005">- 주문번호 : <?=$rowOrder["order_id"]?></dd>
												<dd class="color-3 fs-005">- 주문일시 : <?=$rowOrder["order_dt"]?></dd>
												<dd class="color-3 fs-005">- 주문자 : <?=$rowOrder["name"]?> (<?=$rowOrder["hp"]?>)</dd>
												<dd class="color-3 fs-005">- 상품금액 : <strong><?=number_format($rowOrder["order_price"])?></strong> 원</dd>
												<dd class="color-3 fs-005">- 할인/쿠폰금액 : <font color="#ff0033"><strong><?=(trim($rowOrder["쿠폰"]) == "" || $rowOrder["쿠폰"] == 0) ? "적용안함" : $rowOrder["쿠폰금액"];?></strong></font></dd>
												<dd class="color-3 fs-005">- 수수료 : <font color="#ff0033"><strong><?=number_format($rowOrder["order_price"] - $rowOrder["real_price"])?></strong></font> 원</dd>
												<dd class="color-3 fs-005">- 정산예정금액 : <font color="#0033ff"><strong><?=number_format($rowOrder["real_price"])?></strong></font> 원</dd>
												<dd class="color-3 fs-005">- 정산요청일(수강완료일) : <?=$rowOrder["updt_dt"]?></dd>
												<dd class="color-3 fs-005">- 정산지급일 : <?=(trim($rowOrder["calc_dt"]) =="") ? "[정산진행중]" : $rowOrder["calc_dt"];?></dd>

												</dd>
											</dl>
										</div>
									</div>
								</li>
<?	
	}
?>
								<!-- // 정산완료인 경우 -->

								<!-- 정산 신청중인 경우 -->
<!--
								<li>
									<div class="d-flex">
										<div class="col-5 lh-3">
											<p class="color-1 fw-600 fs-05 ellipsis-2 my-1">클래스 상품 제목22222</p>
											<button type="button" class="btn btn-outline-info fs-005"><li class="fas fa-check"> 정산진행중</li></button>
										</div>
										<div class="col-7 border-left">
											<dl>
												<dd class="color-3 fs-005">- 주문번호 : ODR_84744_5efd3c6f89bca</dd>
												<dd class="color-3 fs-005">- 주문일시 : 2020-06-01 12:00:15</dd>
												<dd class="color-3 fs-005">- 주문자 : 홍길동 (01083362521)</dd>
												<dd class="color-3 fs-005">- 상품금액 : <strong>45,000</strong> 원</dd>
												<dd class="color-3 fs-005">- 할인/쿠폰금액 : <font color="#ff0033"><strong>5,000</strong></font> 원</dd>
												<dd class="color-3 fs-005">- 수수료 : <font color="#ff0033"><strong>4,500</strong></font> 원</dd>
												<dd class="color-3 fs-005">- 정산예정금액 : <font color="#0033ff"><strong>35,500</strong></font> 원</dd>
												<dd class="color-3 fs-005">- 정산요청일(수강완료일) : 2020-07-01 16:00:00</dd>
												<dd class="color-3 fs-005">- 정산지급일 : <strong>[정산진행중]</strong></dd>

												</dd>
											</dl>
										</div>
									</div>
								</li>
-->
								<!-- 정산 신청중인 경우 -->

							</ul>
						</div>
					</article>
					<!-- /// 등록클래스 리스트 -->
				</div>
				</div>
			</div>
		</div>
	</section>



	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="lessonset"]').addClass('active');
</script>
</html>





