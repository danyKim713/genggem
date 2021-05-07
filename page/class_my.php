<? 
include "./inc_program.php";

include "../common/include/incDeclaration.php";     // 전체 프로그램 전역상수
include "../common/include/incDBAgent.php";     // 전체 프로그램 전역상수
include "../common/include/incLib.php";     // 전체 프로그램 전역상수

// 외부 객체 생성
$clsDBAgent = new CDBAgent();
$clsLib     = new CLib();


// 나의 주문목록
$query  = " SELECT A.lo_id, A.l_id, A.coach_id, A.member_id, A.member_uid, A.payment_flg, A.original_price, A.order_price, A.사용마일리지, A.적립될마일리지, A.쿠폰금액, A.order_dt, A.order_id, A.l_point, A.status_flg, A.complete_flg, F.co_id,    \n";
$query .= "            A.start_dt, A.start_tm, A.end_dt, A.end_tm,     \n";
$query .= "            B.l_title, B.l_area,  B.cat_id, C.cd_nm, D.cat_nm, E.lesson_title    \n";
$query .= " FROM    tbl_lesson_order A, tbl_lesson B, sysT_CommonCode C, tbl_lesson_category D, tbl_lesson_setup E, tbl_coach F    \n";
$query .= " WHERE  A.member_id = '{$ck_login_member_pk}'   \n";  
$query .= " AND      A.l_id = B.l_id   \n";  
$query .= " AND      A.payment_flg = CONCAT(C.major_cd, C.minor_cd)   \n";
$query .= " AND      A.coach_id = E.member_id   \n";  
$query .= " AND      B.cat_id = D.cat_id   \n";
$query .= " AND      A.coach_id = F.member_id   \n";
$query .= " ORDER BY A.lo_id DESC   \n";

$resultOrder = db_query($query);   

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

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
<!-- ##### img Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>


	<section class="new-arridvals-products-area">
        <div class="container">
			<div class="category-area mt-3">
				<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2>My class</h2>
					<p>회원님이 신청하신 클래스입니다.</p>
				</div>

				<!-- 
				<div class="search_by_terms">
					<a href="미사용된 내역만 보여줌" title="미사용내역보기" class="float-right btn-o2 btn-warning  fs-005">미완료 클래스 보기<span class="icon ic-right-arrow fs--1"></span></a>
				</div>
				 -->				
			</div>


			<div class="list list-schedule mb-5">
				<ul>
<?
	while ($rowOrder = mysqli_fetch_array($resultOrder)) {
			// 클래스날짜 초기화
            $strData = "";
            $strDate = "";
            if ($rowOrder["status_flg"] == "LOSTAREQ") {    // 클래스접수(결제대기)
                $strDate .= "<strong class=\"fs-2 color-1\">미설정</strong>";
                $strDate .= "<p class=\"color-6 fs-005 mb-0\">입금전</p>";
            } else if ($rowOrder["status_flg"] == "LOSTACCM") {    // 클래스취소완료
                $strDate .= "<strong class=\"fs-2 color-1\">미설정</strong>";
                $strDate .= "<p class=\"color-6 fs-005 mb-0\">취소완료</p>";
            } else if ($rowOrder["status_flg"] == "LOSTAPCM" || $rowOrder["status_flg"] == "LOSTAPCR" || $rowOrder["status_flg"] == "LOSTATCC") {    // 클래스결제완료, 클래스결제완료(접수), 클래스수강완료
                if (trim($rowOrder["start_dt"]) != "") {
                    $arrDT1 = explode("-", $rowOrder["start_dt"]);
                    $arrDT2 = explode("-", $rowOrder["end_dt"]);
                    if ($rowOrder["start_dt"] == $rowOrder["end_dt"]) {
                        $strDate .="<strong class=\"fs-1 color-1\">{$arrDT1[1]}</strong><small>월</small> <strong class=\"fs-1 color-1\">{$arrDT1[2]}</strong><small>일</small>";
                        $strDate .="<p class=\"color-6 fs-0 mb-0\">{$rowOrder["start_tm"]} ~ {$rowOrder["end_tm"]}</p>";
                    } else {
                        $strDate .="<strong class=\"fs-1 color-1\">{$arrDT1[1]}</strong><small>월</small> <strong class=\"fs-1 color-1\">{$arrDT1[2]}</strong><small>일</small> ~ <strong class=\"fs-1 color-1\">{$arrDT2[1]}</strong><small>월</small> <strong class=\"fs-1 color-1\">{$arrDT2[2]}</strong><small>일</small></p>";
                        $strDate .="<p class=\"color-6 fs-0 mb-0\">{$rowOrder["start_tm"]} ~ {$rowOrder["end_tm"]}</p>";
                    }
                } else {
                    $strDate .= "<strong class=\"fs-2 color-1\">미설정</strong>";
                    $strDate .= "<p class=\"color-6 fs-005 mb-0\"></p>";
                }
            } else if ($rowOrder["status_flg"] == "LOSTACCR") {    // 클래스결제취소요청(아티스트)
                $strDate .= "<strong class=\"fs-2 color-1\">취소중</strong>";
                $strDate .= "<p class=\"color-6 fs-005 mb-0\">아티스트취소</p>";
            } else if ($rowOrder["status_flg"] == "LOSTACAN") {    // 클래스결제취소요청
                $strDate .= "<strong class=\"fs-2 color-1\">취소중</strong>";
                $strDate .= "<p class=\"color-6 fs-005 mb-0\">회원취소</p>";
            } else if ($rowOrder["status_flg"] == "LOSTAPCA") {    // 클래스결제취소(환불처리중)
                $strDate .= "<strong class=\"fs-2 color-1\">취소완료</strong>";
                $strDate .= "<p class=\"color-6 fs-005 mb-0\">환불처리중</p>";
            } else if ($rowOrder["status_flg"] == "LOSTAPCC") {    // 클래스결제취소(환불완료)
                $strDate .= "<strong class=\"fs-2 color-1\">취소완료</strong>";
                $strDate .= "<p class=\"color-6 fs-005 mb-0\">환불완료</p>";
            }


			// 상태변경 버튼 class 값 설정
			$strActionClass = "";
			$strBtnNM = "";
			$strShow = "";
			if ($rowOrder["status_flg"] == "LOSTAREQ") {  // 클래스접수(결제대기) 이면
				$strBtnClass = "btnAction LESSONCANCELOK";				
				$strBtnNM = "클래스취소요청";
			} else if ($rowOrder["status_flg"] == "LOSTAPCM") {  // 클래스결제완료 이면
				$strBtnClass = "btnAction LESSONCANCELREQUEST";				
				$strBtnNM = "클래스취소요청";
			} else if ($rowOrder["status_flg"] == "LOSTAPCR") {  // 클래스결제완료(접수) 이면
				$strBtnClass = "btnAction btnPaymentOK";				
				$strShow = "style='display:none'";
			} else if ($rowOrder["status_flg"] == "LOSTACAN") {  // 클래스취소요청 이면
				$strBtnClass = "btnAction btnPaymentOK";				
				$strShow = "style='display:none'";
			} else if ($rowOrder["status_flg"] == "LOSTACCM") {  // 클래스취소완료 이면
				$strBtnClass = "btnAction btnPaymentOK";				
				$strShow = "style='display:none'";
			} else if ($rowOrder["status_flg"] == "LOSTAPCA") {  // 클래스결제취소(환불처리중) 이면
				$strBtnClass = "btnAction btnPaymentOK";				
				$strShow = "style='display:none'";
			} else if ($rowOrder["status_flg"] == "LOSTAPCC") {  // 클래스결제취소(환불완료) 이면
				$strBtnClass = "btnAction btnPaymentOK";				
				$strShow = "style='display:none'";
			} else if ($rowOrder["status_flg"] == "LOSTADCC") {  // 클래스취소(아티스트) 이면
				$strBtnClass = "btnAction btnPaymentOK";				
				$strShow = "style='display:none'";
			} else if ($rowOrder["status_flg"] == "LOSTATCC") {  // 클래스수강완료 이면
                if ($rowOrder["complete_flg"] == "AD001001") {   // 관리자가 수강완료확인 했으면
				    $strBtnClass = "btnAction LESSONREVIEW";				
    				$strBtnNM = "후기쓰기";
                } else {
    				$strShow = "style='display:none'";
                }
			}
?>
					<li>
						<div class="d-flex">
							<div class="col-4 lh-3 text-center">
								<p class="color-6 fs-005 mb-0">클래스날짜</p>
								<?=$strDate?>
							</div>
							<div class="col-8 border-left">
								<dl> 
									<dd class="color-1 fw-600 ellipsis-2 fs-0 my-1"><a href="artist.php?txtRecordNo=<?=$rowOrder["co_id"]?>" class="btn btn-info btn-sm radius-5"><?=$rowOrder["lesson_title"]?><i class="fas fa-star opacity-50"></i>블로그
									</a></dd>
									<dd class="color-6 fs-005"><i class="fas fa-book-open opacity-50"></i><a href="class_detail.php?txtRecordNo=<?=$rowOrder["l_id"]?>"><?=$rowOrder["l_title"]?></a> (<?=$rowOrder["cat_nm"]?>)</dd>
									<dd class="color-6 fs-005"><i class="fas fa-clock opacity-50"></i>주문번호 : <?=substr($rowOrder["order_id"], 0, strlen($rowOrder["order_id"]))?></dd>
									<dd class="color-6 fs-005"><i class="fas fa-clock opacity-50"></i>주문일시 : <?=substr($rowOrder["order_dt"], 0, strlen($rowOrder["order_dt"])-3)?></dd>
									
									<!-- 지도보기 -->
									<dd class="color-6 fs-005"><i class="fas fa-map-marker-alt opacity-50"></i>클래스 주소 : <?=$rowOrder["l_point"]?><?if($rowOrder["l_point"]){?><a href="class_map.php?name=<?=rawurlencode($rowOrder["lesson_title"])?>&address=<?=rawurlencode($rowOrder["l_point"])?>" title="" onClick="popct(this.href, '500', '700');return false" class="clearfix"> <button type="button" class="btn btn-info3 btn-xs fw-400 ml-1">지도보기</button></a><?}?></dd>

									<!-- <dd class="color-6 fs-005"><i class="fas fa-map-marker-alt opacity-50"></i>클래스 주소 : <?=(trim($rowOrder["l_point"]) != "") ? $rowOrder["l_point"] . " <button onclick=\"layer_open('layer2');return false;\" class=\"btn btn-info3 btn-sm radius-5\"><i class=\"fa fa-map-marker\"></i>지도보기" : "아티스트 확인전" ;?> </dd> -->

									<dd class="color-6 fs-005"><i class="fas fa-ruble opacity-50"></i>사용 GPOINT : <?=number_format($rowOrder["사용마일리지"])?> Point</dd>
									<dd class="color-6 fs-005"><i class="fas fa-ruble opacity-50"></i>쿠폰/할인 : <font color="#ff0033"><?=number_format($rowOrder["쿠폰금액"])?></font> 원</dd>
									<dd class="color-6 fs-005"><i class="fas fa-wallet opacity-50"></i>실결제금액 : <?=number_format($rowOrder["order_price"])?> 원</dd>
									<dd class="color-6 fs-005"><i class="fas fa-wallet opacity-50"></i>적립금액 : <?=number_format($rowOrder["적립될마일리지"])?> Point</dd>
								</dl>
								<input type="hidden" name="txtID[]" class="txtID" value="<?=$rowOrder["lo_id"]?>">
								<button type="button" class="btn btn-sm btn-capsule btn-danger mb-1"><li class="fas fa-calendar-check"> <?=$clsDBAgent->fnGetCommonCodeNM($rowOrder["status_flg"])?></li></button>
								<button class="btn btn-sm btn-capsule <?=$strBtnClass?> btn-sm btn-capsule mb-1" <?=$strShow?>><i class="fas fa-calendar-check opacity-50 mb-1"></i> <span><?=$strBtnNM?></span></button>

							</div>
						</div>
					</li>		
<?
	}
?>


				</ul>
			</div>
		</div>
					<!-- /// 등록클래스 리스트 -->	
					
	</section>
	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="myclass"]').addClass('active');
</script>

<script>

	$(document).ready(function(){

	        // 상태변경 버튼 클릭시
        $(document).on('click', '.btnAction', function(event) {
			var idx = $('.btnAction').index(this);
			var strAct = "";
			if ($('.btnAction').eq(idx).hasClass('LESSONCANCELOK')) {
				strAct = "LESSONCANCELOK";
			} else if ($('.btnAction').eq(idx).hasClass('LESSONCANCELREQUEST')) {
				strAct = "LESSONCANCELREQUEST";
			} else if ($('.btnAction').eq(idx).hasClass('LESSONREVIEW')) {
				strAct = "LESSONREVIEW";
				$(location).attr('href', 'class_review_write.php?txtRecordNo='+$('.txtID').eq(idx).val());
				return;
			}



			if (confirm($('.btnAction > span').eq(idx).text() + "을(를) 진행하시겠습니까?")) {
				$.ajax({
					url: './class_my_action.php',
					type: 'post',
					data: {
						txtAction: strAct,
						txtRecordNo: $('.txtID').eq(idx).val(),
					},
					datatype: 'text',
					success: function(Data) {
						Data = $.trim(Data);

						if (Data == "SUCCESS") {
							alert('처리가 완료되었습니다');
							location.reload();
						} else {
							alert(Data);
						}
					} 
				});

			}
        });
	
	});


</script>

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
</html>





