<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";

$_SESSION['S_CID'] = $CID;
?>
<script>
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

	function go_modify_channel(){
		//var params = $("#frm").serialize();

		var form_data = new FormData($('form')[0]);

		form_data.append("채널배경사진", document.getElementById('채널배경사진').files[0]);

		$.ajax({
			type: 'POST',
			url: "_ajax_channel_modify.php",
			data: form_data,
			processData: false,
			contentType: false,
			async: false,
			success: function(result){
				if(result=="SUCCESS"){
					alert('카페수정에 성공하였습니다.');
					top.location.reload(true);
				}else if(result == "MANDATORY_ERROR"){
					alert('필수 입력항목을 입력해주세요.');
				}else{
					alert('오류가 발생했습니다. 관리자에게 문의바랍니다.');
				}
			}
		});
	}
</script>
	<? include "./inc_Head.php"; ?>

		<body class="mb-6">
		<form name="frm" id="frm" method="post">
			<header class="header top_fixed">
				<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
				<h2 class="header-title text-center">내카페설정</h2>
			</header>
			<section class="wrap-channelmade py-0">
				<div class="container-fluid header-top-sub">
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-10 col-lg-8 col-xl-5 p-3">
							<div class="form-group">
								<label for="">카페 주제를 선택해 주세요</label>
								<div class="list-category background-white">
								<ul class="row text-center">

<?
$idx = 0;
foreach($채널카테고리배열 as $카테고리){
	$idx++;
	if($idx < 10){
		$m = "0".$idx;
	}else{
		$m = $idx;
	}
?>

									<li class='col-3 radiobox'>
										<input id="type<?=$m?>" type="radio" name="channelCate" class="invisible" value="<?=$카테고리?>" required <?=$rowChannel['채널카테고리']==$카테고리 ? "checked":""?>/>
										<label for="type<?=$m?>">											
											<img src="assets/images/icon/CH<?=$m?>.png" width="60" alt="<?=$카테고리?>">
											<span class="d-block py-1"><?=$카테고리?></span>
										</label>
									</li>
<?}?>									
								</ul>
							</div>
							</div>

							<!-- 모임 배경이미지 설정-->
							<div class="form-group row mx-0">
								<div class="box col-12 p-0">
								 <label for="">카페 배경사진 (권장 사이즈 : 697 x 400 px)</label>
									<div class="js-image-preview" style="background-image: url('/_UPLOAD/<?=rawurlencode($rowChannel['채널배경사진'])?>');">
										<input type="file" id="채널배경사진" name="채널배경사진" class="image-upload" accept="image/*">
									</div>
								</div>
							</div>
							<!--//배경설정 끝-->

							<div class="form-group">
								<label for="">지역 선택</label>
								<select class="form-control mb-1" size="1" id="시도" name="시도" onChange="go_change_시도();" required>
									<option value="">시/도를 선택해주세요</option>
									<?
						for ($i=0; $i<sizeof($시도배열); $i++){
						?>
										<option value="<?=$시도배열[$i]?>" <?=$rowChannel['시도']==$시도배열[$i]?"selected":""?>>
											<?=$시도배열[$i]?>
										</option>
										<?}?>

								</select>
								<select class="form-control" size="1" id="구군" name="구군" required>
									<option value="">구/군을 선택해주세요</option>
									<option value="<?=$rowChannel['구군']?>" selected><?=$rowChannel['구군']?></option>
								</select>
							</div>

							<div class="form-group">
								<label for="">카페 이름</label>
								<input class="form-control" id="채널이름" name="채널이름" type="text" placeholder="카페 이름을 입력해 주세요."  required value="<?=$rowChannel['채널이름']?>"/>
							</div>
							<div class="form-group">
								<label for="">카페 태그</label>
								<input class="form-control" id="채널태그" name="채널태그" type="text" placeholder="#으로 구분해서 입력 예)#부킹 #진실 #프로 #교육"  required value="<?=$rowChannel['채널태그']?>"/>
							</div>
							<div class="form-group">
								<label>카페 연령대</label>
								<span class="fs--1 float-right fw-400 color-primary mt-1"><i class="fas fa-check-square opacity-50"></i> 최대 3개 중복선택가능</span>
								<div class="row m-0">

<?
$채널배열 = explode(",",$rowChannel['채널연령대']);
for($a=0; $a<sizeof($모임연령대배열); $a++){
?>

									<div class="col-4 check-rbox">
										<input type="checkbox" id="age<?=$a?>" name="channelAge[]" class="invisible" value="<?=$모임연령대배열[$a]?>" <?=in_array($모임연령대배열[$a], $채널배열)?"checked":""?>/>
										<label for="age<?=$a?>"><?=$모임연령대배열[$a]?></label>
									</div>
<?}?>

								</div>
							</div>


							<div class="form-group">
								<label for="">카페 설명</label>
								<textarea name="채널설명" id="채널설명" class="form-control" placeholder="어떤 모임인지 설명해 주세요" rows="10" required><?=$rowChannel['채널설명']?></textarea>
							</div>

							<!-- 아래 모임정원(상품)은 보여주기 위함입니다. 고객의 정확한 모임상품은 다음페이지에서 선택합니다. -->
<!--
							<div class="form-group">
								<label for="">모임 정원</label>
								<select class="form-control" size="1" id="" name="">
									<option value="">선택해 주세요.</option>
									<option value="basic">Basic : 20명(1개월사용)</option>
									<option value="premuim">Premuim : 1000명</option>
								</select>
							</div>
-->
							<!--//-->
							<div class="mt-4">
								<a href="javascript:go_modify_channel();" class="btn-block btn btn-primary mb-3 fs-0">
									확인
								</a>
							</div>
						</div>
						<? include "./inc_Bottom_channel.php"; ?>
					</div>
				</div>
			</section>
			</form>
		</body>

		<script>
			//모임연령대 개수제한
			$('input[type=checkbox]').click(function(){
			var chkCount = $('input[type=checkbox]:checked').length; 
			if(chkCount>3){
			 $(this).prop('checked', false);
			}                                                     
		 });
			$('.nav_bottom li[data-name="channelmade"]').addClass('active');
		</script>

<? include "./inc_Bottom_cafe.php"; ?>

<script>
	$('.nav_category li[data-name="gnb-channel"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>
