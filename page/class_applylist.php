<?
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();

$strGubun = $_GET["txtGubun"];

// 아티스트인지 조회
    $query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
    $resultCoach = db_query($query);
    $cntCoach = mysqli_num_rows($resultCoach); 

    if ($cntCoach <= 0) {  // 아티스트이면  
        msg_page("아티스트회원만 이용할 수 있습니다.");
        exit;
    }

// 나의 주문목록
$query  = " SELECT A.lo_id, A.l_id, A.coach_id, A.member_id, A.member_uid, A.payment_flg, A.order_price, A.original_price, A.order_dt, A.order_id, A.l_point, A.status_flg, A.complete_flg, A.calc_flg,    \n";
$query .= "            A.start_dt, A.start_tm, A.end_dt, A.end_tm,   \n";
$query .= "            B.l_title, B.l_area,  B.cat_id, D.cat_nm, E.lesson_title,  F.name, F.hp     \n";
$query .= " FROM    tbl_lesson_order A, tbl_lesson B, tbl_lesson_category D, tbl_lesson_setup E, tbl_member F    \n";
$query .= " WHERE  A.coach_id = '{$ck_login_member_pk}'   \n";  
$query .= " AND    A.status_flg <> 'LOSTAREQ'   \n";  
$query .= " AND      A.l_id = B.l_id   \n";  
if ($strGubun == "NODATE") {    // 결제완료중 날짜 미설정된 주문
	$query .= " AND A.status_flg = 'LOSTAPCM' AND A.start_dt IS NULL  \n";
} else if ($strGubun == "NOCOMPLETE") {		// 수강완료되지 않은 주문(현재상태가 '클래스결제완료(접수)'이면서 관리자가 수강완료확인하지 않은 것)
	$query .= " AND A.status_flg = 'LOSTAPCR' AND complete_flg = 'AD001002' \n";
} else if ($strGubun == "COMPLETE") {  // 수강완료된 주문
	$query .= " AND A.status_flg = 'LOSTATCC'  \n";
}
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

<!-- 아티스트회원만 접속 가능함 -->
<script>
	$(document).ready(function(){
	
	});
</script>


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
					<h4>클래스 주문/관리</h4>
					<p class="fs-005 fw-400">* 결제완료된 주문건은 반드시 <strong><font color="#ff0033">'설정'</font></strong>메뉴에서 날짜를 설정 해 주어야 합니다.<br>
					* 날짜를 설정하지 않을 경우, 지연으로 인해 주문이 취소될 수 있습니다.<br>
					* <strong>수강이 완료</strong>된 주문건은 반드시 '<strong><font color="#ff0033">설정</font></strong>'에서 <strong><font color="#ff0033">'클래스 수강완료'</font></strong>로 처리해 주어야 합니다.</p>
				</div>

				<div class="col-sm-12 col-lg-12">

			
					<!-- 등록클래스 리스트 -->
					<article class="mb-2 mt-2">
						<div class="p-2">
							<a href="class_applylist.php" title="전체주문보기" class="color-6 fs-005">
							<button type="button" class="btn btn-outline-primary btn-sm radius-2 mb-2"><i class="fas fa-calendar-plus opacity-75"></i> 전체주문보기</button></a>
							<a href="class_applylist.php?txtGubun=NODATE" title="미설정" class="color-6 fs-005">
							<button type="button" class="btn btn-outline-primary btn-sm radius-2 mb-2"><i class="fas fa-calendar-plus opacity-75"></i> 날짜 미설정 주문보기</button></a>
							<a href="class_applylist.php?txtGubun=NOCOMPLETE" title="미완료주문" class="color-6 fs-005">
							<button type="button" class="btn btn-outline-primary btn-sm radius-2 mb-2"><i class="fas fa-calendar-plus opacity-75"></i> 미완료 주문보기</button></a>
							<a href="class_applylist.php?txtGubun=COMPLETE" title="완료된주문" class="color-6 fs-005">
							<button type="button" class="btn btn-outline-primary btn-sm radius-2 mb-2"><i class="fas fa-calendar-plus opacity-75"></i> 완료된 주문보기</button></a>
						</div>
						<div class="list list-schedule">
							<ul>
								<li>
									<div class="d-flex"></div>
								</li>
<? 
    while ($rowOrder = mysqli_fetch_array($resultOrder)) {
        $strDate = "";
        if ($rowOrder["status_flg"] == "LOSTAREQ") {    // 클래스접수(결제대기)
            $strDate .= "<strong class=\"fs-105 color-1\">미설정</strong>";
            $strDate .= "<p class=\"color-6 fs--1 mb-0\">입금전</p>";
        } else if ($rowOrder["status_flg"] == "LOSTACCM") {    // 클래스취소완료
            $strDate .= "<strong class=\"fs-105 color-1\">미설정</strong>";
            $strDate .= "<p class=\"color-6 fs--1 mb-0\">취소완료</p>";
        } else if ($rowOrder["status_flg"] == "LOSTAPCM" || $rowOrder["status_flg"] == "LOSTAPCR" || $rowOrder["status_flg"] == "LOSTATCC") {    // 클래스결제완료, 클래스결제완료(접수), 클래스수강완료
            if (trim($rowOrder["start_dt"]) != "") {
                $arrDT1 = explode("-", $rowOrder["start_dt"]);
                $arrDT2 = explode("-", $rowOrder["end_dt"]);
                if ($rowOrder["start_dt"] == $rowOrder["end_dt"]) {
                    $strDate .="<strong class=\"fs-1 color-1\">{$arrDT1[1]}</strong>월 <strong class=\"fs-1 color-1\">{$arrDT1[2]}</strong>일";
                    $strDate .="<p class=\"color-6 fs--1 mb-0\">{$rowOrder["start_tm"]} ~ {$rowOrder["end_tm"]}</p>";
                } else {
                    $strDate .="<strong class=\"fs-1 color-1\">{$arrDT1[1]}</strong>월 <strong class=\"fs-1 color-1\">{$arrDT1[2]}</strong>일 ~ <strong class=\"fs-1 color-1\">{$arrDT2[1]}</strong>월 <strong class=\"fs-1 color-1\">{$arrDT2[2]}</strong>일";
                    $strDate .="<p class=\"color-6 fs--1 mb-0\">{$rowOrder["start_tm"]} ~ {$rowOrder["end_tm"]}</p>";
                }
            } else {
                $strDate .= "<strong class=\"fs-105 color-1\">미설정</strong>";
                $strDate .= "<p class=\"color-6 fs--1 mb-0\"></p>";
            }
        } else if ($rowOrder["status_flg"] == "LOSTACCR") {    // 클래스결제취소요청(아티스트)
            $strDate .= "<strong class=\"fs-105 color-1\">취소중</strong>";
            $strDate .= "<p class=\"color-6 fs--1 mb-0\">아티스트취소</p>";
        } else if ($rowOrder["status_flg"] == "LOSTACAN") {    // 클래스결제취소요청
            $strDate .= "<strong class=\"fs-105 color-1\">취소중</strong>";
            $strDate .= "<p class=\"color-6 fs--1 mb-0\">회원취소</p>";
        } else if ($rowOrder["status_flg"] == "LOSTAPCA") {    // 클래스결제취소(환불처리중)
            $strDate .= "<strong class=\"fs-105 color-1\">취소완료</strong>";
            $strDate .= "<p class=\"color-6 fs--1 mb-0\">환불처리중</p>";
        } else if ($rowOrder["status_flg"] == "LOSTAPCC") {    // 클래스결제취소(환불완료)
            $strDate .= "<strong class=\"fs-105 color-1\">취소완료</strong>";
            $strDate .= "<p class=\"color-6 fs--1 mb-0\">환불완료</p>";
        }



?>
								<li>
									<div class="d-flex">

										<div class="col-4 lh-3 text-center">
											<p class="color-6 fs--1 mb-0">클래스날짜</p>
                                            <input type="hidden" name="txtID" class="txtID" value="<?=$rowOrder["l_id"]?>">
												
                                            <?=$strDate?>
<? 
            // 정산이 되지않았고, 
            // 상태가 '클래스결제완료' 또는 '클래스결제완(확인)' 또는 '클래스수강완료'이면 
            // 날짜설정 버튼 보여줌
            if ($rowOrder["complete_flg"] == "AD001002" && ($rowOrder["status_flg"] == "LOSTAPCM" || $rowOrder["status_flg"] == "LOSTAPCR" ||  $rowOrder["status_flg"] == "LOSTATCC")) {   
?>
    											<a href="#" onClick="window.open('class_apply_set.php?txtRecordNo=<?=$rowOrder["lo_id"]?>', 'win', 'width=550,height=700,scrollbars=yes,resizeable=yes,left=150,top=150')"><button class="btn btn-info btn-sm btn-capsule"><li>설정</li></button></a>

												<!-- 날짜설정 레이어 --><!--<button onclick="layer_open('layer2');return false;" class="btn btn-sm btn-capsule">날짜설정</button>-->
												
<? 
            } 
?>
										</div>
										<div class="col-8 border-left">
											<dl>
												<dd class="color-1 fw-600 fs-0 ellipsis my-1"><?=$rowOrder["l_title"]?> (<?=$rowOrder["cat_nm"]?>)</dd>
												<dd class="color-6 fs--1"><i class="fas fa-clock opacity-50"></i>주문일시 : <?=substr($rowOrder["order_dt"], 0, strlen($rowOrder["order_dt"])-3)?></dd>
												<dd class="color-6 fs--1"><i class="fas fa-clock opacity-50"></i>주문번호 : <?=substr($rowOrder["order_id"], 0, strlen($rowOrder["order_id"]))?></dd>
												<dd class="color-6 fs--1"><i class="fas fa-user opacity-50"></i>신청자 : <?=$rowOrder["name"]?> (0<?=$rowOrder["hp"]?> )</dd>
												<dd class="color-6 fs--1"><i class="fas fa-map-marker-alt opacity-50"></i>클래스 주소 : <?=(trim($rowOrder["l_point"]) != "") ? $rowOrder["l_point"] : $rowOrder["l_area"] ;?></dd>
												<dd class="color-6 fs--1"><i class="fas fa-wallet opacity-50"></i>상품가격 : <?=number_format($rowOrder["original_price"])?>원 </dd>
											</dl>
											<button type="button" class="btn btn-sm btn-capsule btn-primary fs--1"><li class="fas fa-star"> 상태: <?=$clsDBAgent->fnGetCommonCodeNM($rowOrder["status_flg"])?></li></button>
										</div>
									</div>
								</li>
<?
    }
?>
							</ul>
						</div>
					</article>
					<!-- /// 등록클래스 리스트 -->	
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>
<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="lessonset"]').addClass('active');
</script>
</html>


<!-- 레이어 팝업 -->
<script type="text/javascript">
	function layer_open(el){
		var temp = $('#' + el);
		var bg = temp.prev().hasClass('bg');	//dimmed 레이어를 감지하기 위한 boolean 변수
		if(bg){
			$('.layer').fadeIn();	//'bg' 클래스가 존재하면 레이어가 나타나고 배경은 dimmed 된다. 
		}else{
			temp.fadeIn();
		}

		// 화면의 중앙에 레이어를 띄운다.
		if (temp.outerHeight() < $(document).height() ) temp.css('margin-top', '-'+temp.outerHeight()/2+'px');
		else temp.css('top', '0px');
		if (temp.outerWidth() < $(document).width() ) temp.css('margin-left', '-'+temp.outerWidth()/2+'px');
		else temp.css('left', '0px');

		temp.find('a.cbtn').click(function(e){
			if(bg){
				$('.layer').fadeOut(); //'bg' 클래스가 존재하면 레이어를 사라지게 한다. 
			}else{
				temp.fadeOut();
			}
			e.preventDefault();
		});

		$('.layer .bg').click(function(e){	//배경을 클릭하면 레이어를 사라지게 하는 이벤트 핸들러
			$('.layer').fadeOut();
			e.preventDefault();
		});

	}			
</script>