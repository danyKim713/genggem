<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<body class="mb-6">
	<? include "./inc_nav.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
				<!--date-->
				<div class="con-datelist mb-1">
					<ul>
						<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">월</div>
								<div class="day-number">01</div>
							</a>
						</li>
							<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">화</div>
								<div class="day-number">02</div>
							</a>
						</li>
							<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">수</div>
								<div class="day-number">03</div>
							</a>
						</li>
							<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">목</div>
								<div class="day-number">04</div>
							</a>
						</li>
							<li class="active">
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">금</div>
								<div class="day-number">05</div>
							</a>
						</li>
						<li class="sat">
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">토</div>
								<div class="day-number">06</div>
							</a>
						</li>
						<li class="sun">
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">일</div>
								<div class="day-number">07</div>
							</a>
						</li>
							<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">월</div>
								<div class="day-number">08</div>
							</a>
						</li>
							<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">화</div>
								<div class="day-number">09</div>
							</a>
						</li>
							<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">수</div>
								<div class="day-number">10</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">목</div>
								<div class="day-number">11</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">금</div>
								<div class="day-number">12</div>
							</a>
						</li>
						<li class="sat">
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">토</div>
								<div class="day-number">13</div>
							</a>
						</li>
						<li class="sun">
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">일</div>
								<div class="day-number">14</div>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" title="페이지 바로가기">
								<div class="day-name">월</div>
								<div class="day-number">15</div>
							</a>
						</li>
					</ul>
				</div>
				<!--//date-->
				<!--banner-->
					<article class="mb-2">
						<ul class="slider slider-banner">
							<li>
								<a href="javascript:void(0)" title="">
									<img src="assets/images/ex_img12.jpg" />
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="">
									<img src="assets/images/ex_img13.jpg" />
								</a>
							</li>
						</ul>
					</article>
					<!--//banner-->
					
					<!--list // 위 날짜를 선택하면 선택 날짜에 가능한 골프장을 보여줌 // 리프레쉬됨 -->
					<!-- 골프장 부킹 리스트 // 고객의 사용패턴에 따른 리스팅 // 위치기반으로 가까운 순 // 고객이 선호하는 설정에 따른 리스팅 // 리스팅 10개-->
					<article class="mb-2">
					<div class="text-center pt-4">
						<h3 class="main-tlt lh-3 fs-05 fw-400">
							고객님을 위한 <strong class="color-primary">추천 상품</strong>
						</h3>
					</div>
					<div class="list-tour tour-multi pt-2 pb-3">
						<ul>
							<li>
								<a href="tour_booking_view.php" title="">
									<div><img src="assets/images/ex_img13.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">레이크사이드</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 용인</dd>
										 <dd>28km</dd>
									 </dl>
									 <span class="txt-price color-primary">59,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="tour_view.php" title="">
									<div><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">Sky72</h4>
									 <dl class="txt-info d-flex">
										 <dd>인천</dd>
										 <dd>45km</dd>
									 </dl>
									 <span class="txt-price color-primary">89,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="tour_view.php" title="">
									<div><img src="assets/images/ex_img14.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">Sky72</h4>
									 <dl class="txt-info d-flex">
										 <dd>인천</dd>
										 <dd>45km</dd>
									 </dl>
									 <span class="txt-price color-primary">89,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="tour_view.php" title="">
									<div><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">Sky72</h4>
									 <dl class="txt-info d-flex">
										 <dd>인천</dd>
										 <dd>45km</dd>
									 </dl>
									 <span class="txt-price color-primary">89,000원~</span>
								 </div>
								</a>
							</li>
						</ul>
					</div>
					</article>

					<!-- <article class="mb-2">
						<div class="py-3 text-center">
						<a href="channel_meet.php?CID=<?=$rowChannel['CID']?>" title="모임모임" class="btn btn-info2 btn-sm radius-5"><i class="fas fa-plus fs--1 opacity-50"></i> 모임개설</a>
						</div>
					</article> -->
					
					<article class="mb-2">
						<div class="text-center pt-4">
							<h3 class="main-tlt lh-3 fs-05 fw-400">
								오늘 올라온 상품
							</h3>
						</div>
						<div class="list-tour tour-single pt-4 pb-3">
							<ul>
							<li>
								<a href="javascript:void(0)" title="">
									<div><img src="assets/images/ex_img13.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">태광</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 용인</dd>
										 <dd>30 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="">
									<div><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">광릉</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 남양주</dd>
										 <dd>35 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="">
									<div><img src="assets/images/ex_img15.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">동유럽4국9일 직항/5-10월 한정상품</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 남양주</dd>
										 <dd>35 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="">
									<div><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">동유럽4국9일 직항/5-10월 한정상품</h4>
									 <dl class="txt-info d-flex">
										  <dd>경기 남양주</dd>
										 <dd>35 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							</ul>
						</div>
					</article>
					
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">인기 투어</h3>
						<a href="channel_list.php" title="모두보기" class="float-right color-6 fs-005">전체보기 <span class="icon ic-right-arrow fs--1"></span> </a>
						<div class="list-tour tour-wide mt-3">
							<ul>
								<li>
								<a href="javascript:void(0)" title="" class="d-flex align-items-center">
									<div class="con-img col-5 p-0"><img src="assets/images/ex_img14.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">태광</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 용인</dd>
										 <dd>30 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="" class="d-flex align-items-center">
									<div class="con-img col-5 p-0"><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">태광</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 용인</dd>
										 <dd>30 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="" class="d-flex align-items-center">
									<div class="con-img col-5 p-0"><img src="assets/images/ex_img15.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">태광</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 용인</dd>
										 <dd>30 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="" class="d-flex align-items-center">
									<div class="con-img col-5 p-0"><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">태광</h4>
									 <dl class="txt-info d-flex">
										 <dd>경기 용인</dd>
										 <dd>30 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							</ul>
						</div>
					</article>
					
										
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">인기 투어</h3>
						<a href="channel_list.php" title="모두보기" class="float-right color-6 fs-005">전체보기 <span class="icon ic-right-arrow fs--1"></span> </a>
						<div class="list-tour list-even mt-3">
							<ul class="d-flex flex-wrap">
								<li>
									<a href="javascript:void(0)" title="">
										<div><img src="assets/images/ex_img15.jpg" alt="상품 이미지"></div>
										<div class="con-info">
										 <h4 class="tlt">태광</h4>
										 <dl class="txt-info d-flex">
											 <dd>경기 용인</dd>
											 <dd>30 km</dd>
										 </dl>
										 <span class="txt-price color-primary">1,590,000원~</span>
									 </div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" title="">
										<div><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
										<div class="con-info">
										 <h4 class="tlt">광릉</h4>
										 <dl class="txt-info d-flex">
											 <dd>경기 남양주</dd>
											 <dd>35 km</dd>
										 </dl>
										 <span class="txt-price color-primary">1,590,000원~</span>
									 </div>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" title="">
										<div><img src="assets/images/ex_img14.jpg" alt="상품 이미지"></div>
										<div class="con-info">
										 <h4 class="tlt">동유럽4국9일 직항/5-10월 한정상품</h4>
										 <dl class="txt-info d-flex">
											 <dd>경기 남양주</dd>
											 <dd>35 km</dd>
										 </dl>
										 <span class="txt-price color-primary">1,590,000원~</span>
									 </div>
									</a>
								</li>
								<li>
								<a href="javascript:void(0)" title="">
									<div><img src="assets/images/ex_img12.jpg" alt="상품 이미지"></div>
									<div class="con-info">
									 <h4 class="tlt">동유럽4국9일 직항/5-10월 한정상품</h4>
									 <dl class="txt-info d-flex">
										  <dd>경기 남양주</dd>
										 <dd>35 km</dd>
									 </dl>
									 <span class="txt-price color-primary">1,590,000원~</span>
								 </div>
								</a>
							</li>
							</ul>
						</div>
					</article>
					
					<!--//list-->
					<? include "./inc_Bottom_tour.php"; ?>
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
	$('.tour-multi ul').slick({
			slidesToShow:2,
			dots: false,
			arrows: false,
			infinite: false,
			centerMode: false
	});
		$('.tour-single ul').slick({
			slidesToShow:1,
			dots: true,
			arrows: false,
			infinite: false,
		 	centerMode: false
	});
	$('.nav_category li[data-name="gnb-tour"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>