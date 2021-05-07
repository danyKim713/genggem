<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

if ($strRecordNo == "") {
    msg_page("잘못된 접근입니다. 관리자에게 문의하세요.", "");
    exit;
}

// 수정할 영상정보 가져오기
$query  = " SELECT wv_id, member_id, member_uid, cat_id, v_title, v_tag, v_link, v_thumbnail,  \n";
$query .= "        v_open_flg, approval_flg, exposure_flg, v_explanation, view_cnt, isrt_dt   \n";
$query .= " FROM   tbl_watch_video    \n";
$query .= " WHERE  wv_id='{$strRecordNo}'   \n";  
$rowWatch = db_select($query); 

if ($rowWatch["member_id"] != $rowMember["member_id"]) {
    msg_page("잘못된 접근입니다. 관리자에게 문의하세요.", "");
    exit;
}


$strThumbImg = "";
if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchVideo/{$rowMember["UID"]}/".$rowWatch['v_thumbnail'])) { 
    $strThumbImg = "/ImgData/WatchVideo/{$rowMember["UID"]}/{$rowWatch["v_thumbnail"]}";
}
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
</script>
	<? include "./inc_Head.php"; ?>
<body>
<header class="header top_fixed">
    <a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
    <h2 class="header-title text-center">영상등록</h2>
</header>
<section class="wrap-channelmade py-0">
    <div class="container-fluid header-top-sub">
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-10 col-lg-10 col-xl-6 p-2">
			<form name="frm" id="frm" method="post" class="p-3" enctype="multipart/form-data">
            <input type="hidden" name="txtRecordNo" id="txtRecordNo" value="<?=$strRecordNo?>">

                <div class="form-group">
                    <label for="">- 영상을 등록하려면 '<a href="watch_set.php"><font size="" color="#ff0033"><strong>설정</strong></font></a>'에서 크리에이터 정보를 입력해 주셔야 합니다.<br>
					- 영상을 등록하면 관리자 확인 후 사이트에 반영됩니다.<br>
					- 사이트 주제와 맞지 않거나 미풍양속에 저해될 경우 승인이 되지 않습니다.</label>
                </div>
				
				<div class="form-group">
                    <label for="">영상 주제를 선택해 주세요</label>
                    <div class="list-category background-white">
                        <ul class="row text-center">
<? 
    $query = "SELECT * FROM tbl_watch_category WHERE use_flg='AD005001' ORDER BY seq ";
    $resultCategory = db_query($query); 

    $i = 1;
    while ($row = mysqli_fetch_array($resultCategory)) {
        $strCatFlg = "";
        if ($row['cat_id'] == $rowWatch["cat_id"]) {
            $strCatFlg = " checked ";
        }

        $strImg = "";

        // 이미지 
        if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchCatImg/".$row['cat_img'])) { 
            $strImg = "<img src=\"/ImgData/WatchCatImg/{$row["cat_img"]}\" width=\"60\"  alt=\"{$row["cat_nm"]}\">";
        }

?>

                            <li class='col-3 radiobox'>
                                <input id="type<?=$i?>" type="radio" name="rdoCat" class="rdoCat invisible" <?=$strCatFlg?> value="<?=$row["cat_id"]?>" />
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
                <div class="form-group">
                    <label for="">영상제목</label>
                    <input  type="text" class="form-control" id="txtTitle" name="txtTitle" placeholder="영상제목을 입력해 주세요." value="<?=$rowWatch["v_title"]?>" />
                </div>
                <div class="form-group">
                    <label for="">영상태그 (쉼표로 구분해서 입력)</label>
                    <input type="text" class="form-control" id="txtTag" name="txtTag" placeholder="예)부킹,여행,프로교육" value="<?=$rowWatch["v_tag"]?>" />
                </div>
                <div class="form-group">
                    <label for="">영상링크주소 (유투브 영상만 링크 가능)</label>
                    <input type="text" class="form-control" id="txtLink" name="txtLink" placeholder="예)https://youtu.be/Flnv5JN3Jng" value="<?=$rowWatch["v_link"]?>"/>
                </div>
                <!-- <div class="form-group box">
                    <label for="">썸네일이미지</label>
                    <span class="fs--1 float-right fw-400 mt-1 color-6">미리보기 이미지를 업로드 해주세요</span>
                    <div class="js-image-preview" style="background-image:url('<?=$strThumbImg?>')">
                        <input type="file" id="txtImg" name="txtImg" class="image-upload" accept="image/*">
                    </div>
                </div> -->
                <div class="form-group">
                    <label for="">공개여부</label>
                    <select class="form-control mb-1" size="1" id="selOpen" name="selOpen">
<?
    $query  = " SELECT *   \n";
    $query .= " FROM   sysT_CommonCode   \n";
    $query .= " WHERE  major_cd = 'VOPNF'   \n";
    $query .= " AND    minor_cd <> '$'   \n";
    $query .= " AND    use_flg='AD005001'   \n";
    $query .= " ORDER BY seq   \n";
    $resultOpen = db_query($query); 
    while ($rowOpen = mysqli_fetch_array($resultOpen)) { 
        $strOpenFlg = "";
        if ($rowOpen['major_cd'].$rowOpen['minor_cd'] == $rowWatch["v_open_flg"]) {
            $strOpenFlg = " selected ";
        }
?>
                        <option <?=$strOpenFlg?> value="<?=$rowOpen['major_cd'].$rowOpen['minor_cd']?>"><?=$rowOpen['cd_nm']?></option>
<?
    }
?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="">영상 설명</label>
                    <textarea class="form-control" name="txtExplanation" id="txtExplanation" placeholder="어떤 영상인지 설명해 주세요" rows="5"><?=$rowWatch["v_explanation"]?></textarea>
                </div>

                <div class="mt-4 mb-50">
                    <a href="javascript:go_reg_ok()" class="btn-block btn btn-primary mb-3 fs-0"><?=$dic['Next']?></a>
                </div>
            </div>
			</form>
            <? include "./inc_Bottom_vod.php"; ?>
        </div>
    </div>
</section>

<script>
	$('.nav_bottom li[data-name="watchupload"]').addClass('active');
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


    function go_reg_ok() {
		var formData = new FormData($('#frm')[0]);

        if (!$('input:radio[name=rdoCat]').is(':checked')) {
            alert("영상 카테고리를 선택해주세요."); 
            return;
        }

        if ($.trim($('#txtTitle').val()) == "") {
            alert("영상제목을 입력하세요.");
            $('#txtTitle').focus();
            return;
        }

        if ($.trim($('#txtTag').val()) == "") {
            alert("영상태그을 입력하세요.");
            $('#txtTag').focus();
            return;
        }

        if ($.trim($('#txtLink').val()) == "") {
            alert("영상링크을 입력하세요.");
            $('#txtLink').focus();
            return;
        }

/*
        if ($.trim($('#txtImg').val()) == "") {
            alert("썸네일이미지를 선택하세요.");
            $('#txtImg').focus();
            return;
        }
*/
        if ($('#selOpen').val() == "") {
            alert("공개여부를 선택하세요.");
            $('#selOpen').focus();
            return;
        }

        if ($.trim($('#txtExplanation').val()) == "") {
            alert("영상설명을 입력하세요.");
            $('#txtExplanation').focus();
            return;
        }

        if (confirm("영상을 저장하시겠습니까?")) {
            $.ajax({
                url: 'watch_upload_modify_action.php',
                processData: false,
                contentType: false,
                data: formData,
                type: 'POST',
                success: function(result){
                    Data = $.trim(result);


                    if (Data == "SUCCESS") {
                       alert('영상이 수정되었습니다.');
                       top.location.href = "watch_confirm.php";
                    } else if(Data == "FAILED") {
                        alert('영상 등록이 실패했습니다. 관리자에게 문의하세요.');
                    } else {
                        alert(Data);
                    }
                }
            });
        }

    }

</script>
</body>


</html>
