<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

<?
if(!$CID){
	msg_page("잘못된 접근입니다.");
}

$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
$rowM = db_select($query);

// 모임개설 권한은 운영진, 클럽장만 가능 
if(!($rowChannel['member_id'] == $rowMember['member_id'] || $rowM['운영진여부'] == "Y")){
	msg_page("접근 권한이 없습니다.");
	exit;
}
?>

<script>
	function go_make_meeting(){
		var params = $("#frm").serialize();
		$.ajax({
			url: "_ajax_channel_moim_make_action.php",
			data: params,
			contentType: "application/x-www-form-urlencoded; charset=UTF-8",
			dataType: "html",
			success: function(data){
				if(data == "SUCCESS"){
					alert('감사합니다. 모임 생성이 성공적으로 이루어졌습니다.');
					//top.location.href = "javascript_:window.close()";
					opener.location.reload();
					window.close();
				}else if(data == "MANDATORY_ERROR"){
					alert('필수 항목이 누락되었습니다.');
				}else{
					alert('오류가 발생했습니다. 관리자에게 문의바랍니다.');
				}
			}
		});
	}

	function go_change_시도(){
		var 시도 = $("#시도 option:selected").val();
		if(시도 == ""){
			$("#구군").html('<option value="">구/군을 선택해주세요.</option>');
			return;
		}
		$.post("_ajax_gu_gun.php",{
			시도: 시도
		},function(data){
			$("#구군").html(data);
		});
	}
</script>

	<link rel="stylesheet" href="assets/lib/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<script type="text/javascript" src="assets/lib/bootstrap-material-datetimepicker/moment.min.js"></script>
	<script type="text/javascript" src="assets/lib/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.min.js"></script>

		<body>
		<form name="frm" id="frm" method="post">
			<input type="hidden" name="CID" id="CID" value="<?=$CID?>"/>
			<header class="header top_fixed">
				<h2 class="header-title text-center">모임개설</h2>
			</header>
			<section class="wrap-channelmade py-0">
				<div class="container-fluid header-top-sub">
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-10 col-lg-6 col-xl-4 p-3">
							<div class="form-group">
								<label for="">모임날짜</label>
								<!--date-->
									<input type="text" name="모임날짜시간" id="meet-date" class="form-control" placeholder="클릭 후 모임 날짜와 시간을 선택해주세요">
								<!--//date-->
							</div>
							
							<div class="form-group">
								<label for="">지역 선택</label>
								<select class="form-control mb-1" size="1" id="시도" name="시도" onChange="go_change_시도();">
									<option value="">시/도를 선택해주세요</option>
									<?
						for ($i=0; $i<sizeof($시도배열); $i++){
						?>
										<option value="<?=$시도배열[$i]?>">
											<?=$시도배열[$i]?>
										</option>
										<?}?>

								</select>
								<select class="form-control" size="1" id="구군" name="구군">
									<option value="">구/군을 선택해주세요</option>
								</select>
								<!-- 모임장소 입력시 맵연동 // 네이버 지도맵연동하여 장소 연동 -->
								<input class="form-control mt-1" id="모임장소" name="모임장소" type="text" placeholder="모임장소를 입력해 주세요." />
								<!-- <input type="button" onclick="모임장소_검색()" value="우편번호 찾기"> -->
								<button type="button" class="btn btn-outline-info2 btn-sm btn-capsule mt-1" onclick="모임장소_검색()"><li class="fas fa-star"> 우편번호로 찾기</li></button><br>
								<div id="wrap-모임장소" style="display:none;border:1px solid;width:500px;height:300px;margin:5px 0;position:relative">
									<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
								</div>
								<!--//-->
							</div>

							<div class="form-group">
								<label for="">모임제목</label>
								<input class="form-control" id="모임제목" name="모임제목" type="text" placeholder="예) 골프벙 / 10자이하" />
							</div>
							<div class="form-group">
								<label for="">모임설명</label>
								<input class="form-control" id="모임설명" name="모임설명" type="text" placeholder="모임 설명을 20자 내로 작성해 주세요." />
							</div>
							<div class="form-group">
								<label for="">모임참가비용</label>
								<input class="form-control" id="모임참가비용" name="모임참가비용" type="text" placeholder="예) 식사비용 20,000원" />
							</div>
							<div class="form-group">
								<label for="">모임정원</label>
								<input class="form-control" id="모임정원" name="모임정원" type="number" placeholder="숫자만 입력해 주세요" />
							</div>
							<div class="form-group">
								<div class="checkbox check-square">
								<input id="모임개설공지여부" name="모임개설공지여부" type="checkbox" checked class="invisible" value="Y">
								<label id="agree" for="모임개설공지여부" class="color-3 fs-0 mb-0 fw-400"><i class="biko-check color-5 mr-1"></i> <span class="align-text-bottom fs-005 fw-300">카페회원에게 모임개설을 공지합니다</span></label>
							</div>
							</div>
							<p class="fs-005 color-6 text-center">* 허위정보 및 비정상적 클래스 모임생성시 이용이 제한될 수 있습니다.</p>
							<div class="mt-2">
								<a href="javascript:go_make_meeting();" class="btn-block btn btn-primary fs-0">모임생성</a>
							</div>
						</div>
						<? include "./inc_Bottom_channel.php"; ?>
					</div>
				</div>
			</section>
		</form>
		</body>
<script>
	$(function(){
			$('#meet-date').bootstrapMaterialDatePicker({ format : 'YYYY-MM-DD / HH:mm', lang : 'kr'  });
			$('.nav_bottom li[data-name="channelmade"]').addClass('active');
	});	
</script>
</html>
