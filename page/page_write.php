<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<script>
	function go_write_page_submit(){

		var form_data = new FormData();

		form_data.append("내용", $("#페이지_내용").val());

	   // Read selected files
	   var totalfiles = document.getElementById('imageupload').files.length;

		if(totalfiles > 7){
			alert('파일은 6개까지만 업로드 가능합니다.');
			return false;
		}

	   for (var index = 0; index < totalfiles; index++) {
		  form_data.append("files[]", document.getElementById('imageupload').files[index]);
	   }


		if (form_data) {

			$("#btn_write").attr("onClick","void(0);");
			$("#btn_write").removeClass("btn-primary");

			$(".loading").show();

			$.ajax({
				url: "_ajax_page_write_action.php",
				type: "POST",
				data: form_data,
				processData: false,
				contentType: false,
				success: function(result) {
					if($.trim(result) == "SUCCESS"){
						alert('성공적으로 등록되었습니다.');
						top.location.href = "page_me.php";
					}else if(result == "MANDATORY_ERROR"){
						alert('내용을 입력해주세요.');
						$("#btn_write").attr("onClick","go_write_page_submit();");
						$("#btn_write").addClass("btn-primary");
						$(".loading").hide();
					}else{
						alert('오류가 발생했습니다.');
						$("#btn_write").attr("onClick","go_write_page_submit();");
						$("#btn_write").addClass("btn-primary");
						$(".loading").hide();
					}
				},       
				error: function(res) {
					alert('오류가 발생했습니다.');
					$(".loading").hide();
				}       
			});
		}
	}
</script>

<body>

<? include "./inc_Top.php"; ?>
	<section class="wrap-page py-0">
		<div class="container-fluid mt-5">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-8 col-xl-8 p-0">
				<article class="user-profile text-center mb-2">
					
					</article>
					<!--글쓰기-->
					<article>
						<form name="frm_write" id="frm_write" method="post">
							<div class="p-3">
								<div class="d-flex align-items-center">
									<img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="35" height="35" class="rounded-circle">
									<div class="ml-3 fw-600"><?=$rowMember['name']?></div>
								</div>
								<div class="my-2 border color-9">
									<textarea name="페이지_내용" id="페이지_내용" class="form-control" rows="5" placeholder="작성해주세요"></textarea>
								</div>
								<div class="con-photo text-right">
									<button class="btn-photoadd btn btn-outline-secondary btn-sm" type="button" id="photo-file-button"><i class="fas fa-image"></i> 사진첨부</button>
									<div class="box mt-2">
										<div --class="js-image-preview">
											<input type="file" name="files[]" id="imageupload" class="image-upload" accept="image/*" multiple="multiple">
										</div>
										<div id="preview-image"></div>
									</div>
								</div>
								<p>* 사진파일을 여러개를 선택하시면 한번에 여러개의 사진을 등록할 수 있습니다.</p>
								<button type="button" class="btn btn-primary btn-block fs-0 mt-3" onClick="go_write_page_submit();" id="btn_write">등록</button>
							</div>
						</form>
					</article>
					<!--//글쓰기-->
					
					
				</div>
			</div>
		</div>
	</section>



	<? include "./inc_Bottom_page.php"; ?>
</body>
<style type="text/css">
	#imageupload { width: 0; height: 0;}

	.thumbimage {
		float:left;
		width:33%;
		position:relative;
		padding:5px;
		height: 110px;
	}

</style>
<script>
	$(function(){
		$("#photo-file-button").click(function(e){
			e.preventDefault();
			$("#imageupload").click();
		});
	});

	//멀티 파일 업로드 미리보기
	$("#imageupload").on('change', function () {

 	 var totalfiles = document.getElementById('imageupload').files.length;

	 if(totalfiles > 7){
		 alert('파일은 6개까지만 업로드 가능합니다.');
		 return false;
	 }


     var countFiles = $(this)[0].files.length;


     var imgPath = $(this)[0].value;
     var extn = imgPath.substring(imgPath.lastIndexOf('.') + 1).toLowerCase();
     var image_holder = $("#preview-image");
     image_holder.empty();
 
     if (extn == "gif" || extn == "png" || extn == "jpg" || extn == "jpeg") {
         if (typeof (FileReader) != "undefined") {
 
             for (var i = 0; i < countFiles; i++) {
 
                 var reader = new FileReader();
                 reader.onload = function (e) {
                     $("<img />", {
                         "src": e.target.result,
                             "class": "thumbimage"
                     }).appendTo(image_holder);
                 }
 
                 image_holder.show();
                 reader.readAsDataURL($(this)[0].files[i]);
             }
 
         } else {
             alert("It doesn't supports");
         }
     } else {
         alert("Select Only images");
     }
 });



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
	
</script>
<script>
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="board"]').addClass('active');
</script>
</html>