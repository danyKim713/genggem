<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Program.php"; ?>
<? include "./inc_Head.php"; ?>

<script>
$(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_page_board();
			}
		});
	});

	var pageNo = 1;

	$(function(){
		go_list_page_board();
	});

	function go_list_page_board(){
		$.ajax({
			type: 'POST',
			url: "_ajax_page_list_board.php",
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
</script>

<body>

<!-- 페이지 친구들의 모든 글을 리스팅 합니다 // 스크롤 다운 방식 -->
<? include "./inc_Top.php"; ?>
	<section class="py-0">
		<div class="container-fluid mt-5">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-8 col-xl-8 p-0">
					<!--글쓰기-->
					<article class="my-2">
						<div class="px-3 py-2 d-flex align-items-center position-r">
							<img src="assets/images/user_img.jpg" width="35" height="35" class="rounded-circle">
							<div class="w-100 ">
								<a href="page_write.php" title="글 작성하기" class="p-2 color-8 fs-005">회원님의 페이지에 글을 남겨 주세요</a>
								<button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-1" type="button" onClick="location.href='page_write.php'"><i class="fas fa-image"></i> 사진</button>
							</div>
						</div>
					</article>
					<!--//글쓰기-->
					<!--게시글-->
					<div class="mb-2">
						<div class="list list-page">
						<article class="p-3 mb-2">
							<ul id="page-list">
<?/**
								<li>
									<div class="dropdown position-ab btn-right-top">
										<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="javascript:void(0)" title="신고하기">신고하기</a>
										</div>
									</div>
									<a href="page_boardview.php" title="" class="clearfix">
										<!-- 작성자 정보-->
										<div class="d-flex align-items-end mb-3">
											<div class="page-profile">
												<img src="assets/images/user_img.jpg" width="40" height="40" class="rounded-circle">
											</div>
											<div class="col page-write lh-3">
											  <h3 class="fs-005 mb-0">홍길동</h3>
												<span class="date fs--1">2019.10.08 15:28</span>
											</div>
										</div>
										<!-- //작성자 정보-->
										<!--작성글 및 태그-->
										<div class="page-write">
											<p class="post">게시글 내용예시 게시글 내용예시 게시글 내용예시 게시글 내용예시 게시글 내용예시</p>
											<div class="fs-005 mt-1 color-6">
												<span class="mr-2">#태그1</span><span class="mr-2">#태그2</span><span class="mr-2">#태그3</span>
											</div>
										</div>
										<!--//작성글 및 태그-->
										<!--사진-->
										<div class="list-card my-3">
											<ul class="card-columns">
												<li class="card border-none">
													<img class="card-img img-fluid" src="assets/images/ex_img7.jpg" alt="" />
												</li>
												<li class="card border-none">
													<img class="card-img img-fluid" src="assets/images/ex_img7.jpg" alt="" />
												</li>
												<li class="card border-none">
													<img class="card-img img-fluid" src="assets/images/ex_img7.jpg" alt="" />
												</li>
											</ul>
										</div>
										<!--//사진-->
										<!--버튼-->
										</a>
										<div class="page-box text-center">
											<div class="row m-0">
												<div class="col p-0">
													<div class="checkbox">
														<input id="chk1" name="chk_good" type="checkbox" class="invisible">
														<label for="chk1" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary">100</span></label>
													</div>
												</div>
												<div class="col p-0">
													<a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary">10</span></a>
												</div>
												<div class="col p-0">
													<a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>
												</div>
											</div>
										</div>
										<!--//버튼-->
								</li>
								
**/?>
							</ul>
						</article>
						</div>
					</div>
					<!--//게시글-->
				</div>
			</div>
		</div>
	</section>



	<? include "./inc_Bottom_page.php"; ?>
</body>
<script>
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="board"]').addClass('active');
</script>

</html>