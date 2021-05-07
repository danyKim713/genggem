<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";
?>
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
<script type="text/javascript">
function popct(url, w, h) {
popw = (screen.width - w) / 2;
poph = (screen.height - h) / 2;
popft = 'height=' + h + ',width=' + w + ',top=' + poph + ',left=' + popw;
window.open(url, '', popft);
}
</script>

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
	<div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg9.jpg);">
            <h2><?=$rowS['store_name']?></h2>
        </div>
    </div>
    <!-- img Area End -->

	<!-- ##### Area Start ##### -->
    <section class="alazea-blog-area mt-3" style="z-index:997;">       

		<div class="container">
            <div class="row">				
				<div class="col-12 col-md-12">
					<article>
						<div class="tabs">
							<div class="nav-bar nav-bar-center">
								<div class="nav-bar-item"><i class="fa fa-th-list"></i> 메뉴</div>
								<div class="nav-bar-item active"><i class="fa fa-home"></i> 스토어정보</div>
								<div class="nav-bar-item"><i class="fa fa-camera"></i> 리뷰</div>
							</div>

							<!-- store image -->
							<div class="portfolio-slides owl-carousel mb-3 mt-3">
								<!-- Single Portfolio Slide -->
								<?
								$resultImg = db_query("select * from tbl_store_image where store_id='".$store_id."'");

								while($rowImage = db_fetch($resultImg)){
								?>
								<div class="single-portfolio-slide">
									<a href="javascript:void(0)" title="1">
										<img src="<?=phpThumb("/_UPLOAD/".$rowImage['filename'],500,317,"2","assets/images/store1.jpg")?>" width="100%"/>
									</a>
								</div>
								<?}?>
								<? if(mysqli_num_rows($resultImg)==0){?>
								<!-- Single Portfolio Slide -->
								<div class="single-portfolio-slide">
									<img src="./assets/img/bg-img/27.jpg" alt="">
								</div>
								<?}?>

							</div>

							<?/* !--매장사진 // 기존 퍼블 -->
							<article>
								<ul class="slider slider-banner pl-0 no-style">
								<?
								$resultImg = db_query("select * from tbl_store_image where store_id='".$store_id."'");

								while($rowImage = db_fetch($resultImg)){
								?>
									<li>
										<a href="javascript:void(0)" title="1">
											<img src="<?=phpThumb("/_UPLOAD/".$rowImage['filename'],400,213,"2","assets/images/store1.jpg")?>" width="100%"/>
										</a>
									</li>
								<?}?>
								<? if(mysqli_num_rows($resultImg)==0){?>
									<li>
										<a href="javascript:void(0)" title=""><img src="assets/images/store1.jpg" /></a>
									</li>
								<?}?>
								</ul>
							</article>
							<!--가맹점 정보--*/?>

							<div class="tab-contents">
								<div class="tab-content">
									<div class="list list-dthree">
										<div class="col-12 col-md-12">				
											<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
												<div class="section-heading">
													<h2><font color="#0066ff">스토어</font> 메뉴</h2>
												</div>
											</div>

											<div class="row">
											<?php
											$resultMenu = db_query("select * from tbl_store_menu where store_id='".$store_id."'");

											while($rowMenu = db_fetch($resultMenu)){
											?>

												<div class="col-12 col-sm-12 col-lg-3">
													<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
														<!-- Product Image -->
														<div class="post-thumb">
															 <a href="<?=phpThumb("/_UPLOAD/".$rowMenu['store_menu_image'],500,365,"2","assets/images/store3.jpg")?>" data-lightbox="menu">
															<img src='<?=phpThumb("/_UPLOAD/".$rowMenu['store_menu_image'],500,365,"2","assets/images/store3.jpg")?>' alt='' class="radius-5"/>
															</a>
														</div>

														<!-- Product Info -->
														<a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>">
															<div class="product-info mt-15">
																<div class='con-info text-center mt-2'>
															<p class='mb-1 fs-005'>
															  <?=$rowMenu['store_menu_name']?>
															</p>
															<p class='mb-0 fw-600'>
															  <?=number_format($rowMenu['store_menu_price'])?></p>
														  </div>
														</div></a>
													</div>
												</div>
												<?
													}
												?>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-content active">
									<div class="p-2">
										<h2 class="fs-1 mb-2"><?=$rowS['store_name']?> 										
										<? 
										$query = "select count(*) as cnt from tbl_store_favorite where fk_store_id = '{$rowS['store_id']}' and fk_member_id = '{$rowMember['member_id']}'";
										$resultC = db_query($query);
										$rowC = db_fetch($resultC);

										if($rowC['cnt'] == 0){?>
										<button type="button" class="float-right btn btn-info2 btn-sm radius-5"  onClick="go_즐겨찾기_제휴점('<?=$rowS['store_id']?>');"><i class="fas fa-star"></i> 즐겨찾기</button>
										
										<?}else{?>
										<button type="button" class="float-right btn btn-info8 btn-sm radius-5"  onClick="go_즐겨찾기_제휴점_해제('<?=$rowS['store_id']?>');"><i class="fas fa-times"></i> 즐겨찾기 해제</button>
										<?}?>
										
										</h2>
										<div class="box-qr my-3 text-center">
											<p class="color-4 mb-0 mt-1 fs-005 mb-2 fw-400">스토어 QR 코드</p>
											<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?=$rowS['store_code']?>" alt="스토어 QR코드" width="200"/>
											<p class="color-4 mb-0 mt-2 fs-005 fw-400">스토어 UID : <?=$rowS['store_code']?></p>
										</div>

										<!-- 인사말 -->
										<div class="single-post-details-area">
											<div class="post-content">
												<blockquote>
												<div class="page-write">
													<h6 class="fs-005 post"><?=$rowS['store_desc']?>
													</h6>
												</div>
												</blockquote>
											</div>
										</div>



										<div class="single-widget-area user-info">
											<ul class="author-widget user-info-list">
												<li class="lh-8">
													<label><i class="fab fa-font-awesome-flag color-6 fs--1"></i> 주소</label>
													<div class="d-table-cell">
														<span class="fs-005"><?=$rowS['store_addr']?> <?=$rowS['store_addr_detail']?></span>
													</div>
												</li>
												<li class="lh-8">
													<label><i class="fab fa-font-awesome-flag color-6 fs--1"></i> 전화번호</label>
													<div class="d-table-cell">
														<span class="fs-005"><?=$rowS['store_tel']?></span>
													</div>
												</li>
												<li class="lh-8">
													<label><i class="fab fa-font-awesome-flag color-6 fs--1"></i> 결제적립금</label>
													<div class="d-table-cell">
														<span class="fs-005"><?=$rowS['store_saving_rate']?> %</span>
													</div>
												</li>
												<li class="lh-8">
													<label><i class="fab fa-font-awesome-flag color-6 fs--1"></i> 휴일</label>
													<div class="d-table-cell">
														<span class="fs-005"><?=$rowS['offday_info']?></span>
													</div>
												</li>
												<li class="lh-8">
													<label><i class="fab fa-font-awesome-flag color-6 fs--1"></i> 영업시간</label>
													<div class="d-table-cell">
														<span class="fs-005"><?=$rowS['business_hour']?></span>
													</div>
												</li>
												<li class="lh-8">
													<label><i class="fas fa-location-arrow color-6 fs--1"></i> 주차정보</label>
													<div class="d-table-cell">
														<span class="fs-005"><?=$rowS['parking_info']?></span>
													</div>
												</li>
											</ul>
										</div>

										
										<div class="my-3 mb-5" id="daum_map" style="height: 400px;"></div>
										
									</div>
								</div>


								<div class="tab-content">
									<div class="p-1">
										<a href="store_review_edit.php?store_id=<?=$store_id?>" title="Post Review" class="fs-005 btn btn-block btn-success">이용후기작성</a>
									</div>
									<div class="wrap-review p-1">
										<ul>

										<?
										$resultReview = db_query("select * from tbl_store_review where store_id='".$store_id."' order by regdate DESC LIMIT 0,1000");

										while($rowReview = db_fetch($resultReview)){
											$rowMem = db_select("select * from tbl_member where member_id='".$rowReview['member_id']."'");
										?>

											<li>
												<div class="review-info">
													<div class="user-profile"><img src="<?=phpThumb("/_UPLOAD/".($rowMem['페이지프로필사진']?$rowMem['페이지프로필사진']:$rowMem['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="80" height="80" class="rounded-circle"></div>
													<div class="review-user-info position-r">
														<p class="mb-0 fs-005"><?=$rowMem['닉네임']?$rowMem['닉네임']:"User Name"?><small class="text-muted float-right"><?=date("Y-m-d",strtotime($rowReview['regdate']))?></small></p>
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
															<!-- <a href="javascript:go_delete_review('<?=$rowReview['review_id']?>');" alt="delete" class="btn btn-gray btn-xs btn-edit radius-2" style="margin-top:20px;">삭제</a> -->
															<?}?>
														</div>
														<div class="mt-3 color-2 fs--1 fw-400 ml-5">
														<a href="store_review_read.php?review_id=<?=$rowReview['review_id']?>" title="" onClick="popct(this.href, '500', '700');return false" class="clearfix"><?=nl2br($rowReview['review_content'])?><br>
														<button type="button" class="btn-reply btn btn-info9 btn-xs mb-0 fw-400 mt-1"><i class="fa fa-plus-circle"></i> 더보기</button></a>
														</div>
													</div>

													<div class="row mt-3">
														
														<? if($rowReview['img1']){?>
														<div class="col-12 col-sm-6 col-lg-4">
															<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
																<!-- Product Image -->
																<div class="post-thumb">
																	 <a href="<?=phpThumb("/_UPLOAD/".$rowReview['img1'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img1'],500,365,"2","assets/images/p-2.jpg")?>" width="100%" height="365" class="radius-5" /></a>
																</div>
															</div>
														</div>
														<?}?>

														<? if($rowReview['img2']){?>
														<div class="col-12 col-sm-6 col-lg-4">
															<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
																<!-- Product Image -->
																<div class="post-thumb">
																	 <a href="<?=phpThumb("/_UPLOAD/".$rowReview['img2'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img2'],500,365,"2","assets/images/p-2.jpg")?>" width="100%" height="365" class="radius-5" /></a>
																</div>
															</div>
														</div>
														<?}?>

														<? if($rowReview['img3']){?>
														<div class="col-12 col-sm-6 col-lg-4">
															<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
																<!-- Product Image -->
																<div class="post-thumb">
																	 <a href="<?=phpThumb("/_UPLOAD/".$rowReview['img3'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img3'],500,365,"2","assets/images/p-2.jpg")?>" width="100%" height="365" class="radius-5" /></a>
																</div>
															</div>
														</div>
														<?}?>




														<?/*<ul class="row no-style px-3">
														  <? if($rowReview['img1']){?>
															<li class="mr-2">
															  <a href="/_UPLOAD/<?=$rowReview['img1']?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img1'], 200, 200, 2, "")?>" style="border:none" class="radius-5"></a>
															</li>
															<?}?>
															<? if($rowReview['img2']){?>
															<li class="mr-2">
															  <a href="/_UPLOAD/<?=$rowReview['img2']?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img2'], 200, 200, 2, "")?>" style="border:none" class="radius-5"></a>
															</li>
															<?}?>
															<? if($rowReview['img3']){?>
															<li class="mr-2">
															  <a href="/_UPLOAD/<?=$rowReview['img3']?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$rowReview['img3'], 200, 200, 2, "")?>" style="border:none" class="radius-5"></a>
															</li>
															<?}?>
														</ul>*/?>
														
													</div>
												</li>
											<?}?>

										</ul>
									</div>
								</div>
							</div>
						</div>
					</article>
                </div>
            </div>
        </div>
    </section>

    <!-- ##### Area End ##### -->


	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_store.php"; ?>
	</body>
	<script>
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
	$('.nav_category li[data-name="gnb-partner"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
<?
include "_kakao_map.php";
?>
</html>