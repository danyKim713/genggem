<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<?
$_SESSION['S_CID'] = $_GET['CID'];
?>

<script>
	$(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_gallery_list();
			}
		});
	});

	var pageNo = 1;

	$(function(){
		go_list_gallery_list();
	});

	function go_list_gallery_list(){
		$.ajax({
			type: 'POST',
			url: "_ajax_gallery_list.php",
			data: {
				pageNo: pageNo
			},
			async: false,
			success: function(data){
				//console.log(data);
				$("#gallery-list").append(data);
				pageNo++;
			}
		});
	}	


	function go_write_gallery_submit(){

		var form_data = new FormData();

		form_data.append("내용", $("#페이지_내용").val());

	   // Read selected files
	   var totalfiles = document.getElementById('imageupload').files.length;

	   if(totalfiles == 0){
		   alert('첨부파일을 선택해주세요.');
		   return false;
	   }

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
				url: "_ajax_gallery_write_action.php",
				type: "POST",
				data: form_data,
				processData: false,
				contentType: false,
				success: function(result) {
					if($.trim(result) == "SUCCESS"){
						alert('성공적으로 등록되었습니다.');
						location.reload(true);
					}else if(result == "MANDATORY_ERROR"){
						alert('내용을 입력해주세요.');
						$("#btn_write").attr("onClick","go_write_gallery_submit();");
						$("#btn_write").addClass("btn-primary");
						$(".loading").hide();
					}else{
						alert('오류가 발생했습니다.');
						$("#btn_write").attr("onClick","go_write_gallery_submit();");
						$("#btn_write").addClass("btn-primary");
						$(".loading").hide();
					}
				},       
				error: function(res) {
					alert('오류가 발생했습니다.');
					$("#btn_write").attr("onClick","go_write_gallery_submit();");
						$("#btn_write").addClass("btn-primary");
						$(".loading").hide();
				}       
			});
		}
	}
</script>

<script type="text/javascript">
function popct(url, w, h) {
popw = (screen.width - w) / 2;
poph = (screen.height - h) / 2;
popft = 'height=' + h + ',width=' + w + ',top=' + poph + ',left=' + popw;
window.open(url, '', popft);
}
</script>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg8.jpg);">
            <h2>CAFE <font size="5px">in</font>...<br>
			<font size="4px" color="">Open Community</font></h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<section id="m_nav2">
			<? 
			$nowMenu  = "갤러리";
			include "inc_tab_menu_channel.php"; 
			?>
	</section>

	<!-- ##### Blog Content Area Start ##### -->
    <section class="blog-content-area">
        <div class="container">
			<!-- Post Details Area -->
			<div class="mt-2">
				<div class="post-content text-center">
					<h4 class="post-title"><?if($rowMember['member_id'] == $rowChannel['member_id']){?>
					<i class="fas fa-crown color-warning mr-1"></i>
					<?}?><?=$rowChannel['채널이름']?></h4>
					<h5>[갤러리]</h5>
				</div>
			</div>
		</div>
	</section>

	<section>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-12">

					<?
					$멤버여부 = true;
					//채널 멤버가 아니면 튕기게 해야 함....
					$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
					$rowM = db_select($query);

					if($rowM['강퇴여부']=="Y"){
						//msg_page('이미 강퇴당한 클럽입니다.');
						$멤버여부 = false;
					}

					if(!$rowM['pk_channel_member'] && $rowMember['member_id'] != $rowChannel['member_id']){
						//msg_page('클럽에 가입해야 이용가능한 서비스입니다.');
						$멤버여부 = false;
					}

					if($멤버여부){?>

					<!--글쓰기-->
					<article>
						<form name="frm_write" id="frm_write" method="post">
							<div class="p-0">
								<div class="d-flex align-items-center">
									<img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
									<div class="ml-3 fw-600"><?=$rowMember['닉네임']?></div>
								</div>
								<!-- <div class="my-2 border color-9">
									<textarea name="페이지_내용" id="페이지_내용" class="form-control" rows="5" placeholder="작성해주세요"></textarea>
								</div> -->
								<div class="con-photo text-right" style="margin-top:-30px;">
									<button class="btn-photoadd btn btn-outline-secondary btn-sm" type="button" id="photo-file-button"><i class="fas fa-image"></i> 사진첨부</button>
									<p class="mt-2">* 이미지 다중 선택시 최대6장까지 업로드 가능합니다. </p>
									<div class="box mt-2">
										<div --class="js-image-preview">
											<input type="file" name="files[]" id="imageupload" class="image-upload" accept="image/*" multiple>
										</div>
										<div id="preview-image"></div>
									</div>
								</div>
								<button type="button" class="btn btn-primary btn-block fs-0 mt-3" onClick="go_write_gallery_submit();" id="btn_write">등록</button>
							</div>
						</form>
					</article>
					<!--//글쓰기-->
					<?}?>
					
					<article class="mb-5 mt-3">
						<h3 class="main-tlt display-inline">갤러리</h3>
						<div class="list-card mt-3">
							<div class="card-columns">
								<div id="gallery-list">
								</div>
							</div>
						</div>
					</article>
					

					
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_cafe.php"; ?>
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

<script>
	$('.nav_category li[data-name="gnb-channel"]').addClass('active');
</script>
</html>