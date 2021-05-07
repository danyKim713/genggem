<? 
	$NO_LOGIN = "Y";
	include "./inc_program.php";   
?><!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<body class="mb-6">
	<? include "./inc_nav.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					<!--tab--
					<div id="tab-menu" class="clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0 active"><a href="watch.php" title="정보">국내골프장</a></li>
							<li class="col p-0"><a href="watch_my.php" title="게시판">해외골프장</a></li>
							<li class="col p-0"><a href="watch_upload.php" title="갤러리">연습장</a></li>
							<li class="col p-0"><a href="lesson.php" title="채팅">골프샵</a></li>
							<li class="col p-0"><a href="lesson.php" title="채팅">기타제휴점</a></li>
						</ul>
					</div>
					<!--tab-->
	
					<!--영상 주제별찾기-->
					<article class="mb-2">
						<div class="p-3">
							<h2 class="main-tlt display-inline">제휴점 주제별 찾기</h2>
							<a href="watch_upload.php" title="제휴점등록" class="float-right color-6 fs-005">
								<button type="button" class="float-right btn btn-outline-primary btn-sm radius-5"><i class="fas fa-calendar-plus opacity-75"></i> 제휴점등록</button>
							</a>
						</div>
						<div class="list-category">
							<ul class="row text-center">
								<li class='col-3'>
									<a href='franchise_list.php' title='초보레슨'>
										<img src="assets/images/icon/WH01.png" width="60" alt="초보레슨">
										<span class="d-block py-1">국내골프장</span>
									</a>
								</li>
								<li class='col-3'>
									<a href='franchise_list.php' title='골프클럽'>
										<img src="assets/images/icon/WH02.png" width="60" alt="골프클럽">
										<span class="d-block py-1">해외골프장</span>
									</a>
								</li>
								<li class='col-3'>
									<a href='franchise_list.php' title='스윙'>
										<img src="assets/images/icon/WH03.png" width="60" alt="스윙">
										<span class="d-block py-1">실내연습장</span>
									</a>
								</li>
								<li class='col-3'>
									<a href='franchise_list.php' title='Fun'>
										<img src="assets/images/icon/WH04.png" width="60" alt="Fun">
										<span class="d-block py-1">실외연습장</span>
									</a>
								</li>								
								<li class='col-3'>
									<a href='franchise_list.php' title='국내골프장'>
										<img src="assets/images/icon/WH05.png" width="60" alt="국내골프장">
										<span class="d-block py-1">골프샵</span>
									</a>
								</li>
								<li class='col-3'>
									<a href='franchise_list.php' title='해외골프장'>
										<img src="assets/images/icon/WH06.png" width="60" alt="해외골프장">
										<span class="d-block py-1">여행</span>
									</a>
								</li>
								<li class='col-3'>
									<a href='franchise_list.php' title='국내선수'>
										<img src="assets/images/icon/WH07.png" width="60" alt="국내선수">
										<span class="d-block py-1">맛집/식당</span>
									</a>
								</li>
								<li class='col-3'>
									<a href='franchise_list.php' title='해외선수'>
										<img src="assets/images/icon/WH08.png" width="60" alt="해외선수">
										<span class="d-block py-1">음료/주류</span>
									</a>
								</li>
							</ul>
						</div>
					</article>
					<!--//영상 주제별찾기-->
					<!--영상 검색-->
					<article class="mb-2">
						<div class="p-3 position-r">
							<div class="w-75">
								<input class="form-control" id="페이지검색" name="페이지검색" type="search" placeholder="제휴점을 검색해 보세요." />
								<a href="watch_search.php"><button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-3 mb-1" type="button">검색</button></a>
							</div>
						</div>
					</article>
					<!--//영상 검색-->
					<!--맞춤 영상-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">추천제휴점</h3>
						<div class="list-video list-even mt-3">
							<ul class="d-flex flex-wrap">
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/ex_store6.jpg"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 남수원골프장</h4>
											<p class="color-5 ellipsis-2">회원제 골프장 / 정회원(현역/예비역) 30,000원...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>320.129회</span>
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/ex_store4.jpg"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 가평파크골프장</h4>
											<p class="color-5 ellipsis-2">퍼블릭 골프장. 경기도 가평군 청평면 대성리 388-13...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>20.154회</span>
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/ex_store.jpg"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 스타벅스청담점</h4>
											<p class="color-5 ellipsis-2">라운딩 후 편안히 즐기는 여유로운 커피한잔 첨담 스타벅스...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>30.129회</span>
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/ex_store5.jpg"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 성저파크골프장</h4>
											<p class="color-5 ellipsis-2">실내 스크린 연습장 구비~!! 실력향상은 덤~...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>20.014회</span>
										</div>
									</a>
								</li>
							</ul>
						</div>
					</article>
					
					<!--//맞춤 영상-->


					<!--추천 영상 : 구독중인 영상채널 6개, 최근시청한 영상4개 리스팅 //랜덤-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">신규제휴점</h3>
						<a href="watch_best.php" title="모두보기" class="float-right color-6 fs-005">더보기 <span class="icon ic-right-arrow fs--1"></span> </a>
						<div class="list list-default mt-3">
							<ul>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p1.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 이기호 프로</h4>
											<p class="color-5">[골프레슨] 초보. 힘빼고 멀리치는 방법영상...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>9,129회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 121명</span>	
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p2.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 빅보이</h4>
											<p class="color-5">배틀존에서 한판 붙자!!!! 심짱님과 하기원프로님을 모시고 3:3 팀플도전해봤습니다!!!!...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>20,124회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 521명</span>	
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p3.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 임진한 프로</h4>
											<p class="color-5">이것 하나면 드라이버가 똑바로 멀리 | 명품스윙 에이미 조...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>320.129회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 1,321명</span>	
										</div>
									</a>
								</li>
							</ul>
						</div>
					</article>
					<!--//인기 영상-->

					<!--신규 영상 :: 50개 리스팅-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">제휴점 목록</h3>
						<!-- <a href="channel_list.php" title="모두보기" class="float-right color-6 fs-005">전체영상보기 <span class="icon ic-right-arrow fs--1"></span> </a> -->
						<div class="list list-default mt-3">
							<ul>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p4.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> M club golf</h4>
											<p class="color-5">[왕초보골프입문] 골프그립 잡는법! 이해 하면서 느낌적으로 잡아보아요....</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>29회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 2명</span>	
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p5.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 골프란?</h4>
											<p class="color-5">똑바로 멀리치려면? 백스윙 하는법 몸통회전 왼팔펴기 골프스윙동영상 인투인 스윙궤도 배치기...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>5,125회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 215명</span>	
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p6.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> SBS Golf</h4>
											<p class="color-5">일관성이 없는 드라이버샷, 문제는 다운스윙 시 팔의 위치?...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>12,259회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 3,621명</span>	
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p7.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 쌈짱골프</h4>
											<p class="color-5">어메이징 골프샷 모음! 심짱의 골프라운드에서 나온 최고 골프샷 모음 [amazing golf shots]...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>129회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 21명</span>	
										</div>
									</a>
								</li>
								<li>
									<a href="partner_view.php" title="">
										<div>
											<img src="assets/images/wh_p8.jpg" width="150" height="84" />
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> 최남매골프</h4>
											<p class="color-5">가을하늘 아래 미녀골퍼들의 골프!? ※눈호강주의 (최나연프로,최예지프로,정서빈프로)...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>120회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 2명</span>	
										</div>
									</a>
								</li>
							</ul>
						</div>
					</article>
					<!--//신규 영상-->
					

				
					
					<? include "./inc_Bottom_partner.php"; ?>
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
	$('.nav_category li[data-name="gnb-partner"]').addClass('active');
	$('.nav_bottom li[data-name="watchhome"]').addClass('active');
</script>
</html>