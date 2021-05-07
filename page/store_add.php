<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
  <? include "./inc_Head.php"; ?>
    <link rel="stylesheet" href="assets/css/sub.css">

    <script>
		var country_code;

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

		if(country_code != "82"){
			$("#btn-zip").hide();
		}else{
			$("#btn-zip").show();
		}


		
	}

    </script>


<?
$_TITLE = 'My Store';
$_BACK_LINK = "";
$sub = true
?>
<?
	$pageName  = "Register Franchise"; 
?>

<body class="mb-5">

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
							<h2><font color="#ff0066"></font> 스토어 등록</h2>
							<p>회원님의 스토어/상점을 등록해 주세요. 관리자 확인 후 반영됩니다.<br>
							*표는 필수 입력 사항입니다.</p>
						</div>
					</div>

					<form name="frm_write" id="frm_write" method="post" enctype="multipart/form-data" action="store_add_action.php">
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-12 col-lg-12 col-xl-10 p-3">
							<div class="form-group">
								<label for="">* 지역/업종</label>
									<div class="d-flex flex-wrap list-even">
										<select class="form-control mb-1" onChange="go_change_국가();" name="국가코드" id="국가코드">
											<option value="">Nation</option>
											<option value="82">대한민국 (82)</option>
										</select>
										<select class="form-control" onChange="go_change_area1(this);" name="store_area1_id" id="store_area1_id">
											<option value="">지역/도시</option>
										</select>
										<select class="form-control" name="store_area2_id" id="store_area2_id">
											<option value="">세부지역</option>
										</select>
										<select class="form-control" name="store_cate_id" id="store_cate_id">
											<option value="">업종선택</option>
										</select>
									</div>
							</div>

							<div class="form-group">
								<label for="">* 상호/스토어명</label>
								<input class="form-control" type="text" placeholder="상호/스토어 이름을 입력해 주세요" name="store_name" id="store_name">
							</div>

							<!-- iOS에서는 position:fixed 버그가 있음, 적용하는 사이트에 맞게 position:absolute 등을 이용하여 top,left값 조정 필요 -->
							<!-- <div id="layer" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;"><img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1; width: 20px; height: 20px;" onclick="closeDaumPostcode()" alt="닫기 버튼"></div> -->

							<div id="wrap-zipcode" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
								<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="width: initial;cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
							</div>

							<div class="form-group">
								<label for="">* 스토어(사업장) 주소</label>
								<button id="btn-zip" class="float-right btn btn-outline-info btn-xs radius-2" type="button" onClick="sample3_execDaumPostcode();">우편번호검색</button>
								<input type="text" name="store_addr" id="store_addr" class="form-control mt-1" maxlength="80" placeholder="기본 주소" value="" readonly>
							</div>

							<div class="form-group">
								<label for="">* 상세주소</label>
								<input type="text" name="store_addr_detail" id="store_addr_detail" class="form-control" maxlength="20" placeholder="상세주소를 입력해 주세요. 예) 2층 201호" value="" >
							</div>

							<div id="wrap_zipcode" style="display:none;border:1px solid;width:100%;height:300px;margin:5px 0;position:relative">
								<img src="//t1.daumcdn.net/postcode/resource/images/close.png" id="btnFoldWrap" style="cursor:pointer;position:absolute;right:0px;top:-1px;z-index:1" onclick="foldDaumPostcode()" alt="접기 버튼">
							</div>

							<div class="form-group">
								<label for="">* 전화번호</label>
								<input class="form-control" type="tel" placeholder="전화번호를 입력해 주세요" name="store_tel" id="store_tel">
							</div>

							<div class="form-group">
								<label for="">결제/구매 적립금 &#40;&#37;&#41; <br>* G-Pay로 결제시 결제 고객에게 지급하는 적립금 (숫자만 입력해 주세요)</label>
								<input class="form-control input-sm mt-1" type="number" maxLength="3" oninput="maxLengthCheck(this)" placeholder="<?=$dic['Please_enter_saving_rate']?>" id="store_saving_rate" name="store_saving_rate">
							</div>

							<div class="form-group">
								<label for="">* 스토어 소개</label>
								<textarea class="form-control" rows="8" placeholder="스토어 소개글을 입력해 주세요" name="store_desc" id="store_desc"></textarea>
							</div>
							<div class="form-group con-store-img">
								<label for="">스토어 이미지 &#40;800x600 / 10M 까지&#41;</label>
								<div class="list list-three my-2">
									<ul class="row no-style pl-3">
										<li>
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="file[]">
											  </div>
											</div>
										  </li>
										  <li>
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="file[]">
											  </div>
											</div>
										  </li>
										  <li>
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="file[]">
											  </div>
											</div>
										  </li>
										  <li>
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="file[]">
											  </div>
											</div>
										  </li>
										  <li>
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="file[]">
											  </div>
											</div>
										  </li>
										  <li>
											<div class="box">
											  <div class="js-image-preview">
												<input type="file" class="image-upload" accept="image/*" name="file[]">
											  </div>
											</div>
										</li>
									</ul>
								</div>
							</div>
							<div class="">
								<label for="">* 스토어 입점 승인후, '스토어 관리'에서 상품(메뉴)를 등록할 수 있습니다.</label>
							</div>
							<div class="mt-3">
								<a class="btn-block btn btn-primary fs-0 mb-5" href="javascript:frm_write.submit();$('#submit-a').attr('href','#');" id="submit-a" --data-id="md-confirm" --data-toggle="biko-modal">스토어 등록신청</a>
							</div>
						</div>
						</form>
					</div>
				</div>

					<div class="remodal hidden" id="md-confirm">
						<div class="remodal-contents p-3">
						  <p class="mt-2">
							<?=$dic['Review_is_registered']?>
						  </p>
						</div>
						<div class="remodal-footer text-center">
						  <button class="btn color-primary" onclick="hideModal()">
							<?=$dic['confirm']?>
						  </button>
						</div>
					</div>
					</form>

                </div>
            </div>
        </div>
    </section>

    <!-- ##### Area End ##### -->

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
      function maxLengthCheck(object) {
        if (object.value.length > object.maxLength) {
          object.value = object.value.slice(0, object.maxLength);
        }
      }

    </script>
<?/*
    <!-- <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> -->
    <script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>


<!-- var script = document.createElement('script');  
script.src = "https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js";  
document.head.appendChild(script); -->

<!-- <script src="js/postcode.v2.js"></script>
<script src="js/t1.js"></script> -->
<!-- <script src="http://t1.daumcdn.net/postcode/api/core/190107/1546836247227/190107.js"></script> -->
    <script>
      // 우편번호 찾기 화면을 넣을 element
	  var element_wrap;
	  $(function(){
		element_wrap = document.getElementById('wrap-zipcode');
	  });

      function foldDaumPostcode() {
        // iframe을 넣은 element를 안보이게 한다.
        element_wrap.style.display = 'none';
      }

      function sample2_execDaumPostcode() {

        var currentScroll = Math.max(document.body.scrollTop, document.documentElement.scrollTop);

        console.log(daum);

        //daum.postcode.load(function(){

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
            if (data.userSelectedType === 'R') {
              // 법정동명이 있을 경우 추가한다. (법정리는 제외)
              // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
              if (data.bname !== '' && /[동|로|가]$/g.test(data.bname)) {
                extraAddr += data.bname;
              }
              // 건물명이 있고, 공동주택일 경우 추가한다.
              if (data.buildingName !== '' && data.apartment === 'Y') {
                extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
              }
              // 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
              if (extraAddr !== '') {
                extraAddr = ' (' + extraAddr + ')';
              }
              // 조합된 참고항목을 해당 필드에 넣는다.
              //document.getElementById("sample2_extraAddress").value = extraAddr;

            } else {
              // document.getElementById("sample2_extraAddress").value = '';
            }

            // 우편번호와 주소 정보를 해당 필드에 넣는다.
            // document.getElementById('sample2_postcode').value = data.zonecode;
            document.getElementById("store_addr").value = addr;
            // 커서를 상세주소 필드로 이동한다.
            document.getElementById("store_addr_detail").focus();

            // iframe을 넣은 element를 안보이게 한다.
            // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
            element_wrap.style.display = 'none';

            // 우편번호 찾기 화면이 보이기 이전으로 scroll 위치를 되돌린다.
            document.body.scrollTop = currentScroll;

          },
          // 우편번호 찾기 화면 크기가 조정되었을때 실행할 코드를 작성하는 부분. iframe을 넣은 element의 높이값을 조정한다.
          onresize: function(size) {
            element_wrap.style.height = size.height + 'px';
          },
          width: '90%',
          height: '100%'
        }).embed(element_wrap);

        // iframe을 넣은 element를 보이게 한다.
        element_wrap.style.display = 'block';


        //});

      }

      // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
      // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
      // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
      function initLayerPosition() {
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 400; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 5; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width) / 2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height) / 2 - borderWidth) + 'px';
      }

    </script>
	*/?>

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
	<script>
	$('.nav_bottom li[data-name="storeadd"]').addClass('active');
</script>

</html>
