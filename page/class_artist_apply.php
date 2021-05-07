<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";

    $query  = " SELECT COUNT(*) AS cnt  \n";
    $query .= " FROM   tbl_coach   \n";
    $query .= " WHERE  member_id='".$ck_login_member_pk."'   \n";    
    $query .= " AND    use_flg = 'AD005002'   \n";    // 코치(사용중지)

    $rowCoach = db_select($query);    

    if ($rowCoach["cnt"] > 0) {  // 사용중이면
        msg_page("회원님은 아티스트 사용제한이 되어 있습니다. 관리자에게 문의 하세요.");
        exit;
    }

?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<script src="/common/script/regexp.js"></script>
<script>
	function go_chk_동의(){
		var 동의 = true;

        if ($('#selCareer').val() == "") {
            alert("커리어를 선택하세요.");
            $('#selCareer').focus();
            return;
        }

        if ($.trim($('#txtname').val()) == "") {
            alert("이름을 입력하세요.");
            $('#txtname').focus();
            return;
        }

        if ($('#txthp').val() == "") {
            alert("연락처를 입력하세요.");
            $('#txthp').focus();
            return;
        }
<?
/*
        if (pattern_N.test($('#txthp').val())) {
            alert("연락처는 숫자만 입력가능합니다.");
            $('#txthp').focus();
            return;
        }
*/
?>
        if ($.trim($('#txtCareer').val()) == "") {
            alert("주요경력/활동 사항을 입력하세요.");
            $('#txtCareer').focus();
            return;
        }

        $(".동의").each(function(){
			if(!$(this).prop("checked")){
				동의 = false;
			}
		});
		if(!동의){
			alert('<?=$dic[Agree_alert]?>');
		}else{
            if (confirm("아티스트 등록을 신청하시겠습니까?")) {
                $.ajax({
                    url: 'class_artist_apply_save.php',
                    type: 'POST',
                    data: $('#frm').serialize(),
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
                    dataType: 'text',
                    success: function (Data) {
                        if (Data == "ALREADY") {
                            alert("이미 아티스트 등록 신청중입니다.")
                        } else if (Data == "COACH") {
                           alert("이미 아티스트로 활동중입니다.");
                        } else if (Data == "SUCCESS") {
                           alert("아티스트 등록 신청이 접수되었습니다.");
                           top.location.href = "class_apply_confirm.php";
                        } else if (Data == "FAILED") {
                            alert("등록신청이 실패했습니다. 관리자에게 문의하세요.");
                        }
                    }
                });
            }
		}
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


	<!-- ##### category Area Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h2>아티스트 등록</h2>
				</div>				
			</div>

			<div class="row">

				<section class="col-sm-12">
					<div class="container-fluid">
						<div class="row align-items-center justify-content-center">
							<div class="col-sm-12 col-lg-12 p-0">
								<div class="p-3 bg-gradient-primary color-white">
									<h2 class="font-2 fs-005 fw-500 mb-1"><font color="#ffffff"><?=$rowMember['name']?> (UID <?=$rowMember['UID']?>) <span class="bar opacity-75"></span><?=$rowMember['email']?></font></h2>
									<h2 class="font-2 fs-005 fw-400 mb-1"><font color="#ffffff">회원가입일 <span class="bar opacity-75"></span><?=date("Y-m-d",strtotime($rowMember['regdate']))?></font></h2>
								</div>

								<form name="frm" id="frm" method="post" class="p-3">

								<?
									// 아티스트인지 조회
									$query = "SELECT * FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";

									$resultCoach = db_query($query); 
									$rowCoach = mysqli_fetch_array($resultCoach);

									$cntCoach = mysqli_num_rows($resultCoach); 
									$is_view = true;
									if ($cntCoach > 0) {  // 아티스트이면 
										$is_view = false;
								?>
								<div class="form-group">
									<label for="">나의 아티스트 블로그 주소</label>
									<p onclick="copyToAddress('#copyAddress')" class="address fs--1">
									<span id="copyAddress" class="text-address">http://<?=$_SERVER['HTTP_HOST']?>/page/artist.php?txtRecordNo=<?=$rowMember[co_id]?></span>
									<span class="text-copy">공유</span>
									</p>
								</div> 
								<div class="form-group"><br>
									<label for="">* 회원님은 이미 아티스트로 등록되어 이용중입니다.<br>
									* 아래 버튼 또은 우측하단 '<font color="#ff0033">클래스관리</font>' 메뉴에서 '<font color="#ff0033">기본설정</font>' 내용을 설정해 주어야 정상적인 이용이 가능합니다.<br>
									* 클래스 등록, 클래스 주문/신청 관리는 '<font color="#ff0033">클래스관리</font>' 메뉴를 이용해 주시기 바랍니다.
									</label>
								</div>
								<a href="class_set.php" class="btn-block btn btn-primary mt-5 mb-5 fs-0">아티스트 기본설정 / 클래스 등록</a>

								<? 
									} else {  // 아티스트가 아니면 
										// 현재회원의 아티스트 신청내역 조회(마지막 1건)
										$query = "SELECT * FROM tbl_lesson_apply WHERE member_id='".$ck_login_member_pk."'  ORDER BY ap_dt DESC LIMIT 1" ;
										$resultCoachApply = db_query($query); 
										$rowCoachApply = mysqli_fetch_array($resultCoachApply);

										$nApplyCount = mysqli_num_rows($resultCoachApply);
										

										if ($nApplyCount > 0) {// 아티스트 신청내역이 있으면
											if ($rowCoachApply['status_flg'] == "COAPYAPY") {  // 신쳥상태가 '신청중'이면
												$is_view = false;

								?>			
								<div class="form-group text-center mt-3">
									<label for=""><h6><?=$rowMember['name']?>님께서는 이미 아티스트 등록을 신청하셨습니다.<br>
									관리자 확인 중이며 승인 후 이용할 수 있습니다.<br>
									신청해 주셔서 대단히 감사합니다.</h6></label>
								</div>
								<?
											} else if ($rowCoachApply['status_flg'] == "COAPYREF") {  // 신쳥상태가 '거부'이면
								?>
								<div class="form-group">
									<label for="">아래와 같은 이유로 아티스트등록이 거부되었습니다. 거부사유를 확인하신 후 재등록 해 주시기 바랍니다.<br><br>
									거부사유: <?=$rowCoachApply['memo']?></label>
								</div>
								<?          }
										} else {  // 아티스트 신청내역이 없으면
								?>
								<div class="form-group">
									<label for="">* 아티스트 등록신청해 주시면 관리자 확인후 승인해 드립니다.<br>
									* 아티스트로 등록되시면 오픈클래스 서비스를 이용하여 클래스 상품을 판매할 수 있습니다.</label>
								</div>
								<?  
										}
									}

									if ($is_view) {
								?>
			
								<div class="form-group">
									<label for="">커리어</label>
									<select class="form-control mb-1" size="1" id="selCareer" name="selCareer">
										<option value="">-- 선택 --</option>
										<?
											$resultCareer = db_query("SELECT * FROM sysT_CommonCode WHERE major_cd = 'CARER' AND minor_cd <> '$' AND use_flg  = 'AD005001' ORDER BY seq, minor_cd");
											while($rowCareer = db_fetch($resultCareer)){
										?>
										<option value="<?=$rowCareer['major_cd'].$rowCareer['minor_cd']?>"><?=$rowCareer['cd_nm']?></option>

										<?
											}
										?>
									</select>
								</div>

								<div class="form-group">
									<label for="">이름</label>
									<input class="form-control" type="text" name="txtname" id="txtname" placeholder="<?=$rowMember['name']?>" value="<?=$rowMember['name']?>" readonly="readonly" style="background:#e7e7e7">
								</div>
								<div class="form-group">
									<label for="">연락처</label>
									<input class="form-control" type="text" name="txthp" id="txthp" placeholder="<?=$rowMember['hp']?>" value="<?=$rowMember['hp']?>" readonly="readonly" style="background:#e7e7e7">
								</div>
								<!-- <div class="form-group">
									<label for="">기본지역 선택 (클래스 주 활동 지역을 선택해 주세요.)</label>
									<select id="selarea" name="클래스기본지역" class="form-control mb-1" size="1">
									<option value="">--선택하세요--</option>

									<?
									$query = "select distinct 지점1 from gf_weather_area where 지점1=지점2 order by 지점코드 ";
									$resultA = db_query($query);

									while($rowA = db_fetch($resultA)){
									?>
									<option value="<?=$rowA['지점1']?>"><?=$rowA['지점1']?></option>
									<?}?>
									</select>
								</div> -->

								<div class="form-group">
									<label for="">주요경력/활동 사항</label>
									<textarea name="txtCareer" id="txtCareer" class="form-control" placeholder="등록하실 아티스트님의 이력이나 경력, 인사말, 홈페이지, sns 등을 기입해 주세요." rows="6"></textarea>
								</div>
								<div class="con-article background-white p-3">
									<? include "_terms4".($_COOKIE['dic_lang']!="ko"?"_en":"").".php";?>
								</div>
								<div class="py-2 border-top color-10">
									<div class="checkbox check-square">
										<input id="chk2" name="agree" type="checkbox" class="invisible 동의" data-alert="아티스트 약관에 동의해 주세요.">
										<label for="chk2" class="color-5 fs--1 mb-0 fw-400"><i class="biko-check color-5"></i> 아티스트약관 동의<span class="color-6">&#40;<?=$dic['Essential']?>&#41;</span></label>
									</div>
								</div>
								<!-- //영상설정 -->
								<div class="mt-5 mb-4">
									<a href="javascript:go_chk_동의();" class="btn-block btn btn-primary mb-3 fs-0">아티스트 등록신청</a>
								</div>
								</form>
								<?
									}
								?>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
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
			alert('주소를 복사했습니다. 원하시는곳에 붙여넣기 하시면 됩니다.');
		}

	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="artistapply"]').addClass('active');


</script>
</html>