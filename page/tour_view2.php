<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<link href="assets/lib/lightbox2/dist/css/lightbox.min.css" rel="stylesheet">
<script src="assets/lib/lightbox2/dist/js/lightbox.min.js"></script>
<?
	$rowS = db_select("select * from tbl_store where store_id='$store_id'");
?>
<?
$_TITLE = $rowS['store_name'];
?>
	<body>
		<? include "./inc_Top.php"; ?>
		
			<section class="wrap-store py-0">
				<div class="container header-top">
					<div class="row align-items-center justify-content-center">
						<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
							<!--사진-->
							<article>
								<ul class="slider slider-banner pl-0 no-style">
									<li>
										<a href="javascript:void(0)" title="1">
											<img src="assets/images/ex_img13.jpg" width="100%" height="100%" />
										</a>
									</li>
								</ul>
							</article>

							<!--정보-->
							<article>
								<div class="tabs">
									<div class="nav-bar nav-bar-center">
										<div class="nav-bar-item active">투어정보</div>
										<div class="nav-bar-item">일정</div>
										<div class="nav-bar-item">후기</div>
										<div class="nav-bar-item">투어신청</div>
									</div>

									<div class="tab-content active">
											<div class="p-3">
												<h2 class="fs-0 mt-1">투어상품명</h2>
												
												<div class="info-item mt-2">
													<strong>주소</strong>
													<p><?=$rowS['store_addr']?> <?=$rowS['store_addr_detail']?></p>
												</div>
												<div class="info-item">
												  <strong>영업시간</strong>
												  <p><?=$rowS['offday_info']?></p>
												</div>
												<div class="info-item">
												  <strong>주차정보</strong>
												  <p><?=$rowS['parking_info']?></p>
												</div>
												<div class="box-qr my-3 text-center">
													<p class="color-4 mb-0 mt-2 fs-005">투어상품명</p>
													ㅇㅇㅇ
													<p class="color-4 mb-0 mt-2 fs-005">제휴점 UID : S12345678</p>
												</div>												
												<div class="my-3" id="daum_map" style="height: 300px;"></div>
												<!--//구글맵-->
											</div>
										</div>

									<div class="tab-contents">
										<div class="tab-content">
											<div class="list list-three">
												<ul class="row m-0">
													<li class='mb-3'>
													  <div class='con-img' data-lightbox="review">
															<a href="<?=phpThumb("/_UPLOAD/".$rowMenu['store_menu_image'],300,226,"2","assets/images/store3.jpg")?>" data-lightbox="menu">
															<img src="assets/images/store3.jpg" alt='' />
															</a>
													  </div>
													  <div class='con-info text-center mt-2'>
														<p class='mb-1 fs-005'>
														  <?=$rowMenu['store_menu_name']?>
														</p>
														<p class='mb-0 fw-600'>
														  <?=number_format($rowMenu['store_menu_price'])?></p>
													  </div>
													</li>
												</ul>
											</div>
										</div>


										<div class="tab-content">
											<div class="p-3">
												<a href="franchise_review_edit.php?store_id=<?=$store_id?>" title="Post Review" class="fs-005 btn btn-block btn-outline-secondary">이용후기작성</a>
											</div>
											<div class="wrap-review p-3">
												<ul>

												<?
												$resultReview = db_query("select * from tbl_store_review where store_id='".$store_id."' order by regdate DESC LIMIT 0,1000");

												while($rowReview = db_fetch($resultReview)){
													$rowMem = db_select("select * from tbl_member where member_id='".$rowReview['member_id']."'");
												?>

													<li>
														<div class="review-info">
															<div class="user-profile"><img src="<?=phpThumb(" /_UPLOAD/ ".$rowMem['photo'], 38, 38, 2, "assets/images/user.svg ")?>" alt="나의 프로필 사진"></div>
															<div class="review-user-info position-r">
																<p class="mb-0 fs-005"><?=$rowMem['name']?$rowMem['name']:"User Name"?><small class="text-muted float-right"><?=date("Y-m-d",strtotime($rowReview['regdate']))?></small></p>
																<div class="rating-stars fs--1">
																	<div id="rating-<?=$rowReview['review_id']?>"></div>

																	<script>
																	  options_<?=$rowReview['review_id']?> = {
																		max_value: 5,
																		step_size: 0.5,
																		initial_value: <?=$rowReview['star_rate']?>
																	  };
																	  $(function() {
																		$("#rating-<?=$rowReview['review_id']?>").rate(options_<?=$rowReview['review_id']?>);
																	  });

																	</script>

																	<style type="text/css">
																	  .rate-select-layer span {
																		color: #f0ad4e;
																	  }

																	</style>
																	</div>
																	<? if($rowMember['member_id']==$rowReview['member_id']){?>
																	<a href="javascript:go_delete_review('<?=$rowReview['review_id']?>');" alt="delete" class="btn btn-outline-gray btn-xs btn-edit radius-2"><?=$dic['Delete']?></a>
																	<?}?>
																</div>
															</div>
															<div class="review-photo list list-three mt-3">
																<ul class="row no-style px-3">
																  <? if($rowReview['img1']){?>
																	<li>
																	  <a href="/_UPLOAD/<?=$rowReview['img1']?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img1'], 102, 106, 2, "")?>" style="border:none"></a>
																	</li>
																	<?}?>
																	<? if($rowReview['img2']){?>
																	<li>
																	  <a href="/_UPLOAD/<?=$rowReview['img2']?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img2'], 102, 106, 2, "")?>" style="border:none"></a>
																	</li>
																	<?}?>
																	<? if($rowReview['img3']){?>
																	<li>
																	  <a href="/_UPLOAD/<?=$rowReview['img3']?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img3'], 102, 106, 2, "")?>" style="border:none"></a>
																	</li>
																	<?}?>
																</ul>
																<p class="mt-3 color-2 fs-005">
																  <?=nl2br($rowReview['review_content'])?>
																</p>
															</div>
														</li>
													<?}?>

												</ul>
											</div>
										</div>



										<div class="tab-content">
											<div class="p-3">
												<a href="franchise_review.php" title="Post Review" class="fs-005 btn btn-block btn-outline-info">Post Review</a>
											</div>
											<div class="wrap-review p-3">
												<ul>
													<li>
														<div class="review-info">
															<div class="user-profile float-left">
																<img src="assets/images/user.svg" alt="나의 프로필 사진">
															</div>
															<div class="review-user-info position-r">
																<p class="mb-0 fs-005">
																	user name
																	<small class="text-muted float-right">2019-01-04</small>
																</p>
																<div class="rating-stars fs--1">
																	<ul id="stars" class="row ml-0">
																		<li class="star active" data-value="1">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star active" data-value="2">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star active" data-value="3">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star active" data-value="4">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star" data-value="5">
																			<i class="fas fa-star"></i>
																		</li>
																	</ul>
																</div>
															</div>
														</div>
														<div class="review-photo list list-three mt-3">
															<ul class="row px-3">
																<li>
																	<a href="assets/images/place-img.jpg" data-lightbox="roadtrip"><img src="assets/images/place-img.jpg" alt=""></a>
																</li>
																<li>
																	<a href="assets/images/place-img.jpg" data-lightbox="roadtrip"><img src="assets/images/place-img.jpg" alt=""></a>
																</li>
																<li>
																	<a href="assets/images/place-img.jpg" data-lightbox="roadtrip"><img src="assets/images/place-img.jpg" alt=""></a>
																</li>
															</ul>
															<p class="mt-3 color-2 fs-005">리뷰 코멘트 남기고 보여집니다.대박삼 겹살 맛있어요. 코멘트 리스팅은 없습니다. 작성된 글 수만큼 보여지도록 합니다.리뷰 코멘트 남기고 보여집니다.대박삼 겹살 맛있어요. 코멘트 리스팅은 없습니다. 작성된 글 수만큼 보여지도록 합니다.</p>
														</div>
													</li>
													<li>
														<div class="review-info">
															<div class="user-profile float-left">
																<img src="assets/images/user.svg" alt="나의 프로필 사진">
															</div>
															<div class="review-user-info position-r">
																<p class="mb-0 fs-005">
																	user name
																	<small class="text-muted float-right">2019-01-04</small>
																</p>
																<div class="rating-stars fs--1">
																	<ul id="stars" class="row ml-0">
																		<li class="star active" data-value="1">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star active" data-value="2">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star active" data-value="3">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star active" data-value="4">
																			<i class="fas fa-star"></i>
																		</li>
																		<li class="star" data-value="5">
																			<i class="fas fa-star"></i>
																		</li>
																	</ul>
																</div>
																<a href="javascript:void(0)" alt="delete" class="btn btn-outline-gray btn-xs btn-edit radius-2">Delete</a>
															</div>
														</div>
														<div class="review-photo list list-three mt-3">
															<ul class="row px-3">
																<li>
																	<a href="assets/images/place-img.jpg" data-lightbox="roadtrip"><img src="assets/images/place-img.jpg" alt=""></a>
																</li>
																<li>
																	<a href="assets/images/place-img.jpg" data-lightbox="roadtrip"><img src="assets/images/place-img.jpg" alt=""></a>
																</li>
																<li>
																	<a href="assets/images/place-img.jpg" data-lightbox="roadtrip"><img src="assets/images/place-img.jpg" alt=""></a>
																</li>
															</ul>
															<p class="mt-3 color-2 fs-005">리뷰 코멘트 남기고 보여집니다.대박삼 겹살 맛있어요. 코멘트 리스팅은 없습니다. 작성된 글 수만큼 보여지도록 합니다.리뷰 코멘트 남기고 보여집니다.대박삼 겹살 맛있어요. 코멘트 리스팅은 없습니다. 작성된 글 수만큼 보여지도록 합니다.</p>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</article>
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
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true
		})

		function go_delete_review(review_id) {
        if (confirm('리뷰를 정말로 삭제하시겠습니까?')) {
          _fra.location.href = "review_delete_action.php?review_id=" + review_id;
        }
      }
	</script>
<script>
	$('.nav_category li[data-name="gnb-tour"]').addClass('active');
	$('.nav_bottom li[data-name="tour"]').addClass('active');
</script>
<?
include "_kakao_map.php";
?>
</html>