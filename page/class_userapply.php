<?
    include "./inc_program.php";

    $strRecordNo = $_GET["txtRecordNo"];

    
    $query  = " SELECT co_id, member_id   \n";
    $query .= " FROM   tbl_coach \n";
    $query .= " WHERE  co_id = '{$strRecordNo}'   \n";    
    
    $resultCoach = db_query($query); 

    if (!$resultCoach) {
        msg_page("잘못된 정보입니다.");
        exit;
    }

    

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<script>
	$(document).ready(function(){
        // 등록 클릭시
        $(document).on('click', '#btnReg', function(event) {
            var formData = new FormData($('#frmReg')[0]);

            if ($.trim($('#txtContents').val()) == "") {
                alert("내용을 입력하세요.");
                $('#txtContents').focus();
                return;
            }

            if (confirm("글을 등록하시겠습니까?")) {
                $.ajax({
                    url: 'class_userapply_action.php',
                    processData: false,
                    contentType: false,
                    data: formData,
                    type: 'POST',
                    success: function(result){
                        Data = $.trim(result);

                        if (Data == "SUCCESS") {
                           alert('글이 등록되었습니다.');
                           top.location.href = "artist.php?txtRecordNo=<?=$strRecordNo?>";
                        } else if(Data == "FAILED") {
                            alert('글 등록이 실패했습니다. 관리자에게 문의하세요.');
                        } else {
                            alert(Data);
                        }
                    }
                });
            }        
        });
	});

</script>

<body>

<? include "./inc_Top.php"; ?>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
				<article class="user-profile text-center mb-2">
					
					</article>
					<!--글쓰기-->
					<article>
            			<form name="frmReg" id="frmReg" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="txtRecordNo" id="txtRecordNo" value="<?=$strRecordNo?>">
							<div class="p-3">
								<div class="d-flex align-items-center">
									<img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="35" height="35" class="rounded-circle">
									<div class="ml-3 fw-600"><?=$rowMember['닉네임']?></div>
								</div>
								<div class="my-2 border color-9">
									<textarea name="txtContents" id="txtContents" class="form-control" rows="5" placeholder="작성해주세요"></textarea>
								</div>
								<div class="con-photo text-right">
									<button class="btn-photoadd btn btn-outline-secondary btn-sm" type="button" ><i class="fas fa-image"></i> 사진첨부</button>
									<div class="box mt-2">
										<div class="js-image-preview">
											<input type="file" name="txtImg" id="txtImg" class="image-upload" accept="image/*">
										</div>
									</div>
								</div>
								<button type="button" class="btn btn-primary btn-block fs-0 mt-3" id="btnReg">등록</button>
							</div>
						</form>
					</article>
					<!--//글쓰기-->
					
					
				</div>
			</div>
		</div>
	</section>



	<? include "./inc_Bottom_lesson.php"; ?>
</body>

<script>
	$('.btn-photoadd').click(function(){
		$('.con-photo .box').addClass('active');
	});
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
	$('.nav_bottom li[data-name="watchhome"]').addClass('active');
	


</script>

</html>