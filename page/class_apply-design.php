<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body>

<? include "./inc_Top.php"; ?>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
				<article class="user-profile text-center mb-2">
					<!--tab-->
					<div id="tab-menu" class="clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0"><a href="watch.php" title="영상">영상</a></li>
							<li class="col p-0"><a href="watch_my.php" title="내영상">내영상</a></li>
							<li class="col p-0 active"><a href="lesson.php" title="코치/레슨">코치/레슨</a></li>
							<li class="col p-0"><a href="lesson_my.php" title="나의레슨">나의레슨</a></li>
						</ul>
					</div>
					<!--tab-->
					<!--배경이미지-->
					<div class="box position-r">
						<div class="js-image-preview background-1" style="background-image:url(assets/images/lesson_1.jpg)">
						</div>
					</div>
					<!--//배경이미지-->
					
					<!--상품명/상태-->
					<div class="d-flex text-center p-3 align-items-center justify-content-center">
						<div class="pl-3 w-100">
						 <h2 class="fs-005 mb-1  color-clip bg-gradient-primary">레슨 상품명 : 원포인트레슨 30분 </h2>
						 <button type="button" class="btn btn-outline-primary btn-sm btn-capsule mt-2"><i class="fas fa-check fs--1 opacity-5"></i> 레슨접수중</button>
						</div>
					</div>
					<!--//상품명/상태-->
					</article>
					
					<!--상품정보-->
					<article class="mb-2">
						<div class="page-info p-3">
							<div class="user-info">
								<ul class="user-info-list">
									<li>
										<label><i class="fas fa-map-marker-alt color-8 fs--1"></i> 레슨지역</label>
										<div class="d-table-cell">
											<span class="fs-005">서울/강남</span>
										</div>
									</li>
									<li>
										<label><i class="fas fa-location-arrow color-8 fs--1"></i> 레슨비용</label>
										<div class="d-table-cell">
											<span class="fs-005">50,000 원</span>
										</div>
									</li>
									<li>
										<label><i class="fas fa-star color-8 fs--1"></i> 레슨종류</label>
										<div class="d-table-cell">
											<span class="fs-005">온라인/영상 레슨</span>
										</div>
									</li>
									<li>
										<label><i class="fas fa-bars color-8 fs--1"></i> 레슨상품소개</label>
										<div class="d-table-cell">
										<p onclick="copyToAddress('#copyAddress')" class="address fs--1 d-inline">
											<span id="copyAddress" class="">안녕하에쇼. 박형준 프로입니다. 여러분들에게 잊지못할 코칭을 만들어 드립니다. 말보다 몸이 먼저 반응하고 생각보다 행동으로 옮길수 있는 멋진 라운딩이 될 것입니다.</span>
										</p>
										</div>
									</li>
									<li>
										<label><i class="fas fa-medal color-8 fs--1"></i> 레슨희망일시</label>
										<div class="d-table-cell">
											<select class="form-control mb-1" size="1" id="" name="">
												<option value="">--월 선택--</option>
												<option value="">1월</option>
												<option value="">12월</option>
											</select>
											<select class="form-control mb-1" size="1" id="" name="">
												<option value="">--날짜 선택--</option>
												<option value="">1일</option>
												<option value="">30일</option>
											</select>
											<select class="form-control mb-1" size="1" id="" name="">
												<option value="">--시간 선택--</option>
												<option value="">01시</option>
												<option value="">24시</option>
											</select>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</article>
					<!--//상품정보-->

					<!--결제-->
					<div class="mt-2">
						<a href="lesson_payment.php" class="btn-block btn btn-primary mb-3 fs-0">레슨신청/결제</a>
					</div>
					<!--//결제-->

				</div>
			</div>
		</div>
	</section>



	<? include "./inc_Bottom_lesson.php"; ?>
</body>

<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>

</html>