<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<body>
<? include "./inc_Top.php"; ?>
	<section>
		<div class="container header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0 mt-5">
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">인기 페이지</h3>
						<div class="list list-default mt-3">
							<ul>
								<li>
									<a href="친구추가.php" title="">
										<div>
											<img src="assets/images/ex_img6.jpg" width="100" height="100" class="radius-5" />
										</div>
										<div class="con-info">
											<h4 class="fs-0 ellipsis"><i class="fas fa-crown align-text-top fs--1 color-warning mt-1"></i> 골프삼국지 <span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 팔로워 20,501</span></h4>
											<p class="color-5">골프입문부터 프로가 되기까지. 골프레슨의 모든것! 골프삼국지.레슨...</p>
											<span class="color-6 fs--1"><a href="친구해제"><button type="button" class="btn btn-primary btn-sm btn-capsule mr-2"><i class="fas fa-check fs--1 opacity-5"></i> 친구</button></a></span>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" title="">
										<div>
											<img src="assets/images/ex_img3.jpg" width="100" class="radius-5"/>
										</div>
										<div class="con-info">
											<h4 class="fs-0 ellipsis">페이지명</h4>
											<p class="color-5">페이지 설명 페이지 설명 페이지 설명 페이지 설명 페이지 설명 페이지 설명 페이지 설명페이지 설명</p>
											<button type="button" class="btn btn-outline-primary btn-sm btn-capsule mr-2">+ 팔로우</button>
											<span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 팔로워 20,501</span>
										</div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" title="">
										<div>
											<img src="assets/images/ex_img3.jpg" width="100" class="radius-5"/>
										</div>
										<div class="con-info">
											<h4 class="fs-0 ellipsis">페이지명</h4>
											<p class="color-5">페이지 설명 페이지 설명 페이지 설명 페이지 설명 페이지 설명 페이지 설명 페이지 설명페이지 설명</p>
											<button type="button" class="btn btn-outline-primary btn-sm btn-capsule mr-2">+ 팔로우</button>
											<span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 팔로워 20,501</span>
										</div>
									</a>
								</li>
								<li>
									<!-- 인기페이지 상위 100개 리스팅 : 팔로워 수 기준 -->
							</ul>
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