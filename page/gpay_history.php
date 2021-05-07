<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="./assets/css/sub.css?20190930">

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<div class="breadcrumb-area">
	<!-- Top Breadcrumb Area -->
	<div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
		<h2>Help Desk</h2>
	</div>
</div>
<? 
include "./inc_nav.php"; 

if(!$pageNo){
    $pageNo = 1;
}
 
$pageScale = 10;

$pageStartNo = ($pageNo -1)*$pageScale;


$start = ($pageNo-1)*$pageScale;



$arrWhere = array(); 
if ($sdate) {
    $arrWhere[] = "  left(처리일시,10)  >= '$sdate'";
}
if ($edate) {
    $arrWhere[] .= "  left(처리일시,10)  <= '$edate'";
}


$strWhere = implode(" AND ", $arrWhere);

if (trim($strWhere) != "")  $strWhere = " AND " . $strWhere;



$query  = " SELECT member_id, 전송유형, 상세내용, 금액, 참고1, 처리일시  \n";
$query .= " FROM   tbl_coin_gep  \n"; 
$query .= " WHERE  member_id = '{$rowMember["member_id"]}'   \n";
$query .= $strWhere;
$query .= " order by pk_gep DESC   \n";
$query .= " LIMIT ".$start.", ".$pageScale;
$result = db_query($query);


$query  = " SELECT COUNT(*)  \n";
$query .= " FROM   tbl_coin_gep  \n"; 
$query .= " WHERE  member_id = '{$rowMember["member_id"]}'   \n";
$query .= $strWhere;
$num=db_result($query);

$display = $num - ($pageNo-1)*$pageScale;
?>
<section class="new-arrivals-products-area">
	<div class="container">
		<div class="category-area2 mt-2">
			<article class="p-1">
				<!--tab-->
				<div id="tab-menu" class="tab-sub clearfix">
					<ul class="row align-items-center justify-content-center text-center">
						<li class="col p-0"><a href="gpay_charge_history.php" title="충전내역">G-PAY 충전내역</a></li>
						<li class="col p-0 active"><a href="gpay_history.php" title="전송/사용내역">전송/이용내역</a></li>
					</ul>
				</div>
				<!--tab-->
				

				<!--보유금액-->
				<div class="box-round mx-1 mt-3 mb-2">
					<div class="align-items-center justify-content-center text-center">
						<h2 class="mr-auto mb-0 fw-600">G-PAY 보유금액 : <?=number_format($rowMember['gpay'])?> <small>GP</small></h2>
					</div>
				</div>	
				<!--//-->

				<!--date-->
				<form name="frm_page" id="frm_page">
				<input type="hidden" name="pageNo" id="pageNo" value="<?=$pageNo?>"/>
				<div class="con-datepicker clearfix">
					<label>기간 검색</label>
					<div class="d-flex align-items-center">
						<div class="input-daterange input-group" id="datepicker">
							<input type="text" class="input-sm form-control datepicker background-10" name="sdate" value="<?=$sdate?>">
							<span class="input-group-addon color-8">-</span>
							<input type="text" class="input-sm form-control datepicker background-10" name="edate" value="<?=$edate?>">
						</div>
						<div class="ml-auto">
							<button type="submit" class="btn btn-primary btn-search"><i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
				</form>
				<!--//date-->

					<div class="p-1 mt-3">
						<div class="list-history">
							<ul>

							<!-- 내역이 없을때
							<div class="m-5 text-center">
								<span class="fs-005 color-7">사용 내역이 없습니다. </span>
							</div> -->
<?
    while($row = db_fetch($result)){
        

        // 전송유형이 'GPAY 전송'일때 
        if ($row["전송유형"] == "GPAYTRANSMISSION") { 
            if ($row["상세내용"] == "GPAY보냄" ) {     // GPAY 보냈을때
                $query  = " SELECT B.UID, B.name  \n";
                $query .= " FROM   tbl_gpay_send A, tbl_member B  \n"; 
                $query .= " WHERE  A.gs_id = '{$row["참고1"]}'   \n";
                $query .= " AND    A.member_id = B.member_id   \n";
                $rowTaker = db_select($query);
            } else {        // GPAY 받았을때
                $query  = " SELECT B.UID, B.name  \n";
                $query .= " FROM   tbl_gpay_send A, tbl_member B  \n"; 
                $query .= " WHERE  A.gs_id = '{$row["참고1"]}'   \n";
                $query .= " AND    A.send_id = B.member_id   \n";
                $rowTaker = db_select($query);
            }

            $strInfo = $row["상세내용"]." ㅣ UID: ".$rowTaker["UID"]." (".$rowTaker["name"].")";
        } else if ($row["전송유형"] == "OPENClASS") {  // 오픈클래스구매
                $query  = " SELECT B.l_title  \n";
                $query .= " FROM   tbl_lesson_order A, tbl_lesson B  \n"; 
                $query .= " WHERE  A.lo_id = '{$row["참고1"]}'   \n";
                $query .= " AND    A.l_id = B.l_id   \n";

                $rowTaker = db_select($query);
                $strInfo = $row["상세내용"]." ㅣ ".$rowTaker["l_title"];
        } else if ($row["전송유형"] == "LECTURE") {   // 문화센터 강좌 구매
                $query  = " SELECT B.강좌명  \n";
                $query .= " FROM   tbl_lecture_order A, tbl_lecture B  \n"; 
                $query .= " WHERE  A.o_id = '{$row["참고1"]}'   \n";
                $query .= " AND    A.강좌PK = B.pk_lecture   \n";

                $rowTaker = db_select($query);
                $strInfo = $row["상세내용"]." ㅣ ".$rowTaker["강좌명"];

        } else if ($row["전송유형"] == "SHOPPING") {   // 쇼핑
                $query  = " SELECT COUNT(od_id) AS goods_cnt \n";
                $query .= " FROM   sysT_OrderDtl   \n"; 
                $query .= " WHERE  o_id = '{$row["참고1"]}'   \n";
                $rowGoodCnt = db_select($query);

                $query  = " SELECT B.goods_nm  \n";
                $query .= " FROM   sysT_OrderDtl A, sysT_SellerGoods B  \n"; 
                $query .= " WHERE  A.o_id = '{$row["참고1"]}'   \n";
                $query .= " AND    A.sg_id = B.sg_id   \n";
                $queyr .= " ORDER BY A.od_id ASC \n";
                $query .= " LIMIT 1   \n";
                $rowTaker = db_select($query);

                if ($rowGoodCnt["goods_cnt"] > 1) {
                    $strInfo = $row["상세내용"]." ㅣ ".$rowTaker["goods_nm"]." 외 ".($rowGoodCnt["goods_cnt"] -1)."건";                    
                } else {
                    $strInfo = $row["상세내용"]." ㅣ ".$rowTaker["goods_nm"];
                } 
        } else if ($row["전송유형"] == "MANAGERMGT") {   //  관리자 임의지급
            $strType = ($row["금액"] >= 0) ? "임의지급" : "임의차감";
            $strInfo = "{$strType} ㅣ " . $row["상세내용"];
        } else {
            $strInfo = $row["상세내용"];
        }

?>

								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400"><?=$strInfo?></h5>
											<span class="fs--1 color-7"><?=$row["처리일시"]?></span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong><?=number_format($row["금액"])?></strong> <small>GP</small></p>
									    </div>
									</div>
								</li>

<?
    }
?>
<!--

								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400">선물/전송 ㅣ UID: 12345678 (홍길동)</h5>
											<span class="fs--1 color-7">2020-08-17 23:54:03</span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong>- 25,000</strong> <small>GEP</small></p>
									    </div>
									</div>
								</li>
								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400">수신 ㅣ UID: 12345678 (보낸사람)</h5>
											<span class="fs--1 color-7">2020-08-17 23:54:03</span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong>25,000</strong> <small>GEP</small></p>
									    </div>
									</div>
								</li>
								<li>								
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400">결제 ㅣ 클래스주문 </h5>
											<span class="fs--1 color-7">2020-08-17 23:54:03</span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong>- 25,000</strong> <small>GEP</small></p>
									    </div>
									</div>
								</li>
								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400">결제 ㅣ 쇼핑몰주문</h5>
											<span class="fs--1 color-7">2020-08-17 23:54:03</span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong>- 25,000</strong> <small>GEP</small></p>
									    </div>
									</div>
								</li>
								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400">결제 ㅣ 스토어(상점명)</h5>
											<span class="fs--1 color-7">2020-08-17 23:54:03</span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong>- 25,000</strong> <small>GEP</small></p>
									    </div>
									</div>
								</li>
								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400">임의지급 ㅣ 메모내용 노출</h5>
											<span class="fs--1 color-7">2020-08-17 23:54:03</span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong>25,000</strong> <small>GEP</small></p>
									    </div>
									</div>
								</li>
								<li>
									<div class="list-info d-flex">
										<div>
											<h5 class="fs-005 mb-0 fw-400">임의차감 ㅣ 메모내용 노출</h5>
											<span class="fs--1 color-7">2020-08-17 23:54:03</span>
										</div>
									    <div class="ml-auto">
									    	<p class="mb-0 color-4"><strong>- 25,000</strong> <small>GEP</small></p>
									    </div>
									</div>
								</li>
-->								
							</ul>
						</div>
						<div class="mt-3">
							<? include ("_paging.php");?>
						</div>
						<? include "./gpay_status.php"; ?>
					</div>
				</div>


			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_main.php"; ?>
</body>
<script>
	$('.nav_category li[data-name="gnb-cloud"]').addClass('active');
	$('.nav_bottom li[data-name="wallet"]').addClass('active');
</script>
</html>