<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">



<script>
	$(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_page_user();
			}
		});
	});

	var pageNo = 1;

	$(function(){
		go_list_page_user();
	});

	function go_list_page_user(){
		$.ajax({
			type: 'POST',
			url: "_ajax_page_list_user.php",
			data: {
				UID: '<?=$_GET['UID']?>',
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
</script>

<?
$query = "select * from tbl_member where UID = '{$_GET['UID']}'";
$rowM = db_select($query);

if($rowM['공개여부']=="미공개"){

	msg_page('공개되지 않은 회원입니다.');
	exit;
}

if($rowM['공개여부'] == "친구만공개" && !친구여부($rowM['member_id'], $rowMember['member_id'])){

	msg_page('친구에게만 공개하신 회원입니다.');
	exit;
}

$query = "select count(*) as cnt from gf_friends where origin_member_id = '{$rowM['member_id']}'";
$rowF = db_select($query);
$페이지친구수 = $rowF['cnt'];
?>

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
						<a href="<?=phpThumb("/_UPLOAD/".$rowM['페이지배경사진'],1000,250,"2","")?>" data-lightbox="menu">
							<div class="js-image-preview background-10" style="background-image:url(<?=phpThumb("/_UPLOAD/".$rowM['페이지배경사진'], 1000, 250, "2",  "assets/images/page_bg.jpg")?>)">
							</div>
						</a>
						<!-- <div class="input-icon"><span class="icon ic-camera"></span></div> -->
					</div>
					<!--//배경이미지-->
					
					<!--프로필-->
					<div class="d-flex text-center p-3 align-items-center justify-content-center">
						<div class="user-img box position-r">
							<a href="<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'],500,500,"2","")?>" data-lightbox="menu">
								<div class="js-image-preview" style="background-image:url(<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'], 120, 120, "2", "assets/images/page_user_img.jpg")?>)">
								</div>
							</a>
							<?/* <div class="input-icon"><span class="icon ic-camera"></span></div> 
							<h5 class="fs-0 mt-2"></h5>*/?>
						</div>
						<div class="pl-3 w-100">
						 <h2 class="fs-05 mb-3  color-clip bg-gradient-primary fw-600"><?=$rowM['닉네임']?></h2>
							<div class="d-flex div-f">
								<a href="page_friends.php?member_id=<?=$rowM['member_id']?>" title="친구 전체보기" class="col">
									<span class="fs-005">친구</span><br>
									<span class="fs-05 color-primary fw-600"><?=number_format(친구수($rowM['member_id']))?></span>
								</a>
								<a href="page_following.php?member_id=<?=$rowM['member_id']?>" title="팔로잉 전체보기" class="col">
									<span class="fs-005">팔로잉</span><br>
									<span class="fs-05 color-primary fw-600"><?=number_format(팔로잉수($rowM['member_id']))?></span>
								</a>
								<a href="page_follower.php?member_id=<?=$rowM['member_id']?>" title="팔로워 전체보기" class="col">
									<span class="fs-005">팔로워</span><br>
									<span class="fs-05 color-primary fw-600"><?=number_format(팔로워수($rowM['member_id']))?></span>
								</a>
							</div>
							<div class="mt-2 mb-2"><?=$rowM['페이지이름']?></div>
						</div>
					</div>
					<!--//프로필-->
					</article>
					<!--글쓰기-->

					<!--//글쓰기-->
					<!--프로필정보-->
					<article class="mb-2">
						<div class="page-info p-3">
							
							<div class="user-info">
								<ul class="user-info-list">
									<li>
										<label><i class="fab fa-font-awesome-flag color-8 fs--1"></i> 국적</label>
										<div class="d-table-cell">
											<span class="fs-005"><?=get_국적($rowM['country_id'])?></span>
										</div>
									</li>
									<li>
										<label><i class="fas fa-location-arrow color-8 fs--1"></i> 거주</label>
										<div class="d-table-cell">
											<span class="fs-005"><?=$rowM['시도']?></span>
											<span class="fs-005"><?=$rowM['구군']?></span>
										</div>
									</li>
									<?/*<li>
										<label><i class="fas fa-star color-8 fs--1"></i> 출신</label>
										<div class="d-table-cell">
											<span class="fs-005"><?=$rowM['출신지역']?></span>
										</div>
									</li>
									<li>
										<label><i class="far fa-edit color-8 fs--1"></i> 가입</label>
										<div class="d-table-cell">
											<span class="fs-005"><?=date("Y-m-d",strtotime($rowM['regdate']))?></span>
										</div>
									</li>
									<li>
										<label><i class="fas fa-graduation-cap color-8 fs--1"></i> 학교</label>
										<div class="d-table-cell">
											<span class="fs-005"><?=$rowM['출신고등학교']?></span>
											<span class="fs-005"><?=$rowM['출신대학교']?></span>
										</div>
									</li>
									
									<li>
										<label><i class="far fa-eye color-8 fs--1"></i> 공개</label>
										<div class="d-table-cell">
											<span class="fs-005"><?=$rowM['공개여부']?></span>
										</div>
									</li>*/?>

									<li>
										<label><i class="fas fa-gem color-8 fs--1"></i> 생일</label>
										<div class="d-table-cell">
											<span class="fs-005"><?=date("m월 d일",strtotime($rowM['birthday']))?></span>
										</div>
									</li>
									<li>
										<label><i class="fas fa-at color-8 fs--1"></i> 페이지주소</label>
										<div class="d-table-cell">
										<p onclick="copyToAddress('#copyAddress')" class="address fs--1 d-inline">
											<span id="copyAddress" class="text-address"><?=isSecure()?"https":"http"?>://<?=$_SERVER['HTTP_HOST']?>/page/page_user.php?UID=<?=$rowM[UID]?></span>
											<button class="text-copy background-white">복사</button>
										</p>
										</div>
									</li>
									<li class="d-flex align-itmes-top mt-2">
										<label><i class="fas fa-bars color-8 fs--1 mt-1"></i> 가입한 카페</label>
										<div class="d-table-cell">
										<ul class="d-inline-block">
<?
$query = "select CID, 채널이름, member_id from gf_channel_member A, gf_channel B where A.fk_channel = B.pk_channel and fk_member = '{$rowM['member_id']}' and A.강퇴여부 = 'N' and B.사용여부='Y'

UNION

select CID, 채널이름, member_id from gf_channel where member_id = '{$rowM['member_id']}' and 사용여부='Y'

";
$resultC = db_query($query);

while($rowC = db_fetch($resultC)){
?>

											<li>
												<a href="channel_view.php?CID=<?=$rowC['CID']?>" title="카페 바로가기" class="fs-005 color-6"><?=$rowC['채널이름']?> <?if($rowC['member_id']==$rowM['member_id']){?>(카페장)<?}?></a>
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
						<h2 class="main-tlt display-inline">페이지 친구 <span class="color-primary"><?=number_format(페이지친구수($rowM['member_id']))?></span></h2>
						<!-- <a href="page_friends.php" title="전체보기" class="float-right color-6 fs-005 pt-1">전체보기 <span class="icon ic-right-arrow fs--1"></span></a> -->
						<div class="text-center mt-3">
							<div class="list-card mt-3">
								<ul class="card-columns">

<?
$query = "select friend_member_id as id from gf_friends where origin_member_id = '{$rowM['member_id']}' and 진행상태 = '친구수락' 

	UNION

	select origin_member_id as id from gf_friends where friend_member_id = '{$rowM['member_id']}' and 진행상태 = '친구수락'
 

order by rand() LIMIT 0,6";
$resultFR = db_query($query);

while($rowFR = db_fetch($resultFR)){
	$query = "select * from tbl_member where member_id = '{$rowFR['id']}'";
	$rowF = db_select($query);
?>

									<li class="card border-none mb-2">
										<a href="page_user.php?UID=<?=$rowF['UID']?>" title="">
											<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowF['페이지프로필사진'], 300, 300, 0,"assets/images/user_img2.jpg")?>"  width="300" alt="" />
											<p class="mt-1 mb-2 fs-005"><?=$rowF['닉네임']?></p>
										</a>
									</li>
<?}?>
								</ul>
							</div>
						</div>
					</article>
					<!--//페이지친구-->
					<!--게시글-->

<?
$query = "select count(*) as cnt from gf_page_article where member_id = '{$rowM['member_id']}'";
$rowCNT = db_select($query);
$게시글수 = $rowCNT['cnt'];
?>

					<article class="p-3 mb-2">
						<div class="background-white">
							<h2 class="main-tlt display-inline">페이지 게시글 <span class="color-primary"><?=number_format($게시글수)?></span></h2>
						</div>
						<div class="list list-page">
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
	
		//주소복사
		function copyToAddress(element) {
			var $temp = $("<input>");
			$("body").append($temp);
			$temp.val($(element).html()).select();
			document.execCommand("copy");
			$temp.remove();
			alert('주소를 복사했습니다.');
		}
</script>
<script>
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</script>

</html>