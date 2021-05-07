<?
include "./inc_program.php";

// 코치인지 조회
$query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
$resultCoach = db_query($query);
$cntCoach = mysqli_num_rows($resultCoach); 

if ($cntCoach <= 0) {  // 코치이면  
    msg_page("비정상적인 접근입니다.");
    exit;
}

$strRecordNo = $_GET["txtRecordNo"];
// 클래스주문정보
$query  = " SELECT A.lo_id, A.l_id, A.coach_id, A.member_id, A.member_uid, A.payment_flg, A.order_price, A.original_price, A.order_dt, A.l_point, A.status_flg, A.complete_flg, A.calc_flg,    \n";
$query .= "            A.start_dt, A.start_tm, A.end_dt, A.end_tm,   \n";
$query .= "            B.l_title, B.l_area,  B.cat_id, D.cat_nm, E.lesson_title,  F.name, F.hp     \n";
$query .= " FROM    tbl_lesson_order A, tbl_lesson B, tbl_lesson_category D, tbl_lesson_setup E, tbl_member F    \n";
$query .= " WHERE  A.lo_id = '{$strRecordNo}'   \n";  
$query .= " AND      A.coach_id = '{$ck_login_member_pk}'   \n";  
$query .= " AND      A.l_id = B.l_id   \n";  
$query .= " AND      A.coach_id = E.member_id   \n";  
$query .= " AND      B.cat_id = D.cat_id   \n";
$query .= " AND      A.member_id = F.member_id   \n";
$rowOrder = db_select($query);   

// 정산이 되지않았고, 상태가 '클래스결제완료' 또는 '클래스결제완(확인)' 또는 '클래스수강완료'이면 설정을 진행할 수 있음
if (!($rowOrder["calc_flg"] == "AD001002" && ($rowOrder["status_flg"] == "LOSTAPCM" || $rowOrder["status_flg"] == "LOSTAPCR" || $rowOrder["status_flg"] == "LOSTATCC"))) {   
        msg_page("비정상적인 접근입니다.");
        exit;
} 


?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/lib/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.min.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script type="text/javascript" src="assets/lib/bootstrap-material-datetimepicker/moment.min.js"></script>
<script type="text/javascript" src="assets/lib/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.min.js"></script>
<script>
	$(document).ready(function(){

        $('#txtStartDT').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false, lang : 'kr'  });
        $('#txtStartTM').bootstrapMaterialDatePicker({ format : 'HH:mm', date: false,  lang : 'kr'  });
        $('#txtEndDT').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD', time: false, lang : 'kr'  });
        $('#txtEndTM').bootstrapMaterialDatePicker({ format : 'HH:mm', date: false,  lang : 'kr'  });

	    // 클래스설정 클릭시
        $(document).on('click', '.rdoStatus', function(event) {
<?     
    if ($rowOrder['status_flg'] == "LOSTAPCM") {   // 현재상태가 '클래스결제완료'이면
?>
             if ($(this).val() == "LOSTACCR") {    // 클래스설정이 클래스취소이면
                $('.clsItem').hide(250);
             } else {
                $('.clsItem').show(250);
             }
<?
    } else if ($rowOrder['status_flg'] == "LOSTAPCR") {   // 현재상태가 '클래스결제완료(접수)'이면
?>
             if ($(this).val() == "LOSTACCR") {    // 클래스설정이 클래스취소이면
                $('.clsItem').hide(250);
             } else {
                $('.clsItem').show(250);
             }
<?
    } else if ($rowOrder['status_flg'] == "LOSTATCC") {      // 현재상태가 '클래스수강완료'이면
?>

<?
    }
?>
        });

	    // 저장 버튼 클릭시
        $(document).on('click', '#btnSave', function(event) {
            var formData = new FormData($('#frmSet')[0]);

<?     
    if ($rowOrder['status_flg'] == "LOSTAPCM") {   // 현재상태가 '클래스결제완료'이면
?>

             if ($('input[name=rdoStatus]:checked').val() == "LOSTAPCR") {    // 클래스설정이 클래스접수이면 입력값 확인

                if (!chkItem()) {
                    return;
                }
             }
<?
    } else if ($rowOrder['status_flg'] == "LOSTAPCR") {   // 현재상태가 '클래스결제완료(접수)'이면
?>

             if ($('input[name=rdoStatus]:checked').val() == "LOSTATCC") {    // 클래스설정이 클래스수강완료이면 입력값 확인
                if (!chkItem()) {
                    return;
                }
             }
<?
    } else if ($rowOrder['status_flg'] == "LOSTATCC") {      // 현재상태가 '클래스수강완료'이면
?>
<?
    }
?>



            if (confirm("설정을 저장하시겠습니까?")) {
                $.ajax({
                    url: 'class_apply_set_save.php',
                    processData: false,
                    contentType: false,
                    data: formData,
                    type: 'POST',
                    success: function(result){
                        Data = $.trim(result);

                        if (Data == "SUCCESS") {
                           alert('설정이 완료되었습니다.');
                            //$(location).attr('href', 'class_applylist.php');
							opener.location.href = "class_applylist.php";
							window.close();
                        } else if(Data == "FAILED") {
                            alert('설정 실패했습니다. 관리자에게 문의하세요.');
                        } else {
                            alert(Data);
                        }
                    }
                });
            }
        });
	});

    function chkItem() {

        if ($.trim($('#txtStartDT').val()) == "") {
            alert('클래스 시작일을 선택하세요.');
            return false;
        }

        if ($.trim($('#txtEndDT').val()) == "") {
            alert('클래스 종료일을 선택하세요.');
            return false;
        }

        if ($.trim($('#txtStartDT').val()) > $.trim($('#txtEndDT').val())) {
            alert('클래스 종료일은 클래스시작일 이후로 설정하셔야 합니다.');
            return false;
        }

        if ($.trim($('#txtStartTM').val()) == "") {
            alert('클래스 시작시간을 선택하세요.');
            return false;
        }

        if ($.trim($('#txtEndTM').val()) == "") {
            alert('클래스 종료시간을 선택하세요.');
            return false;
        }

        if ($.trim($('#txtStartTM').val()) >= $.trim($('#txtEndTM').val())) {
            alert('클래스 종료시간은 클래스시작시간 이후로 설정하셔야 합니다.');
            return false;
        }

        if ($.trim($('#모임장소').val()) == "") {
            alert('클래스 장소를 입력하세요.');
            return false;
        }
        return true;
    }
</script>

<body class="mb-50">

		
		
		<div class="container-fluid">	
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 p-3">
				<div class="section-heading">
					<h2>주문접수 / 날짜 설정</h2>
				</div>
				<!-- 클래스 신청 정보 -->
					<div class="list list-schedule">
						<div class="d-flex">
							<div class="col-12">
								<dl>
									<dd class="color-1 fw-600 fs-0 ellipsis my-1"><i class="fas fa-book-open opacity-50"></i> 신청클래스 : <?=$rowOrder["l_title"]?></dd>
									<dd class="color-6 fs--1"><i class="fas fa-user opacity-50"></i>주문자 정보 : <?=$rowOrder["name"]?> (0<?=$rowOrder["hp"]?>)</dd>
									<dd class="color-6 fs--1"><i class="fas fa-wallet opacity-50"></i><?=number_format($rowOrder["original_price"])?>원</dd>
								</dl>
							</div>
						</div>
					</div>

					<form name="frmSet" id="frmSet" method="post">
                    <input type="hidden" name="txtRecordNo" id="txtRecordNo" value="<?=$strRecordNo?>">
					<div class="form-group">
					  <label>주문상태 설정</label>
						<ul class="list list-border background-white">
<? 
    /*-------------------------------------------------------------------------------
    #상태가 '레슨결제완료'이면 코치가 
            '레슨결제완료(접수)' 또는
            '레슨결제취소요청(코치)'을 할 수 있음
    #상태가 '레슨결제완료(접수)'이면 코치가 
            '레슨결제취소요청' 또는
            '레슨수강완료'를 할 수 있음
    #상태가 '레슨수강완료'이면 
            '레슨결제완료(접수)'로 되 돌릴 수 있음
            (단 관리자가 수강완료확인을 하지않은 건에 대해서만)
    -------------------------------------------------------------------------------*/
    if ($rowOrder['status_flg'] == "LOSTAPCM") {   // 현재상태가 '레슨결제완료'이면
?>
							<li class="p-3 d-flex align-items-center">
								<div>
                                    <input type="radio" name="rdoStatus" class="rdoStatus" id="rdoStatus1" value="LOSTAPCR" checked />&nbsp;
								</div>
								<h4 class="fs-005 mb-0"><label for="rdoStatus1">클래스 접수</label></h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div>
                                    <input type="radio"  name="rdoStatus" class="rdoStatus" id="rdoStatus2"  value="LOSTACCR"/>&nbsp;
								</div>
								<h4 class="fs-005 mb-0"><label for="rdoStatus2">클래스 취소(주문 취소할 경우만 선택)</label></h4>
							</li>
<?
    } else if ($rowOrder['status_flg'] == "LOSTAPCR") {   // 현재상태가 '클래스결제완료(접수)'이면
?>
							<li class="p-3 d-flex align-items-center">
								<div>
                                    <input type="radio" name="rdoStatus" class="rdoStatus" id="rdoStatus1" value="LOSTATCC" checked />&nbsp;
								</div>
								<h4 class="fs-005 mb-0"><label for="rdoStatus1">클래스 수강완료</label></h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<div>
                                    <input type="radio"  name="rdoStatus" class="rdoStatus" id="rdoStatus2" value="LOSTACCR"/>&nbsp;
								</div>
								<h4 class="fs-005 mb-0"><label for="rdoStatus2">클래스 취소(주문 취소할 경우만 선택)</label></h4>
							</li>
<?
    } else if ($rowOrder['status_flg'] == "LOSTATCC") {      // 현재상태가 '클래스수강완료'이면
        if ($rowOrder['complete_flg'] == "AD001002") {      // 관리자가 수강완료확인을 하지 않은것만
?>
							<li class="p-3 d-flex align-items-center">
								<div>
                                    <input type="checkbox"  name="rdoStatus" class="rdoStatus" value="LOSTAPCR"/>&nbsp;
								</div>
								<h4 class="fs-005 mb-0">클래스완료취소(클래스접수로 되돌리기)</h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							</li>
<?
        }
    }
?>
						</ul>
					</div>
					<div class="form-group clsItem">
						<label for="">클래스 기간 </label>
							<input type="text" name="txtStartDT" id="txtStartDT" value="<?=$rowOrder["start_dt"]?>" readonly class="form-control" placeholder="클래스시작일">~<input type="text" name="txtEndDT" id="txtEndDT" value="<?=$rowOrder["end_dt"]?>" readonly class="form-control" placeholder="클래스종료일">
					</div>
					<div class="form-group clsItem">
						<label for="">클래스 시간</label>
							<input type="text" name="txtStartTM" id="txtStartTM" value="<?=$rowOrder["start_tm"]?>" readonly class="form-control" placeholder="클래스시작시간">~<input type="text" name="txtEndTM" id="txtEndTM" value="<?=$rowOrder["end_tm"]?>" readonly class="form-control" placeholder="클래스종료시간">
					</div>
					<div class="form-group clsItem">
						<label for="">클래스 주소</label>
						<!-- 클래스장소 입력시 맵연동 // 네이버 지도맵 연동하여 장소 연동 -->
						<input class="form-control" id="모임장소" name="모임장소" type="text" value="<?=$rowOrder["l_point"]?>" readonly="readonly" placeholder="클래스 장소를 입력해 주세요." />
						<button type="button" class="btn btn-info8 btn-sm btn-capsule mt-1" onclick="모임장소_검색()"><li class="fas fa-star"> 주소검색</li></button><br>
						<div id="wrap-모임장소" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
							<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
						</div>
						<!--//-->
					</div>

					</form>
					<div class="mt-2">
						<a href="javascript:void(0);" id="btnSave" class="btn-block btn btn-primary fs-0">저 장</a>
					</div>

				</div>
			</div>
		</div>
		</section>
	
</body>
<script>
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>
