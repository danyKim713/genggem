<?
include "include_save_header.php";
?>

<? 
$pageScale = 10;

$start = ($pageNo-1)*$pageScale;
$limit = " LIMIT ".$start.", ".$pageScale;

$query = "select * from tbl_store_review where 1 order by review_id DESC {$limit} ";
$result = db_query($query);

while($row = db_fetch($result)){

	$query = "select * from tbl_member where member_id = '{$row['member_id']}'";
	$rowM = db_select($query);

	$query = "select * from tbl_store A, tbl_store_cate B where A.store_id = '{$row['store_id']}' and A.store_cate_id = B.store_cate_id";
	$rowS = db_select($query);

	$query = "select count(*) as cnt from tbl_store_review_like where review_id = '{$row['review_id']}'";
	$rowL = db_select($query);
	$좋아요수 = ($rowL['cnt']);

	$query = "select count(*) as cnt from tbl_store_review_like where review_id = '{$row['review_id']}' and fk_member = '{$rowMember['member_id']}'";
	$rowL = db_select($query);
	$좋아요여부 = ($rowL['cnt']) > 0;


	$query = "select count(*) as cnt from tbl_store_review_reply where review_id = '{$row['review_id']}'";
	$rowL = db_select($query);
	$댓글수 = number_format($rowL['cnt']);

?>

			<div class="row border-bottom mb-5">
				<div class="col-12 col-md-4">
                    <div class="post-sidebar-area">

                        <!-- ##### Single Widget Area ##### -->
                        <div class="single-widget-area">
                            <!-- Title -->
                            <div class="widget-title">
                                <h5>Store review</h5>
                            </div>

                            <!-- Single Latest Posts -->
							<div class="d-flex align-items-end mb-3">
								<!-- <div class="dropdown position-ab btn-right-top">
									<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
									<div class="dropdown-menu">
										<?/**<a class="dropdown-item" href="javascript:go_modify_page('<?=$row['review_id']?>');" title="글 수정">글 수정</a>**/?>
										<a class="dropdown-item" href="javascript:go_delete_review('<?=$row['review_id']?>');" title="글 삭제">글 삭제</a>
									</div>
								</div> -->

								<div class="page-profile">
									<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),50,50,"2","assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">

								</div>
								<div class="col page-write lh-3">
									<h3 class="fs-005 mb-0"><?=$rowM['name']?></h3>
									<span class="date fs--1"><?=date("Y.m.d H:i", strtotime($row['regdate']))?></span>
								</div>
								<!-- <button class="btn-right btn btn-info3 btn-xs mr-1" type="button" onClick="javascript:go_delete_review('<?=$row['review_id']?>');"><i class="fas fa-times"></i> 글삭제</button> -->
							</div>

                            <div class="single-latest-post d-flex align-items-center">
                                <div class="post-content">
                                    <h6 class="fw-400"><?=$rowS['store_name']?></span> <button class="btn-right btn btn-info btn-xs ml-1" type="button" onClick="top.location.href='store.php?store_id=<?=$rowS['store_id']?>'"><i class="fas fa-store-alt"></i> 스토어보기</button></h6>
                                    <p><i class="fas fa-map-marker-alt opacity-60"></i> <?=$rowS['store_addr']?> <?=$rowS['store_addr_detail']?></p>
									<p><i class="fas fa-mobile opacity-60"></i> <?=$rowS['store_cate_name']?></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

				<div class="col-12 col-md-8">
                    <!-- new class // 정열 가로 3개 2줄 총 6개-->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<div class="page-write">

								<div class="rating-stars fs--1">
									<div id="rating-<?=$row['review_id']?>"></div>

									<script>
									  options_<?=$row['review_id']?> = {
										max_value: 5,
										step_size: 0.5,
										initial_value: <?=$row['star_rate']?>
									  };
									  $(function() {
										$("#rating-<?=$row['review_id']?>").rate(options_<?=$row['review_id']?>);
									  });

									</script>

									<style type="text/css">
									  .rate-select-layer span {
										color: #f0ad4e;
									  }

									</style>
								</div>

								<p class="lh-2"><a href="store_review_read.php?review_id=<?=$row['review_id']?>" title="" onClick="popct(this.href, '500', '700');return false" class="clearfix"><?=nl2br($row['review_content'])?><br>
								<button type="button" class="btn-reply btn btn-info9 btn-xs mb-0 fw-400 mt-1"><i class="fa fa-plus-circle"></i> 더보기</button></a></p>
							</div>
							
						</div>
					</div>

					<div class="row">

						<? if($row['img1']){?>
						<div class="col-12 col-sm-6 col-lg-4">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								<!-- Product Image -->
								<div class="post-thumb">
									 <a href="<?=phpThumb("/_UPLOAD/".$row['img1'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$row['img1'],500,365,"2","assets/images/p-2.jpg")?>" width="100%" height="365" class="radius-5" /></a>
								</div>
							</div>
						</div>
						<?}?>

						<? if($row['img2']){?>
						<div class="col-12 col-sm-6 col-lg-4">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								<!-- Product Image -->
								<div class="post-thumb">
									 <a href="<?=phpThumb("/_UPLOAD/".$row['img2'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$row['img2'],500,365,"2","assets/images/p-2.jpg")?>" width="100%" height="365" class="radius-5" /></a>
								</div>
							</div>
						</div>
						<?}?>

						<? if($row['img3']){?>
						<div class="col-12 col-sm-6 col-lg-4">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								<!-- Product Image -->
								<div class="post-thumb">
									 <a href="<?=phpThumb("/_UPLOAD/".$row['img3'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$row['img3'],500,365,"2","assets/images/p-2.jpg")?>" width="100%" height="365" class="radius-5" /></a>
								</div>
							</div>
						</div>
						<?}?>
					</div>

					<!--버튼-->
					<div class="page-box text-center mb-5">
						<div class="row m-0">
							<div class="col p-0 ">
								<div class="checkbox">
									<input id="" name="chk_good" type="checkbox" class="invisible good_<?=$row['review_id']?>" <?=$좋아요여부 ? "checked":""?>>
									<label for="" class="color-5 mb-0 fw-400" onClick="go_like_store_review('<?=$row['review_id']?>','like_id_<?=$row['review_id']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary" id="like_id_<?=$row['review_id']?>"><?=$좋아요수?></span></label>
								</div>
							</div>
							<div class="col p-0">
								<a href="store_review_read.php?review_id=<?=$row['review_id']?>" onClick="popct(this.href, '500', '700');return false"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=$댓글수?></span></a>
							</div>
						</div>
					</div>
					<!--//버튼-->

                </div>
			</div>


<?}?>



					<?/*
					<!--글목록-->
					<article class="p-3 mb-2 position-r">						
						<!-- 레슨 리스팅 시작 -->				

							<!--작성글-->
							<a href="store_review_read.php?review_id=<?=$row['review_id']?>" title="" class="clearfix">
							<div class="page-write">

								<div class="rating-stars fs--1">
									<div id="rating-<?=$row['review_id']?>"></div>

									<script>
									  options_<?=$row['review_id']?> = {
										max_value: 5,
										step_size: 0.5,
										initial_value: <?=$row['star_rate']?>
									  };
									  $(function() {
										$("#rating-<?=$row['review_id']?>").rate(options_<?=$row['review_id']?>);
									  });

									</script>

									<style type="text/css">
									  .rate-select-layer span {
										color: #f0ad4e;
									  }

									</style>
								</div>

								<p class="post"><?=nl2br($row['review_content'])?></p>
							</div>
							<!--//작성글>

							<!--사진-->
							<div class="list-card my-3">
								<ul class="card-columns">

<? if($row['img1']){?>
									<li class="card border-none">
										<a href="<?=phpThumb("/_UPLOAD/".$row['img1'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$row['img1'], 105, 105, "", "")?>" style="border:none"></a>
									</li>
<?}?>
<? if($row['img2']){?>
									<li class="card border-none">
										<a href="<?=phpThumb("/_UPLOAD/".$row['img2'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$row['img2'], 105, 105, "", "")?>" style="border:none"></a>
									</li>
<?}?>
<? if($row['img3']){?>
									<li class="card border-none">
										<a href="<?=phpThumb("/_UPLOAD/".$row['img3'], 400, 400, "", "")?>" data-lightbox="roadtrip"><img src="<?=phpThumb("/_UPLOAD/".$row['img3'], 105, 105, "", "")?>" style="border:none"></a>
									</li>
<?}?>
								</ul>
							</div>
							</a>
							<!--//사진-->

							<!--버튼-->
							<div class="page-box text-center mb-3">
								<div class="row m-0">
									<div class="col p-0 ">
										<div class="checkbox">
											<input id="" name="chk_good" type="checkbox" class="invisible good_<?=$row['review_id']?>" <?=$좋아요여부 ? "checked":""?>>
											<label for="" class="color-5 mb-0 fw-400" onClick="go_like_store_review('<?=$row['review_id']?>','like_id_<?=$row['review_id']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary" id="like_id_<?=$row['review_id']?>"><?=$좋아요수?></span></label>
										</div>
									</div>
									<div class="col p-0">
										<a href="store_review_read.php?review_id=<?=$row['review_id']?>"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=$댓글수?></span></a>
									</div>
								</div>
							</div>
							<!--//버튼-->
					</article>
					<!-- //레슨 리스팅 끝 -->
					*/?>
