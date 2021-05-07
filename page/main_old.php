<!DOCTYPE HTML>
<html lang="en">
<? 
$NO_LOGIN = "Y";
include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">

<body class="mb-6">
	<? include "./inc_nav.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					
					<article class="mb-2">
						<div class="px-3 py-2 d-flex align-items-center position-r">
							<img src="assets/images/symbol.png" width="35" height="35" class="rounded-circle">
<!--							<img src="assets/images/user_img.jpg" width="35" height="35" class="rounded-circle">-->
							<div class="w-100 ml-1">

<? if($rowMember['member_id']){?>
								<a href="page_write.php" title="글 작성하기" class="p-2 color-8 fs-005 d-block">회원님의 페이지에 글을 남겨주세요</a>
<?}else{?>
								<a href="login.php" title="글 작성하기" class="p-2 color-8 fs-005 d-block">로그인 후 이용할 수 있습니다</a>
<?}?>
								<a href="page_write.php"><button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-1" type="button"><i class="fas fa-image"></i> 사진</button></a>
							</div>
						</div>
					</article>

				
					<!-- 인기페이지 5개 추출 -->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">인기 페이지</h3>
						<!-- <a href="page_best.php" title="모두보기" class="float-right color-6 fs-005">모두보기 <span class="icon ic-right-arrow fs--1"></span> </a> -->
						<div class="list list-default mt-3">
							<ul>

<?
$query = "select * from tbl_member where 공개여부 = '전체공개' and 페이지이름 != '' and member_id != '{$rowMember['member_id']}' order by rand() LIMIT 0,5";
$resultM = db_query($query);

$fMember = array();
while($rowM = db_fetch($resultM)){
	$fMember[] = " member_id != '{$rowM['member_id']}'";
?>

								<?=페이지리스트용($rowM['member_id'])?>
<?}?>

							</ul>
						</div>
					</article>
					<!-- //끝 -->

					
					<!--  신규 페이지 리스팅 50개 -->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">신규 페이지</h3>
						<a href="page_list.php" title="모두보기" class="float-right color-6 fs-005">모두보기 <span class="icon ic-right-arrow fs--1"></span></a>
						<div class="list-card mt-3">
							<div class="card-columns">

<?
$fMemberWhere = implode(" or ", $fMember);

$query = "select * from tbl_member where 공개여부 = '전체공개' and member_id != '{$rowMember['member_id']}' and ({$fMemberWhere}) order by rand() LIMIT 0,51";

$resultM = db_query($query);

while($rowM = db_fetch($resultM)){
?>

								<a href="page_user.php?UID=<?=$rowM['UID']?>" title="" class="card">
									<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".($rowM['페이지배경사진']?$rowM['페이지배경사진']:$rowM['페이지프로필사진']),0,0,0,"assets/images/ex_img3.jpg")?>" alt="">
									 <figcaption class="figure-caption"><?=$rowM['name']?></figcaption>
								</a>
<?}?>
							</div>
						</div>
					</article>
					<? include "./inc_Bottom.php"; ?>
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	$('.slider-banner').slick({
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 3000
	});
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>