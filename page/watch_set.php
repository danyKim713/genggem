<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body>
<?
$query = "SELECT * FROM tbl_watch_category WHERE use_flg='AD005001' ORDER BY seq ";
$resultCategory = db_query($query); 

// 회원 영상/레슨 설정 정보 가져오기
$query = "select * from tbl_watch_setup where member_id='".$ck_login_member_pk."'";
//echo $query;
$rowWatch = db_select($query); 

$arrCat = explode(",", $rowWatch['cat_id']);

$strNotice = ""; 
if ($rowWatch["notification_flg"] == "AD005001" || $rowWatch["notification_flg"] == "") $strNotice = "checked"; 


// 코치인지 조회
$cntCoach = db_count("tbl_coach", "member_id='".$ck_login_member_pk."' AND use_flg='AD005001'", "co_id"); 


?>
<header class="header top_fixed">
	<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
	<h2 class="header-title text-center">영상 설정</h2>
</header>

<section class="wrap-join py-0">
	<div class="container-fluid header-top-sub">
		<div class="row align-items-center justify-content-center">
			<div class="col-sm-10 col-lg-10 col-xl-6 p-0">
			<div class="p-3 bg-gradient-primary color-white">
				<h2 class="font-2 fs-005 fw-500 mb-1 color-11"><?=$rowMember['name']?> (UID <?=$rowMember['UID']?>)<span class="bar opacity-75"></span><?=$rowMember['email']?></h2>
				<h2 class="font-2 fs-005 fw-500 mb-1 color-11">회원가입일<span class="bar opacity-75"></span><?=date("Y-m-d",strtotime($rowMember['regdate']))?></h2>
			</div>
			<form name="frm" id="frm" method="post" class="p-3" enctype="multipart/form-data">
			<div class="form-group">
				<label for="">나의 크리에이터 영상 주소</label>
				<p onclick="copyToAddress('#copyAddress')" class="address fs--1">
					<span id="copyAddress" class="text-address">http://<?=$_SERVER['HTTP_HOST']?>/page/watch.php?txtRecordNo=<?=$rowMember[UID]?></span>
					<span class="text-copy">복사</span>
				</p>
			</div>

			<!-- 관심카테고리 설정 -->
			<div class="form-group">
				<label for="">영상 관심 카테고리를 선택해 주세요</label>
				<span class="fs--1 float-right fw-400 color-primary mt-1"><i class="fas fa-check-square opacity-50"></i> 중복설정가능</span>
				<div class="list-category background-white">
				<ul class="row text-center">
<? 

    $i = 1;
    while ($row = mysqli_fetch_array($resultCategory)) {
        $strImg = "";
        $strChk = "";
        // 이미지 
        if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchCatImg/".$row['cat_img'])) { 
            $strImg = "<img src=\"/ImgData/WatchCatImg/{$row["cat_img"]}\" width=\"60\"  alt=\"{$row["cat_nm"]}\">";
        }
    
        if (trim(array_search($row["cat_id"], $arrCat)) != "") {
            $strChk = "checked";
        }

?>
					<li class='col-3 radiobox'>
						<input id="type<?=$i?>" type="checkbox" name="chkCat[]" class="chkCat invisible" <?=$strChk?> value="<?=$row["cat_id"]?>" />
						<label for="type<?=$i?>">											
							<?=$strImg?>
							<span class="d-block py-1"><?=$row["cat_nm"]?></span>
						</label>
					</li>
<? 
        $i++;
    } 
?>

				</ul>
				</div>
			</div>

			<!-- 영상설정 // 누구나 -->
			<div class="form-group">
				<label for="">내 영상(크리에이터) 제목</label>
				<input class="form-control" type="text" name="txtMovieTitle" id="txtMovieTitle" placeholder="" value="<?=$rowWatch['creator_title']?>">
			</div>

			<div class="form-group">
				<label for="">내 영상(크리에이터) 공개여부</label>
				<select class="form-control mb-1" size="1" id="selOpen" name="selOpen">
					<option value=""><?=$dic['Select']?></option>
<?
    $query  = " SELECT *   \n";
    $query .= " FROM   sysT_CommonCode   \n";
    $query .= " WHERE  major_cd = 'MOPNF'   \n";
    $query .= " AND    minor_cd <> '$'   \n";
    $query .= " AND    use_flg='AD005001'   \n";
    $query .= " ORDER BY seq   \n";
    $resultOpen = db_query($query); 
    while ($rowOpen = mysqli_fetch_array($resultOpen)) { 
?>
					<option <?=($rowOpen['major_cd'].$rowOpen['minor_cd'] == $rowWatch['creator_open_flg'])?"selected":""?> value="<?=$rowOpen['major_cd'].$rowOpen['minor_cd']?>"><?=$rowOpen['cd_nm']?></option>
<?
    }
?>
				</select>
			</div>
			<div class="form-group">
				<label for="">내 영상(크리에이터) 설명</label>
				<textarea name="txtMovieBigo" id="txtMovieBigo" class="form-control" placeholder="어떤 크리에이터(영상)인지 설명해 주세요" rows="3"><?=$rowWatch['creator_explanation']?></textarea>
			</div>
			<!-- //영상설정 -->

			<!--알림 설정-->
			<div class="form-group">
			  <label>영상 알림설정</label>
				<ul class="list list-border background-white">
					<li class="p-3 d-flex align-items-center justify-content-between">
						<h4 class="fs-005 mb-0">영상 알림 사용</h4>
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
			<? include "./inc_Bottom_vod.php"; ?>
			</div>
		</div>
	</div>
</section>
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

	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="watchset"]').addClass('active');

    function go_modify_ok() {
		var formData = new FormData($('#frm')[0]);

        if ($("input:checkbox[name='chkCat[]']:checked").length < 1) {
            alert("영상관심 카테고리를 선택해주세요."); 
            return;
        }

        if ($.trim($('#txtMovieTitle').val()) == "") {
            alert("내영상(크리에이터) 제목을 입력하세요.");
            $('#txtMovieTitle').focus();
            return;
        }

        if ($('#selOpen').val() == "") {
            alert("내영상(크리에이터) 공개여부를 선택하세요.");
            $('#selOpen').focus();
            return;
        }

        if ($.trim($('#txtMovieBigo').val()) == "") {
            alert("내영상(크리에이터) 설명을 입력하세요.");
            $('#txtMovieBigo').focus();
            return;
        }


        if (confirm("설정을 저장하시겠습니까?")) {
            $.ajax({
                url: 'watch_set_action.php',
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





