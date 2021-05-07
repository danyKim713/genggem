<?
include "./inc_program.php";

// 코치인지 조회
$query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
$resultCoach = db_query($query);
$cntCoach = mysqli_num_rows($resultCoach); 

if ($cntCoach <= 0) {  // 코치이면  
    msg_page("비정상적인 접근입니다.");
    exit;
}


// 쿠폰 수량 체크
$query  = " SELECT COUNT(l_id) AS cnt   \n";
$query .= " FROM   tbl_lesson  \n";
$query .= " WHERE  member_id = '{$rowMember["member_id"]}'   \n";
$query .= " AND    쿠폰 IS NOT NULL   \n";    //  쿠폰 있는 것만
$rowCouponLesson = db_select($query);   


?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">



<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- Breadcrumb Area End -->

	<? include "./inc_artist.php"; ?>

	
	<div class="cart-area clearfix">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-lg-10 mt-2">                 
					<div class="cart-totals-area mt-5">
                        <h5 class="title-- mt-4">레슨 등록</h5>

                        <form name="frm" id="frm" method="post" class="p-2">                
						<input type="hidden" name="app_id" id="app_id" />
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스 제목" class="color-3 fw-400 mb-2">클래스 제목</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="text" name="txtLessonTitle" id="txtLessonTitle" class="form-control" maxlength="30" placeholder="클래스 상품명을 입력하세요." value="">
							</div>
						</div>
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스 검색어" class="color-3 fw-400 mb-2">클래스 검색어</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="text" name="txtTag" id="txtTag" class="form-control" maxlength="20" placeholder="검색어 입력. 쉼표(,)로 구분. 20자 이내" value="">
							</div>
						</div>
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스 가격" class="color-3 fw-400 mb-2">클래스 가격</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="number" name="txtPrice" id="txtPrice" class="form-control" maxlength="10" placeholder="클래스 가격을 숫자로만 입력해 주세요." value="">
							</div>
						</div>
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="쿠폰적용" class="color-3 fw-400 mb-4">쿠폰적용</label></h5>
							<div class="shipping-address" style="width:70%;">
								<select id="selcoupon" name="selcoupon" class="form-control mb-1" size="1">
									<option value="">--쿠폰적용안함--</option>

									<?
										$query_coupon  = " SELECT *   \n";
										$query_coupon .= " FROM   tbl_coupon  \n";
										$query_coupon .= " WHERE  사용여부 = 'AD005001'  \n";
										$query_coupon .= " ORDER BY c_id ASC \n";

										$resultCoupon = db_query($query_coupon);

										for ($i=0; $i<db_num_rows($resultCoupon); $i++){
											$rowCoupon = db_fetch($resultCoupon);
									?>
									<option value="<?=$rowCoupon["c_id"]?>"><?=$rowCoupon["쿠폰명"]?>[<?=number_format($rowCoupon["할인금액"])?>원] 적용</option>
									<?
										}
									?>
								</select>
								<p class="color-5 fw-200 mb-2 fs--1">
								<? if ($rowCouponLesson["cnt"] >= 2) { ?><span style="color:red">- 현재 쿠폰등록 상품 가능한 수량(최대 2개)이 초과 되었습니다.</span><?}?> <br>
								- 쿠폰적용은 등록한 클래스 상품 중 최대 2개 까지만 적용가능합니다.<br>
								- 쿠폰적용시 할인된 금액은 클래스 판매금액 정산시 차감하여 정산됩니다.
								</p>
							</div>
						</div>
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="구매 적립금" class="color-3 fw-400 mb-2">구매 적립금</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="number" name="txtReward" id="txtReward" class="form-control" maxlength="7" placeholder="적립금을 숫자로만 입력해 주세요. 예) 200" value="">
								<p class="color-5 fw-200 mb-2 fs--1">- 구매고객에게 적립되는 구매적립금 설정입니다.<br>
								- 적립금 미 지급을 원할 경우 '0'을 입력해 주세요.</p>
							</div>
						</div>
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스 카테고리" class="color-3 fw-400 mb-4">클래스 대분류</label></h5>
							<div class="shipping-address" style="width:70%;">
								<select id="selCat" name="selCat" class="form-control mb-1" size="1" onChange="javascript:getCatM()">
									<option value="">--선택하세요--</option>
									<? 
										$query = "SELECT * FROM tbl_lesson_category WHERE depth= 1 AND use_flg='AD005001' ORDER BY seq ";
										$resultCategory = db_query($query); 

										while ($row = mysqli_fetch_array($resultCategory)) {
														echo "<option value=\"{$row["cat_id"]}\">{$row["cat_nm"]}</option>";
										} 
									?>
								</select>
							</div>
						</div>
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스 카테고리" class="color-3 fw-400 mb-4">클래스 중분류</label></h5>
							<div class="shipping-address" style="width:70%;">
								<select id="selCatM" name="selCatM" class="form-control mb-1" size="1">
									<option value="">--선택하세요--</option>
								</select>
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스 기본지역 설정" class="color-3 fw-400 mb-4">지역 분류 설정</label></h5>
							<div class="shipping-address" style="width:70%;">
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
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="우편번호" class="color-3 fw-400 mb-2">클래스 강의주소</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="button" name="우편번호검색" id="우편번호검색" class="form-control" value="우편번호 검색" onClick="sample3_execDaumPostcode();">
								<input type="text" name="우편번호" id="우편번호" class="form-control" maxlength="10" placeholder="(우편번호) 검색을 이용해 주세요." value="" readonly>
								<input type="text" name="클래스주소" id="클래스주소" class="form-control" maxlength="60" placeholder="기본 주소" value="" readonly>
								<input type="text" name="클래스상세주소" id="클래스상세주소" class="form-control" maxlength="20" placeholder="상세주소를 입력해 주세요. 예) 2층 201호" value="" >
							</div>
						</div>

						<div id="wrap_zipcode" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
							<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
						</div>
						
						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스시작일" class="color-3 fw-400 mb-2">클래스 시작일</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="text" name="클래스시작일" id="클래스시작일" class="form-control" maxlength="15" placeholder="예) 6월 13일 또는 즉시가능 등" value="">
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="클래스난이도" class="color-3 fw-400 mb-4">클래스 난이도</label></h5>
							<div class="shipping-address" style="width:70%;">
							<select id="클래스난이도" name="클래스난이도" class="form-control mb-1" size="1">
									<option value="">--선택하세요--</option>
									<option value="쉬움">쉬움</option>
									<option value="보통">보통</option>
									<option value="조금높음">조금높음</option>
									<option value="높음">높음</option>
								</select>
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="소요시간" class="color-3 fw-400 mb-2">소요시간</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="text" name="소요시간" id="소요시간" class="form-control" maxlength="10" placeholder="예) 2시간(회)" value="">
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:30%;"><label for="수업인원" class="color-3 fw-400 mb-2">수업인원</label></h5>
							<div class="shipping-address" style="width:70%;">
								<input type="text" name="수업인원" id="수업인원" class="form-control" maxlength="15" placeholder="예) 최대3명 or 1:1" value="">
							</div>
						</div>

						<div class="shipping d-flex justify-content-between">
							<h5 style="width:100%;"><label for="클래스 상품설명" class="color-3 fw-400 mb-2">클래스 상품설명</label>
							<?=makeCKeditor("txtLessonGreetings", "txtLessonGreetings", $rowLesson['l_intro'], "100%", "250px")?>
							<?//makeCKeditor("txtLessonGreetings","txtLessonGreetings","","100%","300px");?>
							<!--
							<textarea name="txtLessonGreetings" id="txtLessonGreetings" class="form-control" placeholder="클래스 상품소개, 설명을 적어주세요." rows="15"></textarea>--></h5>
						</div>

						<div class="form-group row mx-0 mt-3">
							<div class="box col-2 p-0">
							 <label for="">* 사진1 (필수)</label>
								<div class="js-image-preview" style="background-image: url('/ImgData/LessonImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowLesson["Lesson_photo1"])?>'); height:140px;">
									<input type="file" id="Lessonp1" name="Lessonp1" class="image-upload" accept="image/*">
								</div>
							</div>
							<div class="box col-2 p-0">
								<label for="">사진2</label>
								<div class="js-image-preview" style="background-image: url('/ImgData/LessonImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowLesson["Lesson_photo2"])?>'); height:140px;">
									<input type="file" id="Lessonp2" name="Lessonp2" class="image-upload" accept="image/*">
								</div>
							</div>
							<div class="box col-2 p-0">
								<label for="">사진3</label>
								<div class="js-image-preview" style="background-image: url('/ImgData/LessonImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowLesson["Lesson_photo3"])?>'); height:140px;">
									<input type="file" id="Lessonp3" name="Lessonp3" class="image-upload" accept="image/*">
								</div>
							</div>
							<div class="box col-2 p-0">
								<label for="">사진4</label>
								<div class="js-image-preview" style="background-image: url('/ImgData/LessonImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowLesson["Lesson_photo4"])?>'); height:140px;">
									<input type="file" id="Lessonp4" name="Lessonp4" class="image-upload" accept="image/*">
								</div>
							</div>
							<div class="box col-2 p-0">
								<label for="">사진5</label>
								<div class="js-image-preview" style="background-image: url('/ImgData/LessonImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowLesson["Lesson_photo5"])?>'); height:140px;">
									<input type="file" id="Lessonp5" name="Lessonp5" class="image-upload" accept="image/*">
								</div>
							</div>
							<div class="box col-2 p-0">
								<label for="">사진6</label>
								<div class="js-image-preview" style="background-image: url('/ImgData/LessonImg/<?=$rowMember["UID"]?>/<?=rawurlencode($rowLesson["Lesson_photo6"])?>'); height:140px;">
									<input type="file" id="Lessonp6" name="Lessonp6" class="image-upload" accept="image/*">
								</div>
							</div>
						</div>
						<h5><label for="클래스난이도" class="color-3 fw-400 mb-4">(권장 사이즈 1,000 * 730)</label></h5>

						<div class="form-group mt-3">
						  <label>클래스 상품판매</label>
							<ul class="list list-border background-white">
								<li class="p-3 d-flex align-items-center justify-content-between">
									<h4 class="fs-005 mb-0">판매여부</h4>
									<div>
										<span class="small mr-1">판매중지</span> <label class="form-switch" for="chkSale">
											<input type="checkbox" id="chkSale" name="chkSale" value="GS730YSA" checked /><i></i>
										</label><span class="small">판매</span>
									</div>
								</li>
							</ul>
						</div>
						<div class="form-group">
						  <label>대표 클래스 설정 (대표클래스는 최대 2개까지 설정가능합니다.)</label>
							<ul class="list list-border background-white">
								<li class="p-3 d-flex align-items-center justify-content-between">
									<h4 class="fs-005 mb-0">설정여부</h4>
									<div>
										<span class="small mr-1">설정안함</span> <label class="form-switch" for="chkShow">
											<input type="checkbox" id="chkShow" name="chkShow" value="AD001001"  /><i></i>
										</label><span class="small">설정</span>
									</div>
								</li>
							</ul>
						</div>

						<!-- //클래스설정 끝 -->

						<div class="mt-4">
							<a href="javascript:go_reg_ok();" class="btn alazea-btn w-100 mb-5">저장</a>
						</div>
						</form>
						
                    </div>			
                </div>
            </div>
        </div>
    </div>

		

<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_class.php"; ?>

</body>
<script src="/common/script/regexp.js"></script>
<script>
    function getCatM() {
        $.ajax({
            url: './get_category_m.php',
            type: 'post',
            data: {
                txtRecordNo: $("#selCat").val()
            },
            datatype: 'text',
            success: function(Data) {
                Data = $.trim(Data);
                arrData = Data.split("@");
                cnt = arrData.length;
                $('#selCatM').empty();
                $('#selCatM').append("<option value=''>--선택하세요--</option>")
                for (i=0; i<cnt ;i++) {
                    arrVal = arrData[i].split(":");
                    strVal = arrVal[0];
                    strNM = arrVal[1]; 
                    if (strVal != "" && strNM != "") {
                        $('#selCatM').append("<option value='"+strVal+"'>"+strNM+"</option>");
                    }
                }
                
            } 
        });
    }

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


 $('.nav_category li[data-name="gnb-lesson"]').addClass('active');



    function go_reg_ok() {


		// This before:
		for ( instance in CKEDITOR.instances )
			CKEDITOR.instances[instance].updateElement();


		var form = $('#frm')[0];
		var formData = new FormData(form);
		formData.append("사진1", $("#Lessonp1")[0].files[0]);
		formData.append("사진2", $("#Lessonp2")[0].files[0]);
		formData.append("사진3", $("#Lessonp3")[0].files[0]);
		formData.append("사진4", $("#Lessonp4")[0].files[0]);
		formData.append("사진5", $("#Lessonp5")[0].files[0]);
		formData.append("사진6", $("#Lessonp6")[0].files[0]);

		if($("#Lessonp1").val()==""){
			alert('사진1은 필수 입니다.');
			$("#Lessonp1").focus();
			return;
		}

        if ($.trim($('#txtLessonTitle').val()) == "") {
            alert("클래스 상품명을 입력하세요.");
            $('#txtLessonTitle').focus();
            return;
        }

        if ($.trim($('#txtTag').val()) == "") {
            alert("클래스 검색어을 입력하세요.");
            $('#txtTag').focus();
            return;
        }

        if ($.trim($('#txtPrice').val()) == "") {
            alert("클래스 상품가격을 입력하세요.");
            $('#txtPrice').focus();
            return;
        }


        if ($.trim($('#txtPrice').val()) && pattern_N.test($('#txtPrice').val())) {
          alert("클래스 상품가격은 숫자만 입력하세요.");
          $("#txtPrice").focus();
          return;
        }


        if ($('#selCat').val() == "") {
            alert("클래스 카테고리를 선택하세요.");
            $('#selCat').focus();
            return;
        }



        if (CKEDITOR.instances.txtLessonGreetings.getData().length == 0) {
            alert("클래스 상품소개를 입력하세요.");
            $('#txtLessonGreetings').focus();
            return;
        }

        if (confirm("클래스를 저장하시겠습니까?")) {
            $.ajax({
                url: 'class_product_upload_action.php',
                processData: false,
                contentType: false,
                data: formData,
                type: 'POST',
                success: function(result){
                    Data = $.trim(result);

                    if (Data == "SUCCESS") {
                       alert('클래스가 등록되었습니다.');
                       top.location.href = "class_product.php";
                    } else if(Data == "FAILED") {
                        alert('클래스 등록이 실패했습니다. 관리자에게 문의하세요.');
                    } else {
                        alert(Data);
                    }
                }
            });
        }

    }
</script>


<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

<script>
    // 우편번호 찾기 찾기 화면을 넣을 element
    var element_wrap_zipcode = document.getElementById('wrap_zipcode');

    function foldDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_wrap_zipcode.style.display = 'none';
    }

    function sample3_execDaumPostcode() {
        // 현재 scroll 위치를 저장해놓는다.
        var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var addr = ''; // 주소 변수
                var extraAddr = ''; // 참고항목 변수

                //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                    addr = data.roadAddress;
                } else { // 사용자가 지번 주소를 선택했을 경우(J)
                    addr = data.jibunAddress;
                }

                // 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
                if(data.userSelectedType === 'R'){
                    // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                    // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                    if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있고, 공동주택일 경우 추가한다.
                    if(data.buildingName !== '' && data.apartment === 'Y'){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                    if(extraAddr !== ''){
                        extraAddr = ' (' + extraAddr + ')';
                    }
                    // 조합된 참고항목을 해당 필드에 넣는다.
                    //document.getElementById("sample3_extraAddress").value = extraAddr;
                
                } else {
                    //document.getElementById("sample3_extraAddress").value = '';
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('우편번호').value = data.zonecode;
                document.getElementById("클래스주소").value = addr;
                // 커서를 상세주소 필드로 이동한다.
                //document.getElementById("txtArea").focus();

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_wrap_zipcode.style.display = 'none';

                // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
                document.body.scrollTop = currentScroll;
            },
            // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
            onresize : function(size) {
                element_wrap_zipcode.style.height = size.height+'px';
            },
            width : '100%',
            height : '100%'
        }).embed(element_wrap_zipcode);

        // iframe을 넣은 element를 보이게 한다.
        element_wrap_zipcode.style.display = 'block';
    }
</script>

<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="lessonset"]').addClass('active');
</script>
</html>





