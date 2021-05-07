<?
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

// 나의 주문목록
$query  = " SELECT A.lo_id, A.l_id, A.coach_id, A.member_id, A.member_uid, A.payment_flg, A.order_price, A.order_dt, A.status_flg, A.l_point,    \n";
$query .= "            B.l_title, B.l_area, B.l_area, B.cat_id,  D.cat_nm, E.lesson_title, F.co_id    \n";
$query .= " FROM    tbl_lesson_order A, tbl_lesson B, tbl_lesson_category D, tbl_lesson_setup E, tbl_coach F    \n";
$query .= " WHERE  A.lo_id = '{$strRecordNo}'   \n";  
$query .= " AND      A.member_id = '{$ck_login_member_pk}'   \n";  
$query .= " AND      A.l_id = B.l_id   \n";  
$query .= " AND      A.coach_id = E.member_id   \n";  
$query .= " AND      A.coach_id = F.member_id   \n";  
$query .= " AND      B.cat_id = D.cat_id   \n";

$rowOrder = db_select($query);   
?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body>

<? include "./inc_gnb.php"; ?>
    <section class="wrap-page py-0">
        <div class="container-fluid header-top">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-10 col-lg-6 col-xl-4 p-0">
                    <!--tab-->
                    <div id="tab-menu" class="clearfix">
                        <ul class="d-flex align-items-center justify-content-center text-center">
                            <li class="col p-0"><a href="class_contents.php" title="레슨목록">레슨목록</a></li>
                            <li class="col p-0"><a href="class_artist.php" title="코치소개">코치소개</a></li>
                            <li class="col p-0"><a href="class_review.php" title="레슨후기">레슨후기</a></li>
                            <li class="col p-0 active"><a href="class_my.php>" title="나의레슨">나의레슨</a></li>
                        </ul>
                    </div>
                    <!--tab-->	
                    <article class="mt-5">
                        <!-- 레슨/코치 정보 -->
                        <div class="list-tour tour-wide mt-2  p-3">
                            <ul>
                                <li>
                                    <div class="con-info">
                                        <h4 class="tlt mt-1 ml-1"><?=$rowOrder["lesson_title"]?></span> <button class="btn-right btn btn-outline-secondary btn-sm ml-1" type="button" onClick="top.location.href='class_view.php?txtRecordNo=<?=$rowOrder["co_id"]?>'"><i class="fas fa-image"></i> 레슨보기</button></h4>
                                        <dl class="txt-info d-flex ml-2">
                                            <span><i class="fas fa-edit opacity-50"></i> <?=$rowOrder["l_title"]?><br>
                                            <i class="fas fa-medal opacity-50"></i> <?=$rowOrder["cat_nm"]?></span>
                                        </dl>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!--// 레슨/코치 정보 끝-->
                        <div class="p-3">
                            <form name="frmCreate" id="frmCreate" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="txtRecordNo" id="txtRecordNo" value="<?=$rowOrder["l_id"]?>">
                            <div class="form-group">
                                <label for="">만족도 별점</label>
                                <div class="rating-stars">
                                    <input type="hidden" name="txtStarRate" id="txtStarRate"/>
                                    <!--<div class="rating"></div>-->
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
                            <div class="my-2 border color-9">
                                <textarea name="txtReview" id="txtReview" class="form-control" rows="5" placeholder="레슨 후기를 작성해 주세요"></textarea>
                            </div>
                            <div class="form-group con-store-img">
                                <label for="">사진첨부</label>
                                <div class="list list-three my-2">
                                    <ul class="row no-style pl-3">
                                        <li>
                                            <div class="box">
                                                <div class="js-image-preview">
                                                    <input type="file" class="image-upload txtImg" accept="image/*" name="txtImg[]" id="txtImg1">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box">
                                                <div class="js-image-preview">
                                                    <input type="file" class="image-upload txtImg" accept="image/*" name="txtImg[]" id="txtImg2">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="box">
                                                <div class="js-image-preview">
                                                    <input type="file" class="image-upload txtImg" accept="image/*" name="txtImg[]" id="txtImg3">
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            </form>
                            <button id="btnReg" class="btn btn-primary btn-block fs-0 mt-4">레슨후기등록</button>
                        </div>

                    </article>
                    <!--//글쓰기-->
                </div>
            </div>
        </div>
    </section>

	<? include "./inc_Bottomd.php"; ?>
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

	  $('#txtStarRate').val(onStar);

    });

	$(function(){
	
		var options = {
			max_value: 5,
			step_size: 0.1,
		}
		$(".rating").rate(options);

	});

	$(document).ready(function(){
 	    $('#txtStarRate').val(0)	

		// 등록버튼 클릭시
        $(document).on('click', '#btnReg', function(event) {
			var formData = new FormData($('#frmCreate')[0]);

			if(parseInt($('#txtStarRate').val(), 10)==0){
				if(!confirm('별점 0을 주시겠습니까?')){
					return;
				}
			}	

			if($.trim($("#txtReview").val()) == ""){
				alert("레슨후기를 입력해주세요.");
				return;
			}			

			if (confirm("후기를 등록하시겠습니까?")) {
				$.ajax({
					url: 'class_review_write_action.php',
					processData: false,
					contentType: false,
					data: formData,
					type: 'POST',
					success: function(result){
						Data = $.trim(result);
						if (Data == "SUCCESS") {
						   alert('후기가 등록되었습니다.');
                            $(location).attr('href', 'class_review.php');
						} else if(Data == "FAILED") {
							alert('후기등록이 실패했습니다. 관리자에게 문의하세요.');
						} else {
							alert(Data);
						}
					}
				});
			}
		});
	});

</script>
<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>

</html>