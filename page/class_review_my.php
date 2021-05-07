<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<body>
	<? include "./inc_Top.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					<!--tab-->
					<div id="tab-menu" class="clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0"><a href="class_contents.php" title="레슨목록">레슨목록</a></li>
							<li class="col p-0"><a href="class_artist.php" title="코치소개">코치소개</a></li>
							<li class="col p-0 active"><a href="class_review.php" title="레슨후기">레슨후기</a></li>
							<li class="col p-0"><a href="class_my" title="나의레슨">나의레슨</a></li>
						</ul>
					</div>
					<!--tab-->

					<!--글목록-->
					<article class="p-3 mt-5 mb-2 position-r">
						
						<!-- 내가 작성한 리뷰 목록 시작 -->
						<div class="dropdown position-ab btn-right-top">
							<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="javascript:go_modify_page('<?=$row['pk_page_article']?>');" title="글 수정">글 수정</a>
								<a class="dropdown-item" href="javascript:go_delete_page('<?=$row['pk_page_article']?>');" title="글 삭제">글 삭제</a>
							</div>
						</div>

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

						<!-- 레슨/코치 정보 -->
						<div class="list-tour tour-wide mt-2 mb-3">
							<ul>
								<li>
									<div class="con-info">
									 <h4 class="tlt mt-1 ml-1">대니김 프로</span> <button class="btn-right btn btn-outline-secondary btn-sm ml-1 btn-capsule" type="button" onClick="top.location.href='코치홈페이지 링크'"><i class="fas fa-user"></i> 레슨보기</button></h4>
										 <dl class="txt-info d-flex ml-2">
											 <span>
											 <i class="fas fa-edit opacity-50"></i> 아리아 CC. 필드레슨/1일 18홀<br>
											 <i class="fas fa-medal opacity-50"></i> 온라인/영상 레슨</span>
										 </dl>
									 </div>
								</li>
							</ul>
						</div>
						<!--// 레슨/코치 정보 끝-->

							<!--작성글-->
							<a href="class_review_read.php" title="" class="clearfix">
							<div class="page-write">
								<p class="post">정말 친절하고, 정확하게 잘 코칭해주셔서 감사드립니다 .다음기회에 다시 레슨 받았으면 하네요. 감사합니다.</p>
							</div>
							<!--//작성글>

							<!--사진-->
							<div class="list-card my-3">
								<ul class="card-columns">
									<li class="card border-none">
										<img class="card-img img-fluid" src="assets/images/ex_img4.jpg" alt="" />
									</li>
									<li class="card border-none">
										<img class="card-img img-fluid" src="assets/images/ex_img5.jpg" alt="" />
									</li>
									<li class="card border-none">
										<img class="card-img img-fluid" src="assets/images/ex_img6.jpg" alt="" />
									</li>
								</ul>
							</div>
							</a>
							<!--//사진-->

							<!--버튼-->
							<div class="page-box text-center mb-3">
								<div class="row m-0">
									<div class="col p-0 ">
										<div class="checkbox">
											<input id="chk1" name="chk_good" type="checkbox" class="invisible">
											<label for="chk1" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary">100</span></label>
										</div>
									</div>
									<div class="col p-0">
										<a href="class_review_read.php"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary">10</span></a>
									</div>
									<!-- <div class="col p-0">
										<a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>
									</div> -->
								</div>
							</div>
							<!--//버튼-->
					</article>
					<!-- //레슨 리스팅 끝 -->

					
					<!--//리뷰 반복 끝-->
					
					<? include "./inc_Bottom_lesson.php"; ?>
				</div>
			</div>
		</div>
	</section>
</body>

<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>