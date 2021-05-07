<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body class="mb-6">
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
            <h2>cafehands open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					<!-- 코치회원에게만 노출 tab-->
					<div id="tab-menu" class="clearfix ">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0 active"><a href="class_set.php" title="기본설정">기본설정</a></li>
							<li class="col p-0"><a href="class_product.php" title="레슨상품관리">레슨상품관리</a></li>
							<li class="col p-0"><a href="class_applylist.php" title="레슨관리">레슨신청관리</a></li>
							<li class="col p-0"><a href="class_applylist.php" title="레슨신청관리">정산관리</a></li>
						</ul>
					</div>
					<!--//tab 끝-->	

					<form name="frm" id="frm" method="post" class="p-3" enctype="multipart/form-data">

					 <!-- 코치회원인 경우에만 노출 -->
					 <div class="form-group mt-5">
						<label for="">나의 코치/레슨 주소</label>
						<p onclick="copyToAddress('#copyAddress')" class="address fs--1">
							<span id="copyAddress" class="text-address">http://<?=$_SERVER['HTTP_HOST']?>/class/<?=$rowMember[UID]?></span>
							<span class="text-copy">복사</span>
						</p>
					 </div>
					 <div class="form-group row mx-0">
						<div class="box col-8 p-0">
						 <label for="">레슨(코치) 배경사진</label>
							<div class="js-image-preview" style="background-image: url('/ImgData/WatchImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowWatch["background_photo"])?>');">
								<input type="file" id="txtBGPic" name="txtBGPic" class="image-upload" accept="image/*">
							</div>
						</div>
						<div class="box col-4 p-0">
							<label for="">프로필(코치) 사진</label>
							<div class="js-image-preview" style="background-image: url('/ImgData/WatchImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowWatch["profile_photo"])?>');">
								<input type="file" id="txtProPic" name="txtProPic" class="image-upload" accept="image/*">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="">레슨(코치) 제목</label>
						<input class="form-control" type="text" name="txtLessonTitle" id="txtLessonTitle" placeholder="" value="<?=$rowWatch['lesson_title']?>">
					</div>
					<div class="form-group">
						<label for="">레슨(코치) 검색어</label>
						<input class="form-control" type="text" name="txtLessonSearchWord" id="txtLessonSearchWord" maxlength="50" placeholder="검색어를 입력해 주세요. 쉼표(,)로 구분. 50자 이내" value="<?=$rowWatch['lesson_searchword']?>">
					</div>
					<div class="form-group">
						<label for="">레슨(코치) 인사말</label>
						<textarea name="txtLessonGreetings" id="txtLessonGreetings" class="form-control" maxlength="500" placeholder="인사말을 입력해 주세요" rows="3"><?=$rowWatch['lesson_greetings']?></textarea>
					</div>

					<!-- 정산계좌설정 -->
					<div class="form-group">
					  <label for="">고객계좌정보 <br>(반드시 본인 명의의 계좌를 등록해 주셔야 합니다.)</label>
					  <input class="form-control" name="bank_nm" id="bank_nm" type="text" placeholder="은행명을 입력해 주세요." value="<?=$rowMember['bank_nm']?>">
					  <input class="form-control mt-1" name="bank_account" id="bank_account" type="number" pattern="\d*" placeholder="계좌번호를 입력해 주세요."  value="<?=$rowMember['bank_account']?>">
					  <input class="form-control mt-1" id="bank_yegeumju"  name="bank_yegeumju" type="text" placeholder="본인명의의 예금주를 입력해 주세요." value="<?=$rowMember['bank_yegeumju']?>">
					</div>
					<!-- //코치설정 끝 -->

					<!--알림 설정 // 공통-->
					<div class="form-group">
					  <label>레슨 문의/신청 알림설정</label>
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
					<div class="mt-4">
						<a href="javascript:go_modify_ok();" class="btn-block btn btn-primary mb-3 fs-0">저장</a>
					</div>

				</form>
			<? include "./inc_Bottom_lesson.php"; ?>
			</div>
		</div>
	</div>
</section>
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





