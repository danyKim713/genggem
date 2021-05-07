<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<body>

<!-- 내 페이지 모든 글과 친구들의 모든 게시글들을 보여 줍니다. 무한 스클롤 -->

<header class="header top_fixed">
	<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
	<h2 class="header-title text-center">레슨후기 글읽기</h2>
</header>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<!--게시글-->
					<article class="p-3 mb-2 position-r">
							<div class="dropdown position-ab btn-right-top">
								<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="javascript:void(0)" title="글 수정">글 수정</a>
									<a class="dropdown-item" href="javascript:void(0)" title="글 수정">글 삭제</a>
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
										 <h4 class="tlt mt-1 ml-1">대니김 프로</span> <button class="btn-right btn btn-outline-secondary btn-sm ml-1" type="button" onClick="top.location.href='coach/UID.php'"><i class="fas fa-image"></i> 레슨보기</button></h4>
										 <dl class="txt-info d-flex ml-2">
											 <span><i class="fas fa-edit opacity-50"></i> 아리아 CC. 필드레슨/1일 18홀<br>
											 <i class="fas fa-medal opacity-50"></i> 온라인/영상 레슨</span>
										 </dl>
									 </div>
								</li>
							</div>
							<!--// 레슨/코치 정보 끝-->

							<!--작성글 및 태그-->
							<div class="page-write">
								<p class="post">게시글 내용예시 게시글 내용예시 게시글 내용예시 게시글 내용예시 게시글 내용예시. 후기 작성글 전체 내용 보여줍니다
								아주 만족합니다. 다음기회에 다시 레슨 받고 싶어요. 
								언제 라운딩 같이 했으면 하는 소원입니다. ㅎㅎ</p>
							</div>
							<!--//작성글 및 태그-->
								<!--사진-->
								<div class="list-card my-3">
									<ul class="card-columns">
										<li class="card border-none">
											<img class="card-img img-fluid" src="assets/images/ex_img7.jpg" alt="" />
										</li>
										<li class="card border-none">
											<img class="card-img img-fluid" src="assets/images/ex_img6.jpg" alt="" />
										</li>
										<li class="card border-none">
											<img class="card-img img-fluid" src="assets/images/ex_img8.jpg" alt="" />
										</li>
									</ul>
								</div>
								<!--//사진-->
								<!--버튼-->
								<div class="page-box text-center">
									<div class="row m-0">
										<div class="col p-0 ">
											<div class="checkbox">
												<input id="chk1" name="chk_good" type="checkbox" class="invisible">
												<label for="chk1" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary">100</span></label>
											</div>
										</div>
										<div class="col p-0">
											<a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary">10</span></a>
										</div>
										<!-- <div class="col p-0">
											<a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>
										</div> -->
									</div>
								</div>
								<!--//버튼-->
					</article>
					<!--//게시글-->
					<!--댓글-->
					<article class="p-3 mb-1">
						<h2 class="main-tlt display-inline">댓글 <span class="color-primary">6</span></h2>
						<div class="list-comment mt-3">
							<ul>
								<li>
									<div class="d-flex align-items-start position-r">
										<div class="page-profile">
											<img src="assets/images/user_img.jpg" width="40" height="40" class="rounded-circle">
										</div>
										<div class="page-write col lh-3 pr-0">
											<h5 class="fs-005 mb-0">댓글작성자 닉네임</h5>
											<p class="post fs-005 fw-300 mb-2">댓글내용은 댓글내용 댓글내용은 댓글내용댓글내용은 댓글내용댓글내용은 댓글내용
											댓글내용은 댓글내용
											댓글내용은 댓글내용
											</p>
											<div class="d-flex lh-2">
												<div class="checkbox check-primary">
													<input id="chk2" name="chk_good" type="checkbox" class="invisible">
													<label for="chk2" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 12</label>
												</div>
												<!-- <span class="px-1">·</span>
												<button type="button" class="btn-reply btn btn-transparent color-primary p-0">답글달기</button> -->
											</div>
											<!--답글입력창-->
											<div class="con-reply">
												<div class="d-flex mt-3">
													<textarea class="form-control" placeholder="답글 내용을 입력해주세요" rows="2"></textarea>
													<button type="button" class="btn btn-outline-secondary col-3 px-3">확인</button>
												</div>
											</div>
											<!--//답글입력창-->
										
											<!--답글-
											<div class="list-reply">
												<ul>
													<li>
														<div class="d-flex align-items-start position-r">
															<div class="page-profile">
																<img src="assets/images/user_img.jpg" width="30" height="30" class="rounded-circle">
															</div>
															<div class="col lh-3 pr-0">
																<h5 class="fs-005 mb-1">답글작성자 닉네임</h5>
																<p class="fs-005 fw-300">답글내d용</p>
															</div>
														</div>
													</li>
													<li>
														<div class="d-flex align-items-start position-r">
															<div class="page-profile">
																<img src="assets/images/user_img.jpg" width="30" height="30" class="rounded-circle">
															</div>
															<div class="col lh-3 pr-0">
																<h5 class="fs-005 mb-1">답글작성자 닉네임</h5>
																<p class="fs-005 fw-300">답글내용답글내용답글내용답글내용답글내용답글내용답글내용</p>
															</div>
														</div>
													</li>
												</ul>
											</div>
											<!--//답글-->
										</div>
										<p class="date position-ab mb-0 fs--1">3분전</p>
									</div>
								</li>
								<li>
									<div class="d-flex align-items-start position-r">
										<div class="page-profile">
											<img src="assets/images/user_img.jpg" width="40" height="40" class="rounded-circle">
										</div>
										<div class="page-write col lh-3 pr-0">
											<h5 class="fs-005 mb-0">댓글작성자 닉네임</h5>
											<p class="post fs-005 fw-300 mb-2">댓글내용은 댓글내용 댓글내용은 댓글내용댓글내용은 댓글내용댓글내용은 댓글내용
											댓글내용은 댓글내용
											댓글내용은 댓글내용
											</p>
											<div class="d-flex lh-2">
												<div class="checkbox check-primary">
													<input id="chk3" name="chk_good" type="checkbox" class="invisible">
													<label for="chk3" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 12</label>
												</div>
												<!-- <span class="px-1">·</span>
												<button type="button" class="btn-reply btn btn-transparent color-primary p-0">답글달기</button> -->
											</div>
											<!--답글입력창-->
											<div class="con-reply">
												<div class="d-flex mt-3">
													<textarea class="form-control" placeholder="답글 내용을 입력해주세요" rows="2"></textarea>
													<button type="button" class="btn btn-outline-secondary col-3 px-3">확인</button>
												</div>
											</div>
											<!--//답글입력창-->
										</div>
										<p class="date position-ab mb-0 fs--1">10일전</p>
									</div>
								</li>
															</ul>
						</div>
					</article>
					<!--//댓글-->
					
					<!--댓글입력창-->
					<div class="con-comment-input col-sm-10 col-lg-6 col-xl-4 p-0">
						<div class="d-flex">
							<textarea class="form-control" placeholder="댓글 내용을 입력해주세요" rows="2"></textarea>
							<button type="button" class="btn btn-primary col-3 px-3">확인</button>
						</div>
					</div>
					<!--//댓글입력창-->
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	$(document).ready(function(){
		$('.btn-reply').on("click",function(){
			$(this).parent('div').next().toggleClass("active");
			console.log('text');
		});
	});
</script>
</html>