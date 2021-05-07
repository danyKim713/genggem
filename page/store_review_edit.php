<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<style type="text/css">
  .rate-select-layer span {
	color: #f0ad4e;
  }

</style>
<body>
  <header class="header">
    <a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
    <h2 class="header-title text-center">Review write</h2>
  </header>
  <section class="py-0">
    <div class="container-fluid">
      <div class="row align-items-center justify-content-center">
        <div class="col-sm-10 col-lg-6 col-xl-4 p-3">
          <form name="frm_review" id="frm_review" method="post" action="franchise_review_write_action.php" encType="multipart/form-data">
		  	<input type="hidden" name="store_id" id="store_id" value="<?=$store_id?>"/>
            <div class="form-group text-center border-bottom pb-2 color-9">
				<div class="wrap-join pb-3 text-center">
					<div class="user-profile m-0-auto">
						<? if($rowMember['photo']){?>
						<img src="<?=phpThumb("/_UPLOAD/".$rowMember['photo'], 63, 63, 2,  "assets/images/user.svg ")?>" alt="사용지 기본이미지">
						<?}else{?>
						<img src="assets/images/user.svg" alt="사용지 기본이미지">
						<?}?>
					</div>
					<p class="mt-2 fs-005 color-6 mb-0">Writer <?=$rowMember['name']?></p>
				</div>
            </div>
            <div class="form-group">
              <label for="">Scope</label>
              <div class="rating-stars">
			  	<input type="hidden" name="star_rate" id="star_rate"/>
			  	<div class="rating"></div>
                 
              </div>
            </div>
            <div class="form-group">
              <label for="">Review content</label>
			  <textarea class="form-control" name="review_content" id="review_content" rows="8" placeholder="Please enter the write content (Within 100 characters)"></textarea>
            </div>
            <div class="form-group con-store-img">
              <label for="">Add photo</label>
              <div class="list list-three my-2">
                <ul class="row no-style pl-3">
                  <li>
                    <div class="box">
                      <div class="js-image-preview">
                        <input type="file" class="image-upload" accept="image/*" name="img1">
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="box">
                      <div class="js-image-preview">
                        <input type="file" class="image-upload" accept="image/*" name="img2">
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="box">
                      <div class="js-image-preview">
                        <input type="file" class="image-upload" accept="image/*" name="img3">
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="mt-5">
			  <a class="btn-block btn btn-secondary btn-lg" href="#" data-id="md-confirm" data-toggle="biko-modal" onClick="go_submit_review();">Resist review</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!--완료-->
  <div class="remodal hidden" id="md-confirm">
    <div class="remodal-contents p-3">
      <p class="mt-2">리뷰가 등록되었습니다.</p>
    </div>
    <div class="remodal-footer text-center">
      <button class="btn color-primary" onclick="hideModal()">확인</button>
    </div>
  </div>
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

    //별점
    $('#stars li').on('click', function() {
      var onStar = parseInt($(this).data('value'), 10);
      var stars = $(this).parent().children('li.star');

      for (i = 0; i < stars.length; i++) {
        $(stars[i]).removeClass('text-warning');
      }

      for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('text-warning');
      }
    });

	$(function(){
	
		var options = {
			max_value: 5,
			step_size: 0.5,
		}
		$(".rating").rate(options);
	
	});

	function go_submit_review(){
		$("#star_rate").val($(".rating").rate("getValue"));
		if($(".rating").rate("getValue")==0){
			if(!confirm('별점 0을 주시겠습니까?')){
				return false;
			}
		}
		if($("#review_content").val()==""){
			alert("리뷰내용을 입력해주세요.");
			return false;
		}

		frm_review.submit();

	}
</script>

</html>