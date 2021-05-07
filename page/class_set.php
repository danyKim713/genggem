<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
// 코치인지 조회
    $query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
    $resultCoach = db_query($query);
    $cntCoach = mysqli_num_rows($resultCoach); 

    if ($cntCoach <= 0) {  // 코치이면  
        msg_page("아티스트 회원만 사용가능합니다.(사용제한된 아티스트는 사용하실 수 없습니다. 관리자에게 문의 하세요.)");
        exit;
    }

    $rowCoach = db_fetch($resultCoach);


?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body class="mb-5">
<?
// 회원 레슨 설정 정보 가져오기
$query = "select * from tbl_lesson_setup where member_id='".$ck_login_member_pk."'";
//echo $query;
$rowWatch = db_select($query); 


$strNotice = ""; 
if ($rowWatch["notification_flg"] == "AD005001" || $rowWatch["notification_flg"] == "") $strNotice = "checked"; 


$strImg1 = "";
$strImg2 = "";

if (trim($rowWatch["background_photo"]) != "") {
    $strImg1 = $rowWatch["background_photo"];
}

if (trim($rowWatch["profile_photo"]) != "") {
    $strImg2 = $rowWatch["profile_photo"];
}

// 코치인지 조회
$cntCoach = db_count("tbl_coach", "member_id='".$ck_login_member_pk."' AND use_flg='AD005001'", "co_id"); 


?>


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
					<h4>아티스트/블로그 기본설정</h4>
				</div>

				<div class="col-sm-12 col-lg-12">

					<form name="frm" id="frm" method="post" enctype="multipart/form-data">

					 <!-- 코치회원인 경우에만 노출 -->
					 <div class="form-group mt-2">
						<label for="" class="fs-0">나의 아티스트 블로그 주소 <a href="artist.php?txtRecordNo=<?=$rowCoach["co_id"]?>"><span class="btn btn-info btn-xs">내블로그 바로가기</span></a></label>
						<p onclick="copyToAddress('#copyAddress')" class="address">
							<span id="copyAddress" class="text-address">http://<?=$_SERVER['HTTP_HOST']?>/page/artist.php?txtRecordNo=<?=$rowCoach["co_id"]?></span>
							<span class="text-copy">블로그 주소복사</span>
						</p>
					 </div>
					 <div class="form-group row mx-0">
						<div class="box col-8 p-0">
						 <label for="">블로그 배경사진</label>
							<div class="js-image-preview" style="background-image: url('/ImgData/WatchImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowWatch["background_photo"])?>');">
								<input type="file" id="txtBGPic" name="txtBGPic" class="image-upload" accept="image/*">
							</div>
						</div>
						<div class="box col-4 p-0">
							<label for="">아티스트 프로필사진</label>
							<div class="js-image-preview" style="background-image: url('/ImgData/WatchImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowWatch["profile_photo"])?>');">
								<input type="file" id="txtProPic" name="txtProPic" class="image-upload" accept="image/*">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="">회원 이름 (일반 회원에게는 노출되지 않습니다.)</label>
						<input class="form-control" type="text" laceholder="<?=$rowMember['name']?>" value="<?=$rowMember['name']?>" readonly="readonly">
					</div>
					<div class="form-group">
						<label for="">아티스트/블로그 타이틀 (아티스트 및 블로그 제목을 입력해 주세요.)</label>
						<input class="form-control" type="text" name="txtLessonTitle" id="txtLessonTitle" maxlength="50" value="<?=$rowWatch['lesson_title']?>">
					</div>
					<div class="form-group">
						<label for="">아티스트 검색어 (쉼표 ','로 구분해서 입력)</label>
						<input class="form-control" type="text" name="txtLessonSearchWord" id="txtLessonSearchWord" maxlength="50" placeholder="검색어를 입력해 주세요. 쉼표(,)로 구분. 50자 이내" value="<?=$rowWatch['lesson_searchword']?>">
					</div>

					<div class="form-group">
						<label for="">아티스트 기본지역 (회원님의 주 클래스 지역을 선택해 주세요.)</label>
						<select id="selBaseArea" name="selBaseArea" class="form-control mb-1" size="1">
							<option value="">--선택하세요--</option>

							<?
							$query = "select distinct 지점1 from gf_weather_area where 지점1=지점2 order by 지점코드 ";
							$resultA = db_query($query);

							while($rowA = db_fetch($resultA)){
							?>
							<option <?=(trim($rowWatch["아티스트기본지역"]) == trim($rowA['지점1'])) ? "selected" : "";?> value="<?=$rowA['지점1']?>"><?=$rowA['지점1']?></option>
							<?}?>
						</select>
					</div>

					<div class="form-group">
						<label for="">블로그 인사말</label>
						<textarea name="txtLessonGreetings" id="txtLessonGreetings" class="form-control" maxlength="500" placeholder="인사말을 입력해 주세요" rows="7"><?=$rowWatch['lesson_greetings']?></textarea>
					</div>

					<!-- 정산계좌설정 -->
					<div class="form-group">
					  <label for="">아티스트 계좌정보 <br>(클래스 상품 판매 후 정산 받을 계좌이며, 반드시 본인 명의의 계좌를 등록해 주셔야 합니다.)</label>
					  <input class="form-control" name="txtBankNM" id="txtBankNM" type="text" placeholder="은행명을 입력해 주세요." value="<?=$rowWatch["은행명"]?>">
					  <input class="form-control mt-1" name="txtBankAccount" id="txtBankAccount" type="number" pattern="\d*" placeholder="계좌번호를 입력해 주세요."  value="<?=$rowWatch["계좌번호"]?>">
					  <input class="form-control mt-1" id="txtBankAccountHolder"  name="txtBankAccountHolder" type="text" placeholder="본인명의의 예금주를 입력해 주세요." value="<?=$rowWatch["예금주명"]?>">
					</div>
					<!-- //코치설정 끝 -->

					<!--알림 설정 // 공통-->
					<div class="form-group">
					  <label>클래스 상품 문의/신청 알림설정</label>
						<ul class="list list-border background-white">
							<li class="p-3 d-flex align-items-center justify-content-between">
								<h4 class="fs-005 mb-0">알림 사용</h4>
								<div>
									<span class="small mr-1">끄기</span> <label class="form-switch" for="chkNotice">
										<input type="checkbox" id="chkNotice" name="chkNotice" <?=$strNotice?> value="NOTICE"/><i></i>
									</label><span class="small">사용</span>
								</div>
							</li>
						</ul>
					</div>

					<!--//알림 설정-->
					<div class="mt-4 mb-5">
						<a href="javascript:go_modify_ok();" class="btn-block btn btn-primary mb-3 fs-0">저 장</a>
					</div>

				</form>
			
				</div>
			</div>
		</div>
	</section>

<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
bImg1 = false;
bImg2 = false;
<? if (trim($strImg1) != "") {  // 레슨배경사진이 있다면?>
    bImg1 = true;
<? } ?>
<? if (trim($strImg2) != "") {  // 프로필사진이 있다면?>
    bImg2 = true;
<? } ?>

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

	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="lessonset"]').addClass('active');

    function go_modify_ok() {
		var formData = new FormData($('#frm')[0]);
        

<? 
    if ($cntCoach > 0) {
?>
        			
			
		if (bImg1) {  // 기존 레슨배경사진이 있다면
            if ($('input:checkbox[name=chkDelImg1]').is(":checked")) {  // 기존레슨배경사진 삭제가 체크되어 있다면
                if ($.trim($('#txtBGPic').val()) == "") {
                    alert("레슨(코치) 배경사진을 선택하세요.");
                    $('#txtBGPic').focus();
                    return;
                }
            }
        } else {
            if ($.trim($('#txtBGPic').val()) == "") {
                alert("레슨(코치) 배경사진을 선택하세요.");
                $('#txtBGPic').focus();
                return;
            }
        }

        if (bImg2) {  // 기존 프로필사진이 있다면
            if ($('input:checkbox[name=chkDelImg2]').is(":checked")) {  // 기존프로피사진 삭제가 체크되어 있다면
                if ($.trim($('#txtProPic').val()) == "") {
                    alert("프로필(코치) 사진을 선택하세요.");
                    $('#txtProPic').focus();
                    return;
                }
            }
        } else {
            if ($.trim($('#txtProPic').val()) == "") {
                alert("프로필(코치) 사진을 선택하세요.");
                $('#txtProPic').focus();
                return;
            }
        }

        if ($.trim($('#txtLessonTitle').val()) == "") {
            alert("레슨(코치) 제목을 입력하세요.");
            $('#txtLessonTitle').focus();
            return;
        }


        if ($.trim($('#txtLessonGreetings').val()) == "") {
            alert("레슨(코치) 인사말을 입력하세요.");
            $('#txtLessonGreetings').focus();
            return;
        }

<?
    }
?>
        if (confirm("설정을 저장하시겠습니까?")) {
            $.ajax({
                url: 'class_set_action.php',
                processData: false,
                contentType: false,
                data: formData,
                type: 'POST',
                success: function(result){
                    Data = $.trim(result);
                    if (Data == "SUCCESS") {
                       alert('설정이 저장되었습니다.');
                       location.reload(true);
                    } else if(Data == "FAILED") {
                        alert('설정 저장이 실패했습니다. 관리자에게 문의하세요.');
                    } else {
                        alert(Data);
                    }
                }
            });
        }

    }

</script>
</html>





