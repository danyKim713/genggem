<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<script>
	$(function(){
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true
		})
	});

	$(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_page_me();
			}
		});
	});

	var pageNo = 1;

	$(function(){
		go_list_page_me();
	});

	function go_list_page_me(){
		$.ajax({
			type: 'POST',
			url: "_ajax_page_list_me.php",
			data: {
				pageNo: pageNo
			},
			async: false,
			success: function(data){
				//console.log(data);
				$("#page-list").append(data);
				pageNo++;
			}
		});
	}	


	function go_write_page(){
		$("#write_a").hide();
		$("#페이지_내용").show();
	}
	function go_write_page_submit(){
		var 내용 = $("#페이지_내용").val();
		$.post("_ajax_page_write_action.php",{
			내용: 내용
		},function(data){
			if(data == "SUCCESS"){
				alert('글이 등록되었습니다.');
				location.reload(true);
			}else if(data == "MANDATORY_ERROR"){
				alert('내용을 입력해주세요.');
			}else{
				alert('오류가 발생했습니다.');
			}
		});
	}
</script>

<body class="mb-5">
<? include "./inc_Top.php"; ?>
	<div class="breadcrumb-area2 hidden-xs">
        <div class="top-breadcrumb-area bg-img d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_pag.jpg);">
        </div>
    </div>
	<section class="alazea-blog-area">
		<div class="wrap-page">
			<div class="container">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-12 col-lg-12 col-xl-11 p-0">
					<article class="user-profile text-center mb-2">
						<!--배경이미지-->
						<div class="box position-r">
							<a href="<?=phpThumb("/_UPLOAD/".$rowMember['페이지배경사진'],1000,250,"2","")?>" data-lightbox="menu">
							<div class="js-image-preview background-10" style="background-image:url(<?=phpThumb("/_UPLOAD/".$rowMember['페이지배경사진'], 1000, 250, "2",  "./assets/images/page_bg.jpg ")?>)">
							</div>
							</a>
							<div class="input-icon"><a href="./page_set.php"><span class="icon ic-camera"></span></a></div>
						</div>
						<!--//배경이미지-->
						
						<!--프로필-->
						<div class="d-flex text-center p-3 align-items-center justify-content-center">
							<div class="user-img box position-r">
								<a href="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'],500,500,"2","")?>" data-lightbox="menu">
								<div class="js-image-preview" style="background-image:url(<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 120, 120, "2",  "./assets/images/user_img.jpg ")?>)">
								</div>
								</a>
								<div class="input-icon"><a href="./page_set.php"><span class="icon ic-camera"></span></a></div>
								<h5 class="fs-0 mt-2"></h5>
							</div>
							<div class="pl-3 w-100">
							 <h2 class="fs-05 mb-3  color-clip bg-gradient-primary fw-600"><?=$rowMember['닉네임']?></h2>
								<div class="d-flex div-f">
									<a href="page_friends.php" title="팔로잉 전체보기" class="col">
										<span class="fs-005">친구</span><br>
										<span class="fs-05 color-primary fw-600"><?=number_format(페이지친구수($rowMember['member_id']))?></span>
									</a>
									<a href="page_following.php" title="팔로잉 전체보기" class="col">
										<span class="fs-005">팔로잉</span><br>
										<span class="fs-05 color-primary fw-600"><?=number_format($팔로잉수)?></span>
									</a>
									<a href="page_follower.php" title="팔로워 전체보기" class="col">
										<span class="fs-005">팔로워</span><br>
										<span class="fs-05 color-primary fw-600"><?=number_format($팔로워수)?></span>
									</a>
								</div>
								<div class="mt-2 mb-2"><?=$rowMember['페이지이름']?></div>
							</div>
						</div>
						<!--//프로필-->
						</article>
						<!--글쓰기-->
						<article class="mb-2">
							<form name="frm_write" id="frm_write" method="post">
								<div class="px-3 py-2 d-flex align-items-center position-r">
									<img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="35" height="35" class="rounded-circle">
									<div class="w-100 ml-2">
										<a href="page_write.php" title="글 작성하기" class="p-2 color-8 fs-005" id="write_a">안녕하세요, 게시글을 작성해주세요</a>
										<textarea name="페이지_내용" id="페이지_내용" style="display: none; width: 230px; height: 150px;"></textarea>
										<button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-1" type="button" onClick="top.location.href='page_write.php'" --onClick="go_write_page_file();"><i class="fas fa-image"></i> 사진</button>
										<br/>
	<!--									<button type="button" onClick="go_write_page_submit();">등록</button>-->
									</div>
								</div>
							</form>
						</article>
						<!--//글쓰기-->
						<!--프로필정보-->
						<article class="mb-2">
							<div class="page-info p-3">
								<a href="page_set.php" class="float-right fs-005 color-6">설정 <i class="fas fa-cog mr-1"></i></a>
								<div class="user-info">
									<ul class="user-info-list">
										<li>
											<label><i class="fab fa-font-awesome-flag color-8 fs--1"></i> 국적</label>
											<div class="d-table-cell">
												<span class="fs-005"><?=get_국적($rowMember['country_id'])?></span>
											</div>
										</li>
										<li>
											<label><i class="fas fa-location-arrow color-8 fs--1"></i> 거주</label>
											<div class="d-table-cell">
												<span class="fs-005"><?=$rowMember['시도']?></span>
												<span class="fs-005"><?=$rowMember['구군']?></span>
											</div>
										</li>
										<?/*<li>
											<label><i class="fas fa-star color-8 fs--1"></i> 출신</label>
											<div class="d-table-cell">
												<span class="fs-005"><?=$rowMember['출신지역']?></span>
											</div>
										</li>
										<li>
											<label><i class="far fa-edit color-8 fs--1"></i> 가입</label>
											<div class="d-table-cell">
												<span class="fs-005"><?=date("Y-m-d",strtotime($rowMember['regdate']))?></span>
											</div>
										</li>
										<li>
											<label><i class="fas fa-graduation-cap color-8 fs--1"></i> 학교</label>
											<div class="d-table-cell">
												<span class="fs-005"><?=$rowMember['출신고등학교']?></span>
												<span class="fs-005"><?=$rowMember['출신대학교']?></span>
											</div>
										</li>*/?>
										<li>
											<label><i class="fas fa-gem color-8 fs--1"></i> 생일</label>
											<div class="d-table-cell">
												<span class="fs-005"><?=date("m월 d일",strtotime($rowMember['birthday']))?></span>
											</div>
										</li>
										<?/*<li>
											<label><i class="far fa-eye color-8 fs--1"></i> 공개</label>
											<div class="d-table-cell">
												<span class="fs-005"><?=$rowMember['공개여부']?></span>
											</div>
										</li>*/?>
										<li>
											<label><i class="fas fa-at color-8 fs--1"></i> 페이지주소</label>
											<div class="d-table-cell">
											<p onclick="copyToAddress('#copyAddress')" class="address fs--1 d-inline">
												<span id="copyAddress" class="text-address"><?=isSecure()?"https":"http"?>://<?=$_SERVER['HTTP_HOST']?>/page/page.php?UID=<?=$rowMember[UID]?></span>
												<button class="text-copy background-white">복사</button>
											</p>
											</div>
										</li>
										<li class="d-flex align-itmes-top mt-2">
											<label><i class="fas fa-coffee color-8 fs--1 mt-1"></i> 가입한 클럽</label>
											<div class="d-table-cell">
											<ul class="d-inline-block">

	<?
	$query = "select CID, 채널이름, member_id from gf_channel_member A, gf_channel B where A.fk_channel = B.pk_channel and fk_member = '{$rowMember['member_id']}' and A.강퇴여부 = 'N' and B.사용여부='Y'

	UNION

	select CID, 채널이름, member_id from gf_channel where member_id = '{$rowMember['member_id']}' and 사용여부='Y'

	";
	$resultC = db_query($query);

	while($rowC = db_fetch($resultC)){
	?>

												<li>
													<a href="cafe.php?CID=<?=$rowC['CID']?>" title="클럽 바로가기" class="fs-005 color-6"><?=$rowC['채널이름']?> <?if($rowC['member_id']==$rowMember['member_id']){?>(클럽장)<?}?></a>
												</li>

	<?}?>

											</ul>	
											</div>
										</li>
									</ul>
								</div>
							</div>
						</article>
						<!--//프로필정보-->
						<!--페이지친구-->

						<article class="p-3 mb-2">
							<h2 class="main-tlt display-inline">페이지 친구 <span class="color-primary"><?=number_format(페이지친구수($rowMember['member_id']))?></span></h2>
							<a href="page_friends.php" title="전체보기" class="float-right color-6 fs-005 pt-1">전체보기 <span class="icon ic-right-arrow fs--1"></span></a>
							<div class="text-center mt-3">
								<div class="list-card mt-3">
									<ul class="card-columns">

	<?
	$query = "
		select * from gf_friends where (origin_member_id = '{$rowMember['member_id']}') and 진행상태 = '친구수락' 

		UNION ALL

		select * from gf_friends where (friend_member_id = '{$rowMember['member_id']}') and 진행상태 = '친구수락'

		order by rand() LIMIT 0,6";

	//echo $query;

	$resultFR = db_query($query);

	while($rowFR = db_fetch($resultFR)){
		$rowF = get_member_row($rowFR['friend_member_id']);

		if($rowF['member_id'] != $rowMember['member_id']){

	?>

										<li class="card border-none mb-2">
											<a href="page.php?UID=<?=$rowF['UID']?>" title="">
												<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowF['페이지프로필사진'], 300, 300, "2","assets/images/user_img2.jpg")?>"  width="300" alt="" />
												<p class="mt-1 mb-2 fs-005"><?=$rowF['닉네임']?></p>
											</a>
										</li>
	<?
		}
	$rowF = get_member_row($rowFR['origin_member_id']);

	if($rowF['member_id'] != $rowMember['member_id']){

	?>

										<li class="card border-none mb-2">
											<a href="page.php?UID=<?=$rowF['UID']?>" title="">
												<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowF['페이지프로필사진'], 300, 300, 0,"assets/images/user_img2.jpg")?>"  width="300" alt="" />
												<p class="mt-1 mb-2 fs-005"><?=$rowF['닉네임']?></p>
											</a>
										</li>


	<?}?>
	<?}?>
									</ul>
								</div>
							</div>
						</article>
						<!--//페이지친구-->
						<!--게시글-->

	<?
	$query = "select count(*) as cnt from gf_page_article where member_id = '{$rowMember['member_id']}'";
	$rowCNT = db_select($query);
	$게시글수 = $rowCNT['cnt'];
	?>

						<article class="p-3 mb-2">
							<div class="pt-3 background-white">
								<h2 class="main-tlt display-inline">페이지 게시글 <span class="color-primary"><?=number_format($게시글수)?></span></h2>
							</div>
							<div class="list list-page mb-3">
								<ul id="page-list">
									<!-- 페이지 게시글 영역 -->

								</ul>
							</div>
						</article>
						<!--//게시글-->
					</div>
				</div>
			</div>
		</div>
	</section>

		<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_page.php"; ?>
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

</script>
<script>
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="page"]').addClass('active');
</script>

</html>