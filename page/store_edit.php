<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

	<script>
		var country_code = '82';

      function go_change_area1(obj) {
        var area1 = obj.value;

        $.post("_ajax_area2_list.php", {
          store_area1_id: area1,
			country_code : country_code 
        }, function(data) {
          $("#store_area2_id").html(data);
        });
      }

	function go_change_국가(){
		country_code = $("#국가코드 option:selected").val();

        $.post("_ajax_area1_list.php", {
          country_code: country_code
        }, function(data) {
          $("#store_area1_id").html(data);
        });

        $.post("_ajax_cate_list.php", {
          country_code: country_code
        }, function(data) {
          $("#store_cate_id").html(data);
        });


		
	}

    </script>
<?
$row = db_select("select * from tbl_store where store_id='".$store_id."' and reg_member_id='".$rowMember['member_id']."'");
$rowArea = db_select("select * from tbl_store_area2 where store_area2_id = '".$row['store_area2_id']."'");

if($row[store_id]==""){
    msg_page("잘못된 접근입니다.","/");
}
?>
<body class="mb-5">
<?
$_TITLE = $dic[Franchise_title];
?>


<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
	<div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg9.jpg);">
            <h2>Store</h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_store_navi.php"; ?>

	<!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-3">
        <div class="container">		

            <div class="row">				
				<div class="col-12 col-md-12">
					
					<!-- best class // 정열 가로 3개 3줄 총 9개 // 아티스트 추천 설정 상품 랜덤 노출 -->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#ff0066"></font> 스토어 수정/등록</h2>
							<p>회원님의 스토어를 관리해 주세요. 수정하시면 관리자 확인 후 반영됩니다.</p>
						</div>
					</div>

					<form name="frm" id="frm" action="store_modify_action.php" enctype="multipart/form-data" method="post" target="_fra">
					<input type="hidden" name="store_id" id="store_id" value="<?=$store_id?>"/>
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-12 col-lg-12 col-xl-10 p-3">
							<div class="form-group">
								<label for="">지역/업종</label>
								<div class="d-flex flex-wrap list-even">
									<select class="form-control" onChange="go_change_국가();" name="국가코드" id="국가코드">
										<option value="">Nation</option>
										<option value="82" <?=$row[국가코드]=="82"?"selected":""?>>Republic of Korea (82)</option>
									<!-- <option value="1" <?=$row[국가코드]=="1"?"selected":""?>>Unite of America (1)</option>
									<option value="86" <?=$row[국가코드]=="86"?"selected":""?>>中国 (86)</option>
									<option value="852" <?=$row[국가코드]=="852"?"selected":""?>>Hong Kong (852)</option>
									<option value="81" <?=$row[국가코드]=="81"?"selected":""?>>Japan (81)</option>
									<option value="84" <?=$row[국가코드]=="84"?"selected":""?>>Vietnam (84)</option>
									<option value="886" <?=$row[국가코드]=="886"?"selected":""?>>Thailand (886)</option>
									<option value="63" <?=$row[국가코드]=="63"?"selected":""?>>Philippines (63)</option>
									<option value="7" <?=$row[국가코드]=="7"?"selected":""?>>Kazakhstan (7)</option>
									<option value="62" <?=$row[국가코드]=="62"?"selected":""?>>Indonesia (62)</option>
									<option value="65" <?=$row[국가코드]=="65"?"selected":""?>>Singapore (65)</option> -->
									</select>

									<select class="form-control" onChange="go_change_area1(this);"  name="store_area1_id" id="store_area1_id">
										<option value="">도시</option>
										<?foreach($area1Array as $k => $v) {?>
										<option value="<?=$k?>" <?=$k==$row['store_area1_id']?"selected":""?>><?=$v?></option>
										<?}?>
									</select>

									<select class="form-control" name="store_area2_id" id="store_area2_id">
									  <option value="">상세지역</option>
									  <option value="<?=$row['store_area2_id']?>" selected><?=$rowArea['store_area2_name']?></option>
									</select>

									<select class="form-control" name="store_cate_id" id="store_cate_id">
										<option value="">업종</option>
										<?foreach($storeCateArray as $k => $v) {?>
										<option value="<?=$k?>" <?=$k==$row['store_cate_id']?"selected":""?>><?=$v?></option>
										<?}?>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="">상호/스토어명</label>
								<input class="form-control" type="text" placeholder="" value="<?=$row['store_name']?>" name="store_name" id="store_name">
							</div>

							<div class="form-group">
							  <label for="">대표자명</label>
							  <input class="form-control" type="text" placeholder="대표자 이름입력"  value="<?=$row['ceo_name']?>" name="ceo_name" id="ceo_name">
							</div>

							<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
							<!-- <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
							<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1; width: 20px; height: 20px;" onclick="closeDaumPostcode()" alt="닫기 버튼">
							</div> -->

							<div id="wrap" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
								<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="width: initial;cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
							</div>

							<div class="form-group">
								<label for="">스토어(사업장) 주소</label>
								<button id="btn-zip" class="float-right btn btn-outline-info btn-xs radius-2" type="button" onClick="sample3_execDaumPostcode();">우편번호검색</button>
								<input class="form-control mt-1" type="text" placeholder="우편번호 검색 버튼을 이용해주세요." name="store_addr" id="store_addr" value="<?=$row['store_addr']?>" readonly>
							</div>
							<div class="form-group">
							  <label for="">상세주소</label>
							  <input class="form-control" type="text" placeholder="" name="store_addr_detail" id="store_addr_detail" value="<?=$row['store_addr_detail']?>">
							</div>

							<div id="wrap_zipcode" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
								<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
							</div>

							<div class="form-group">
							  <label for="">전화번호</label>
							  <input class="form-control" type="tel" placeholder="" name="store_tel" id="store_tel" value="<?=$row['store_tel']?>">
							</div>

							<div class="form-group">
								<label for="">결제/구매 적립금 &#40;&#37;&#41; <br>* G-Pay로 결제시 결제 고객에게 지급하는 적립금 (숫자만 입력해 주세요)<br>
								* 지급되는 적립금은 결제대금에서 차감됩니다.</label>
								<input class="form-control input-sm mt-1" type="text" maxLength="3" oninput="maxLengthCheck(this)" placeholder="" name="store_saving_rate" id="store_saving_rate" value="<?=$row['store_saving_rate']?>">
							</div>
							
							<div class="form-group">
								<label for="">스토어 소개</label>
								<textarea class="form-control" rows="8" placeholder="" name="store_desc" id="store_desc"><?=$row['store_desc']?></textarea>
							</div>

							<div class="form-group">
								<label for="">영업시간 안내</label>
								<textarea class="form-control" name="business_hour" id="business_hour" rows="3" placeholder="예) 평일 오전 10시 ~ 오후 6시 "><?=$row['business_hour']?></textarea>
							</div>

							<div class="form-group">
							  <label for="">휴무일 안내</label>
							  <textarea class="form-control" name="offday_info" id="offday_info" rows="3" placeholder="예)토/일 공휴일 휴무"><?=$row['offday_info']?></textarea>
							</div>

							<div class="form-group">
							  <label for="">주차정보</label>
							  <textarea class="form-control" name="parking_info" id="parking_info" rows="3" placeholder="예) 주차가능 / 대중교통을 이용해주세요."><?=$row['parking_info']?></textarea>
							</div>

							<div class="form-group con-store-img">
								<label for="">스토어 이미지 &#40;800x600/1장 10M&#41;</label>
								<div class="list list-three my-2">
									<ul class="row no-style pl-3">
									<?
									$query = "select * from tbl_store_image where store_id='".$row['store_id']."' order by store_image_id ASC";
									$resultStoreImage = db_query($query);

									$idxImage = 0;
									while($rowStoreImage = db_fetch($resultStoreImage)){
										$idxImage++;
									?>
										<li>
											<div class="box">
											  <div class="js-image-preview" style="background-image: url('/_UPLOAD/<?=$rowStoreImage['filename']?>');  background-size: cover; z-index: 2;">
												<input type="file" class="image-upload" accept="image/*" name="file_<?=$rowStoreImage['store_image_id']?>">
											  </div>
											</div>
										</li>
									<?}?>

									<? for ($i=0; $i<6-$idxImage; $i++){?>
										<li class="col-4 p-0">
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="file[]">
											  </div>
											</div>
										</li>
									<?}?>               
									</ul>
								</div>
							</div>

							<!--메뉴추가 -->
							<div class="form-group">
								<label for="">메뉴/상품정보</label>
								<div class="mt-2">
									<ul class="list-menu list-unstyled display-flex">

									<?
									$resultMenu = db_query("select * from tbl_store_menu where store_id='".$row['store_id']."'");

									$numMenu = 0;

									while($rowMenu = db_fetch($resultMenu)){
										$numMenu++;
									?>

										<li class="mr-3 mb-2">
											<div class="box">
											  <div class="js-image-preview" style="background-image: url('/_UPLOAD/<?=$rowMenu['store_menu_image']?>');  background-size: cover; z-index: 2;">
												<input type="file" class="image-upload" accept="image/*" name="file_<?=$rowMenu['store_menu_id']?>">
											  </div>
											</div>
											<div class="box-info">
											  <input class="form-control mb-1" type="text" placeholder="메뉴/상품명" value="<?=$rowMenu['store_menu_name']?>" name="store_menu_name_<?=$rowMenu['store_menu_id']?>" id="store_menu_name">
											  <input class="form-control mb-1" type="number" placeholder="가격" value="<?=$rowMenu['store_menu_price']?>" name="store_menu_price_<?=$rowMenu['store_menu_id']?>" id="store_menu_price">
											  <select class="form-control mb-1" name="화폐단위_<?=$rowMenu['store_menu_id']?>">
                      							<option value="">화폐단위</option>
												<? for ($j=0; $j<sizeof($가맹점화폐단위); $j++){?>
												<option value="<?=$가맹점화폐단위[$j]?>" <?=$rowMenu['화폐단위']==$가맹점화폐단위[$j]?"selected":""?>><?=$가맹점화폐단위[$j]?></option>
												<?}?>
											  </select>
											</div>
										  </li>

										<?}?>
										<? for ($i=0; $i<6-$numMenu; $i++){ ?>
										  <li class="mr-3 mb-2">
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="store_menu_image[]">
											  </div>
											</div>
											<div class="box-info">
											  <input class="form-control mb-1" type="text" placeholder="메뉴/상품명" name="store_menu_name[]" id="store_menu_name">
											  <input class="form-control mb-1" type="number" placeholder="메뉴/상품가격" name="store_menu_price[]" id="store_menu_price">
											  <select class="form-control">
												<option value="화폐단위[]">화폐단위</option>

										<? for ($j=0; $j<sizeof($가맹점화폐단위); $j++){?>

												<option value="<?=$가맹점화폐단위[$j]?>" <?=$rowMenu['화폐단위']==$가맹점화폐단위[$j]?"selected":""?>><?=$가맹점화폐단위[$j]?></option>
										<?}?>
											  </select>
											</div>
										  </li>
										<?}?>
										</ul>
									  </div>
									</div>
									<!--메뉴추가 - 수정페이지에만 있음-->

									<div class="mt-5">
									  <a class="btn btn-block btn btn-secondary btn-lg" href="javascript:frm.submit();$('#a-submit').attr('href','#');" id="a-submit">수정</a>
									</div>
																	 
								</div>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</section>
						

	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_store.php"; ?>
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

    
   //적립율 (숫자 수 제한)
    function maxLengthCheck(object){
    if (object.value.length > object.maxLength){
      object.value = object.value.slice(0, object.maxLength);
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
                //document.getElementById('우편번호').value = data.zonecode;
                document.getElementById("store_addr").value = addr;
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


</html>