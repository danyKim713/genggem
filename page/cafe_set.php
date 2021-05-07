<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">


<body class="mb-5">
<header class="header top_fixed">
	<h2 class="header-title text-center">설정</h2>
</header>

<section class="py-0">
	<div class="container-fluid header-top-sub">
		<div class="row align-items-center justify-content-center">
			<div class="col-sm-10 col-lg-10 col-xl-6 p-0">
			<div class="p-3 bg-dark">
				<h2 class="font-2 fs-005 fw-300 mb-1 color-10"><?=$rowMember['name']?> (UID <?=$rowMember['UID']?>)<span class="bar opacity-75"></span><?=$rowMember['email']?></h2>
				<h2 class="font-2 fs-005 fw-300 mb-1 color-10">회원가입일<span class="bar opacity-75"></span><?=date("Y-m-d",strtotime($rowMember['regdate']))?></h2>
			</div>
				<form name="frm" id="frm" method="post" class="p-3">
				 <!-- 내가 가입한 채널 정보 -->
				 <?/*<div class="form-group">
					<label>내가 가입한 카페</label>
					<ul class="list list-border background-white">

<?
$query = "
	select fk_channel, 운영진여부 as 운영진여부 from gf_channel_member where 강퇴여부 = 'N' and fk_member = '{$rowMember['member_id']}' 

	UNION

	select pk_channel as fk_channel, 'N' as 운영진여부 from gf_channel where member_id = '{$rowMember['member_id']}'
";
$result = db_query($query);

while($row = db_fetch($result)){

	$rowC = db_select("select * from gf_channel where pk_channel = '{$row['fk_channel']}'");
?>

						<li class="p-3">
							<div class="d-flex align-items-center justify-content-between">
								<div>
									<h4 class="fs-005 ellipsis mb-1"><?=$rowC['채널이름']?>
									
<?if($rowC['member_id'] == $rowMember['member_id']){?>
									<small class="color-6"><i class="fas fa-crown fs--1 color-warning"></i>   </small>
<?}?>

<? if($row['운영진여부'] == "Y"){?>
									<small class="color-6"><i class="fas fa-medal fs--1 color-purple ml-1"></i>  운영진</small>
<?}?>
									
									</h4>
									<div class="address fs--1 channel-set-address">
										<a href="channel_view.php?CID=<?=$rowC['CID']?>" title="채널 바로가기" class="text-address" id="copyAddress"><?=isSecure()?"https":"http"?>://<?=$_SERVER['HTTP_HOST']?>/page/channel_view.php?CID=<?=$rowC['CID']?></a>
									</div>
								</div>
								<div class="text-right">
									<span class="text-copy" onclick="copyToAddress('#copyAddress')">복사</span>
									<!-- <span class="text-copy">공유</span> -->
								</div>
							</div>
						</li>

<?}?>
					</ul>
				 </div>
				 <!--//내가 가입한 채널 정보-- */?>

					<!--내 관심 주제-->
					<div class="form-group">
					 <label>내 관심 주제</label>
					 	<span class="fs--1 float-right fw-400 color-primary mt-1"><i class="fas fa-check-square opacity-50"></i> 중복설정가능</span>
						<div class="list-category background-white">
							<ul class="row text-center">

<?
for ($i=1; $i<=count($채널카테고리배열); $i++){
	$채널카테고리 = $채널카테고리배열[$i-1];

	$m = $i<10 ? "0".$i : $i;
?>

								<li class='col-3 radiobox'>
									<input id="type<?=$m?>" type="checkbox" name="채널관심주제[]" class="invisible" <?=strpos($rowMember['채널관심주제'], $채널카테고리)>-1 ? "checked" : ""?> value="<?=$채널카테고리?>"/>
									<label for="type<?=$m?>">											
										<img src="assets/images/icon/CH<?=$m?>.png" width="60" alt="레슨">
										<span class="d-block py-1"><?=$채널카테고리?></span>
									</label>
								</li>
<?}?>
								
							</ul>
						</div>
					</div>
					<!--//내 관심 주제-->
					
					<!--알림 설정-->
					<div class="form-group">
					  <label>채팅/알림 설정</label>
						<ul class="list list-border background-white">
							<li class="p-3 d-flex align-items-center justify-content-between">
								<h4 class="fs-005 mb-0">채팅글 알림 사용</h4>
								<div>
									<label class="form-switch" for="chkChat">
										<input type="checkbox" id="chkChat" name="채팅글알림사용여부" <?=$rowMember['채팅글알림사용여부'] == "Y"?"checked":""?> value="Y"/><i></i>
									</label>
								</div>
							</li>
							<li class="p-3 d-flex align-items-center justify-content-between">
								<h4 class="fs-005 mb-0">메세지 알림 사용</h4>
								<div>
									<label class="form-switch" for="chkMsg">
										<input type="checkbox" id="chkMsg" name="메시지알림사용여부" <?=$rowMember['메시지알림사용여부'] == "Y"?"checked":""?> value="Y"/><i></i>
									</label>
								</div>
							</li>
						</ul>
					</div>
					<!--//알림 설정-->
					
					<!--내 관심 카페채널-->
					<div class="form-group">
						<label>내 관심 카페</label>
						<div class="list list-default background-white p-3">
							<ul>

<?
$query = "select * from gf_channel_interested where fk_member = '{$rowMember['member_id']}'";
$result = db_query($query);

while($row = db_fetch($result)){

	$rowC = db_select("select * from gf_channel where pk_channel = '{$row['fk_channel']}'");

	$rowCnt = db_select("select count(*) as cnt from gf_channel_member where fk_channel = '{$row['fk_channel']}' and 강퇴여부 = 'N'");
	$멤버수 = number_format($rowCnt['cnt']) + 1;
?>

								<li>
									<a href="cafe.php?CID=<?=$rowC['CID']?>" title="">
										<div>
											<img src="<?=phpThumb("/_UPLOAD/".($rowC['채널배경사진']),90,90,"2","assets/images/ex_img6.jpg")?>" width="90" height="90" class="radius-5" />
										</div>
										<div class="con-info con-channel">
											<h4 class="fs-005 ellipsis">

<? if($rowC['member_id'] == $rowMember['member_id']){?>
											<i class="fas fa-crown fs--1 color-warning"></i>
<?}?>

											<?=$rowC['채널이름']?></h4>
											<p class="color-5"><?=$rowC['채널설명']?></p>
											<span class="color-6 fs--1"><i class="fas fa-map-marker-alt opacity-50 mr-1"></i><?=$rowC['시도']?></span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 멤버 <?=$멤버수?>명</span>
										</div>
									</a>
								</li>
<?}?>
							</ul>
						</div>		
					</div>
					<!--//내 관심 카페-->
					<div class="mt-4">
						<a href="javascript:go_channel_save_setting();" class="btn-block btn btn-primary fs-0">저장</a>
					</div>
				</form>
			
			</div>
		</div>
	</div>
</section>
<? include "./inc_Bottom_cafe.php"; ?>
</body>
<script>
  //    이미지등록
  function initImageUpload(box) {
    let uploadField = box.querySelector('.image-upload');

    uploadField.addEventListener('change', getFile);

    function getFile(e) {
      let file = e.currentTarget.files[0];
      checkType(file);
    }

    function previewImage(file) {
      let thumb = box.querySelector('.js-image-preview'),
        reader = new FileReader();

      reader.onload = function() {
        thumb.style.backgroundImage = 'url(' + reader.result + ')';
        thumb.style.backgroundSize = 'cover';
        thumb.style.zIndex = '2';
      }
      reader.readAsDataURL(file);
      thumb.className += ' js--no-default';
    }

    function checkType(file) {
      let imageType = /image.*/;
      if (!file.type.match(imageType)) {
        throw 'Datei ist kein Bild';
      } else if (!file) {
        throw 'Kein Bild gewählt';
      } else {
        previewImage(file);
      }
    }

  }

  var boxes = document.querySelectorAll('.box');

  for (let i = 0; i < boxes.length; i++) {
    let box = boxes[i];
    initImageUpload(box);
  }

  function initDropEffect(box) {
    let area, drop, areaWidth, areaHeight, maxDistance, dropWidth, dropHeight, x, y;

    area = box.querySelector('.js-image-preview');
    area.addEventListener('click', fireRipple);

    function fireRipple(e) {
      area = e.currentTarget

    }
  }
	//주소복사
		function copyToAddress(element) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val($(element).html()).select();
			document.execCommand("copy");
			$temp.remove();
			alert('주소를 복사했습니다.');
		}

 $('.nav_bottom li[data-name="cafeset"]').addClass('active');

</script>
</html>