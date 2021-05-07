<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";

$_SESSION['S_CID'] = $CID;
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<?
//채널 멤버가 아니면 튕기게 해야 함....
$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
$rowM = db_select($query);

if($rowM['강퇴여부']=="Y"){
	msg_page('이미 강퇴당한 클럽입니다.');
}

if(!$rowM['pk_channel_member'] && $rowMember['member_id'] != $rowChannel['member_id']){
	msg_page('클럽에 가입해야 이용가능한 서비스입니다.');
}
?>

<script>
	// 등록버튼을 여러번 클릭할때 데이터가 여러번 저장되는 것을 방지하기 위해 사용하는 변수
	var ischk = true;		

    $(document).ready(function(){

        // 클래스찜 클릭시
        $(document).on('click', '#btnReg', function(event) {
			if (ischk == false) return;

			ischk = false;

			var form_data = new FormData();

			form_data.append("내용", $("#페이지_내용").val());
			form_data.append("CID", '<?=$CID?>');

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
				$.ajax({
					url: "_ajax_channel_bbs_write_action.php",
					type: "POST",
					data: form_data,
					processData: false,
					contentType: false,
					success: function(result) {
						if($.trim(result) == "SUCCESS"){
							alert('성공적으로 등록되었습니다.');
							ischk = true;
							//top.location.href = "cafe_view2.php?CID=<?=$CID?>";
                            opener.document.location.reload();
							window.close();
						}else if(result == "MANDATORY_ERROR"){
							alert('내용을 입력해주세요.');
						}else{
							alert('오류가 발생했습니다.');
						}
					},       
					error: function(res) {
						alert('오류가 발생했습니다.');
					}       
				});
			}

        });

    });

/*
	function go_write_page_submit(){

		var form_data = new FormData();

		form_data.append("내용", $("#페이지_내용").val());
		form_data.append("CID", '<?=$CID?>');

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
			$.ajax({
				url: "_ajax_channel_bbs_write_action.php",
				type: "POST",
				data: form_data,
				processData: false,
				contentType: false,
				success: function(result) {
					if($.trim(result) == "SUCCESS"){
						alert('성공적으로 등록되었습니다.');
						//top.location.href = "cafe_view2.php?CID=<?=$CID?>";
						opener.location.href = "cafe_view2.php?CID=<?=$CID?>";
						window.close();
					}else if(result == "MANDATORY_ERROR"){
						alert('내용을 입력해주세요.');
					}else{
						alert('오류가 발생했습니다.');
					}
				},       
				error: function(res) {
					alert('오류가 발생했습니다.');
				}       
			});
		}
	}
*/
</script>

<header class="header top_fixed">
	<h2 class="header-title text-center"><img src="./assets/img/core-img/logo_b.png"></h2>
</header>
</div>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center justify-content-center">
				<div class="section-heading">
				<h2>CAFE - 글쓰기</h2>
			</div>
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
				<article class="user-profile text-center mb-2">
					
					</article>
					<!--글쓰기-->
					<article>
						<form name="frm_write" id="frm_write" method="post">
							<div class="p-3">
								<div class="d-flex align-items-center">
									<img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="35" height="35" class="rounded-circle">
									<div class="ml-3 fw-600"><?=$rowMember['닉네임']?></div>
								</div>
								<div class="my-2 border color-9">
									<textarea name="페이지_내용" id="페이지_내용" class="form-control" rows="5" placeholder="작성해주세요"></textarea>
								</div>
								<div class="con-photo text-right">
									* 이미지 다중 선택시 6장까지 업로드 가능합니다.<br>
									<button class="btn-photoadd btn btn-outline-secondary btn-sm" type="button" id="photo-file-button"><i class="fas fa-image"></i> 사진첨부</button>
									<div class="box mt-2">
										<div --class="js-image-preview">
											<input type="file" name="files[]" id="imageupload" class="image-upload" accept="image/*" multiple>
										</div>
										<div id="preview-image"></div>
									</div>
								</div>
								<span id="btnReg" class="btn btn-primary btn-block fs-0 mt-3">등록</span>
							</div>
						</form>
					</article>
					<!--//글쓰기-->
					
					
				</div>
			</div>
		</div>
	</section>


</body>
<style type="text/css">
	#imageupload { width: 0; height: 0;}

	.thumbimage {
		float:left;
		width:33%;
		position:relative;
		padding:5px;
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

</html>