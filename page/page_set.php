<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<script>
	function go_modify_ok(){
		
		var form = $("#frm")[0];

		var formData = new FormData(form);
		formData.append("페이지배경사진", $("#페이지배경사진")[0].files[0]);
		formData.append("페이지프로필사진", $("#페이지프로필사진")[0].files[0]);


		$.ajax({
			url: "_ajax_page_set.php",
			processData: false,
			contentType: false,
			data: formData,
			type: 'POST',
			success: function(data){
				if(data == "SUCCESS"){
					alert('감사합니다. 페이지 설정이 성공적으로 이루어졌습니다.');
					top.location.reload(true);
				}else if(data == "MANDATORY_ERROR"){
					alert('필수 항목이 누락되었습니다.');
				}else if(data == "DUP_NICKNAME"){
					alert('중복된 닉네임입니다.');
					$("#닉네임").val("");
					$("#닉네임").focus();
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

<body class="mb-5">
<header class="header top_fixed">
	<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
	<h2 class="header-title text-center">내페이지 설정</h2>
</header>


<section class="wrap-join py-0">
	<div class="container-fluid header-top-sub">
		<div class="row align-items-center justify-content-center">
			<div class="col-sm-10 col-lg-8 col-xl-7 p-0">
			<div class="p-3 bg-gradient-primary color-white">
				<h2 class="fs-005 fw-300 mb-1 color-white"><?=$rowMember['name']?> (UID <?=$rowMember['UID']?>) <span class="bar opacity-75"></span><?=$rowMember['email']?></h2>
				<h2 class="fs-005 fw-300 mb-1 color-white">회원가입일<span class="bar opacity-75"></span><?=date("Y-m-d",strtotime($rowMember['regdate']))?></h2>
			</div>
				<form name="frm" id="frm" method="post" class="p-3">
				 <div class="form-group">
					<label for="">내페이지 주소</label>
					<p onclick="copyToAddress('#copyAddress')" class="address fs--1">
						<span id="copyAddress" class="text-address">https://<?=$_SERVER['HTTP_HOST']?>/page/page_user.php?UID=<?=$rowMember[UID]?></span>
						<span class="text-copy">복사</span>
					</p>
				 </div>
				 <div class="form-group row mx-0">
					<div class="box col-8 p-0">
					 <label for="">배경사진</label>
						<div class="js-image-preview" style="background-image: url('<?=phpThumb("/_UPLOAD/".$rowMember['페이지배경사진'], 500, 192, "2")?>');">
							<input type="file" id="페이지배경사진" name="페이지배경사진" class="image-upload" accept="image/*">
						</div>
					</div>
				 <div class="box col-4 p-0">
					 <label for="">프로필 사진</label>
						<div class="js-image-preview" style="background-image: url('<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 247, 192, "2")?>');">
							<input type="file" id="페이지프로필사진" name="페이지프로필사진" class="image-upload" accept="image/*">
						</div>
					</div>
					</div>

					<div class="form-group">
						<label for=""><?=$dic['Nic']?></label>
						<input class="form-control" type="text" name="닉네임" id="닉네임" placeholder="<?=$dic['Nic']?>" value="<?=$rowMember['닉네임']?>">
					</div>

					<div class="form-group">
						<label for="">내 페이지 소개/인사말 <span class="red">*</span></label>
						<textarea class="form-control" name="페이지이름" id="페이지이름" rows="8" placeholder="내 페이지 소개, 인사말을 입력해 주세요."><?=$rowMember['페이지이름']?></textarea>
					</div>

					<div class="form-group">
						<label for="">거주지역 (시도/구군) <span class="red">*</span></label>
						<select class="form-control mb-1" size="1" id="시도" name="시도" onChange="go_change_시도();">
							<option value="">시/도를 선택해주세요</option>
							<option value="<?=$rowMember['시도']?>" selected><?=$rowMember['시도']?></option>
							<?
							for ($i=0; $i<sizeof($시도배열); $i++){
							?>
							<option value="<?=$시도배열[$i]?>"><?=$시도배열[$i]?></option>
							<?}?>
						</select>
						<select class="form-control mb-1" size="1" id="구군" name="구군">
							<option value="">구/군을 선택해주세요</option>
							<option value="<?=$rowMember['구군']?>" selected><?=$rowMember['구군']?></option>
						</select>
					</div>

					<div class="form-group">
						<label for="">출신지역 <span class="red">*</span></label>
						<input class="form-control" type="text" name="출신지역" id="출신지역" value="<?=$rowMember['출신지역']?>" placeholder="출신지역을 입력해 주세요.">
					</div>

					<div class="form-group">
						<label for=""><?=$dic['Born_year']?> <span class="red">*</span></label>
						<input class="form-control" type="number" name="birthday" id="birthday" value="<?=$rowMember['birthday']?>" placeholder="YYYYMMDD">
					</div>

					<div class="form-group">
						<label for=""><?=$dic['Sex']?> <span class="red">*</span></label>
						<select class="form-control mb-1" size="1" id="gender" name="gender">
							<option value=""><?=$dic['Select']?></option>
							<option value="남" <?=$rowMember['gender']=="남"?"selected":""?>><?=$dic['Sex_male']?></option>
							<option value="여" <?=$rowMember['gender']=="여"?"selected":""?>><?=$dic['Sex_pemale']?></option>
						</select>
					</div>

					<div class="form-group">
						<label for="">결혼여부(선택)</label>
						<select class="form-control mb-1" size="1" id="결혼여부" name="결혼여부">
							<option value=""><?=$dic['Select']?></option>
							<option value="Y" <?=$rowMember['결혼여부']=="Y"?"selected":""?>>기혼</option>
							<option value="N" <?=$rowMember['결혼여부']=="N"?"selected":""?>>미혼</option>
						</select>
					</div>
					<div class="form-group">
						<label for="">결혼기념일(선택)</label>
						<input class="form-control" type="number" name="결혼기념일" id="결혼기념일" placeholder="YYYYMMDD / 기혼자만 입력하세요" value="<?=$rowMember['결혼기념일']?>">
					</div>
					<div class="form-group position-r">
						<label for="">출신고등학교(선택)</label>
						<input class="form-control" id="출신고등학교" name="출신고등학교" type="text" placeholder="출신고등학교를 입력해주세요" value="<?=$rowMember['출신고등학교']?>"/>
					</div>
					<div class="form-group position-r">
						<label for="">출신대학교(선택)</label>
						<input class="form-control" id="출신대학교" name="출신대학교" type="text" placeholder="출신대학교를 입력해주세요" value="<?=$rowMember['출신대학교']?>"/>
					</div>
					<div class="form-group">
						<label for="">공개여부 <span class="red">*</span></label>
						<select class="form-control mb-1" size="1" id="공개여부" name="공개여부">
							<option value=""><?=$dic['Select']?></option>
							<option value="전체공개" <?=$rowMember['공개여부']=="전체공개"?"selected":""?>>전체공개</option>
							<option value="친구만공개" <?=$rowMember['공개여부']=="친구만공개"?"selected":""?>>친구만공개</option>
							<option value="미공개" <?=$rowMember['공개여부']=="미공개"?"selected":""?>>미공개</option>
						</select>
					</div>
					<div class="mt-3">
						<a href="javascript:go_modify_ok();" class="btn-block btn btn-primary mb-3 fs-0">저장</a>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</section>
<? include "./inc_Bottom_page.php"; ?>
</body>
<script>
  

 $('.nav_category li[data-name="gnb-page"]').addClass('active');
 $('.nav_bottom li[data-name="page"]').addClass('active');

</script>
</html>