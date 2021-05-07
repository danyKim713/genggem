<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body>
<? include "./inc_Todp.php"; ?>
  <section class="py-0">
    <div class="container-fluid header-top">
      <div class="row align-items-center justify-content-center">
        <div class="col-sm-10 col-lg-6 col-xl-4 p-3">
          <form>
            <div class="wrap-join pb-3 text-center">
              <div class="user-profile m-0-auto">
                <img src="assets/images/user.svg" alt="나의 프로필 사진">
              </div>
              <p class="mt-2 fs-005 color-6 mb-0">작성자 닉네임</p>
            </div>
            <div class="form-group">
              <label for="">별점주기</label>
              <div class="rating-stars">
                <ul id="stars" class="row list-unstyled ml-0">
                  <li class="star" data-value="1">
                    <i class="fas fa-star"></i>
                  </li>
                  <li class="star" data-value="2">
                    <i class="fas fa-star"></i>
                  </li>
                  <li class="star" data-value="3">
                    <i class="fas fa-star"></i>
                  </li>
                  <li class="star" data-value="4">
                    <i class="fas fa-star"></i>
                  </li>
                  <li class="star" data-value="5">
                    <i class="fas fa-star"></i>
                  </li>
                </ul>
              </div>
            </div>
            <div class="form-group">
              <label for="">리뷰내용</label>
              <textarea class="form-control" id="" rows="8" placeholder="내용을 입력해 주세요. (100자 이내)"></textarea>
            </div>
            <div class="form-group con-store-img">
              <label for="">사진첨부</label>
              <div class="list list-three my-2">
                <ul class="row no-style pl-3">
                  <li>
                    <div class="box">
                      <div class="js-image-preview">
                        <input type="file" class="image-upload" accept="image/*">
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="box">
                      <div class="js-image-preview">
                        <input type="file" class="image-upload" accept="image/*">
                      </div>
                    </div>
                  </li>
                  <li>
                    <div class="box">
                      <div class="js-image-preview">
                        <input type="file" class="image-upload" accept="image/*">
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>

            <div class="my-3">
              <a class="btn-block btn btn-primary fs-0" href="javascript:void(0)" data-id="md-confirm" data-toggle="biko-modal">리뷰 등록하기</a>
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
  <? include "./inc_Bottom_partner.php"; ?>
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
</script>
<script>
	$('.nav_category li[data-name="gnb-partner"]').addClass('active');
	$('.nav_bottom li[data-name="partnerreview"]').addClass('active');
</script>
</html>