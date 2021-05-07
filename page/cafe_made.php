<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
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

	function go_reg_channel(){
		var params = $("#frm").serialize();

		$.ajax({
			type: 'POST',
			url: "_ajax_channel_reg.php",
			data: params,
			async: false,
			success: function(result){
				if(result=="SUCCESS"){
					alert('클럽생성에 성공하였습니다.');
					top.location.href = "cafe_made3.php";
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
				<h2 class="header-title text-center">클럽생성</h2>
			</header>
			<section class="wrap-channelmade py-0">
				<div class="container-fluid header-top-sub">
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-10 col-lg-10 col-xl-6 p-3">
							<div class="form-group">
								<label for="">클럽 주제를 선택해 주세요</label>
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
										<input id="type<?=$m?>" type="radio" name="channelCate" class="invisible" value="<?=$카테고리?>" required/>
										<label for="type<?=$m?>">											
											<img src="assets/images/icon/CH<?=$m?>.png" width="60" alt="<?=$카테고리?>">
											<span class="d-block py-1"><?=$카테고리?></span>
										</label>
									</li>
								<?}?>									
								</ul>
							</div>
							</div>
							<div class="form-group">
								<label for="">지역 선택</label>
								<select class="form-control mb-1" size="1" id="시도" name="시도" onChange="go_change_시도();" required>
									<option value="">시/도를 선택해주세요</option>
									<?
						for ($i=0; $i<sizeof($시도배열); $i++){
						?>
										<option value="<?=$시도배열[$i]?>">
											<?=$시도배열[$i]?>
										</option>
										<?}?>

								</select>
								<select class="form-control" size="1" id="구군" name="구군" required>
									<option value="">구/군을 선택해주세요</option>
								</select>
							</div>

							<div class="form-group">
								<label for="">클럽 이름</label>
								<input class="form-control" id="채널이름" name="채널이름" type="text" placeholder="클럽 이름을 입력해 주세요."  required/>
							</div>
							<div class="form-group">
								<label for="">클럽 태그</label>
								<input class="form-control" id="채널태그" name="채널태그" type="text" placeholder="#으로 구분해서 입력 예)#부킹 #진실 #프로 #교육"  required/>
							</div>
							<div class="form-group">
								<label>클럽 연령대</label>
								<span class="fs--1 float-right fw-400 color-primary mt-1"><i class="fas fa-check-square opacity-50"></i> 최대 3개 중복선택가능</span>
								<div class="row m-0">

<?
for($a=0; $a<sizeof($모임연령대배열); $a++){
?>

									<div class="col-4 check-rbox">
										<input type="checkbox" id="age<?=$a?>" name="channelAge[]" class="invisible" value="<?=$모임연령대배열[$a]?>"/>
										<label for="age<?=$a?>"><?=$모임연령대배열[$a]?></label>
									</div>
<?}?>
								</div>
							</div>


							<div class="form-group">
								<label for="">클럽 설명</label>
								<textarea name="채널설명" id="채널설명" class="form-control" placeholder="어떤 클럽인지 설명해 주세요" rows="3" required></textarea>
							</div>

							<!-- 아래 클럽정원(상품)은 보여주기 위함입니다. 고객의 정확한 클럽상품은 다음페이지에서 선택합니다. -->
<!--
							<div class="form-group">
								<label for="">클럽 정원</label>
								<select class="form-control" size="1" id="" name="">
									<option value="">선택해 주세요.</option>
									<option value="basic">Basic : 20명(1개월사용)</option>
									<option value="premuim">Premuim : 1000명</option>
								</select>
							</div>
-->
							<!--//-->
							<div class="mt-4">
								<a href="javascript:go_reg_channel();" class="btn-block btn btn-primary mb-3 fs-0">
									<?=$dic['Next']?>
								</a>
							</div>
						</div>
						<? include "./inc_Bottom_cafe.php"; ?>
					</div>
				</div>
			</section>
			</form>
		</body>

		<script>
			//클럽연령대 개수제한
			$('input[type=checkbox]').click(function(){
			var chkCount = $('input[type=checkbox]:checked').length; 
			if(chkCount>3){
			 $(this).prop('checked', false);
			}                                                     
		 });
			$('.nav_bottom li[data-name="cafemade"]').addClass('active');
		</script>
</html>
