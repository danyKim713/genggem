<!DOCTYPE HTML>
<html lang="en">
<?
	include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<body class="mb-5">

<?
	$query = "select * from tbl_store_review where review_id = '{$review_id}'";
	$row = db_select($query);

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

<header class="header top_fixed">
	<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
	<h2 class="header-title text-center fw-500"><img src="./assets/img/core-img/favicon.png" width="25px" class="mb-1"> 스토어 이용후기</h2>
</header>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<!--게시글-->
					<article class="p-3 mb-2 position-r">
							<!-- 작성자 정보-->
							<div class="d-flex align-items-end mb-3">
								<div class="page-profile">
									<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),40,40,"2","assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
								</div>
								<div class="col page-write lh-3">
									<h3 class="fs-005 mb-0"><?=$rowM['name']?></h3>
									<span class="date fs--1"><?=date("Y.m.d H:i", strtotime($row['regdate']))?></span>
								</div>
							</div>
							<!-- //작성자 정보-->

							<!-- 레슨/코치 정보 -->
							<div class="list-tour tour-wide mt-2 mb-3">
								<ul>
									<li>
										<div class="con-info">
											 <h4 class="tlt mt-1 ml-1"><i class="fas fa-store align-text-top fs--1 color-warning mt-1"></i> <?=$rowS['store_name']?></span> <!-- <button class="btn-right btn btn-outline-secondary btn-sm ml-1" type="button" onClick="top.location.href='franchise/UID.php'"><i class="fas fa-image"></i> 제휴점보기</button> --></h4>
											 <dl class="txt-info d-flex ml-2">
												 <span><i class="fas fa-map-marker-alt opacity-50 mr-1"></i> <?=$rowS['store_addr']?> <?=$rowS['store_addr_detail']?><br>
												 <i class="fas fa-mobile opacity-50 mr-1"></i> <?=$rowS['store_cate_name']?></span>
											 </dl>
										 </div>
									</li>
								</ul>
							</div>
							<!--// 레슨/코치 정보 끝-->

							<!--작성글 및 태그-->
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
								<p class="post lh-1 mt-4"><?=nl2br($row['review_content'])?></p>
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
							<div class="page-box text-center mb-3">
								<div class="row m-0">
									<div class="col p-0">
										<div class="checkbox">
											<input id="" name="chk_good" type="checkbox" class="invisible good_<?=$row['review_id']?>" <?=$좋아요여부 ? "checked":""?>>
											<label for="" class="color-5 mb-0 fw-400" onClick="go_like_store_review('<?=$row['review_id']?>','like_id_<?=$row['review_id']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary" id="like_id_<?=$row['review_id']?>"><?=$좋아요수?></span></label>
										</div>
									</div>
									<div class="col p-2">
										<i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=$댓글수?></span>
									</div>
								</div>
							</div>
							<!--//버튼-->
					</article>
					<!--//게시글-->
					<!--댓글-->
					<article class="p-3 mb-1">
						<h2 class="main-tlt display-inline">댓글 <span class="color-primary"><?=number_format($댓글수)?></span></h2>
						<div class="list-comment mt-3">
							<ul>

<?

$query = "select * from tbl_store_review_reply where review_id = '{$_GET['review_id']}' and fk_store_review_reply	 = '0' order by 댓글일시 DESC";
$resultReply = db_query($query);

$idxR = 0;

while($rowReply = db_fetch($resultReply)){
	$rowM = get_member_row($rowR['fk_member']);
	$query = "select * from tbl_member where member_id = '{$rowReply['fk_member']}'";

	$rowM = db_select($query);

	$idxR++;
?>

								<li>
									<div class="d-flex align-items-start position-r">
										<div class="page-profile">
											<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),50,50,"2","assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
										</div>
										<div class="page-write col lh-3 pr-0">
											<h5 class="fs-005 mb-0"><?=$rowM['닉네임']?></h5>
											<p class="post fs-005 fw-300 mb-2"><?=nl2br($rowReply['댓글내용'])?>
											</p>
											<div class="d-flex lh-2">
												<div class="checkbox check-primary">
													<input id="" name="chk_good" type="checkbox" class="invisible" <?= 댓글의좋아요카운트가맹점리뷰($rowReply['pk_store_review_reply']) > 0 ? "checked" : ""?>>
													<label for="" class="btn-reply btn btn-info2 btn-xs mb-0 fw-400" onClick="go_reply_like_review('<?=$rowReply['pk_store_review_reply']?>');"><i class="fa fa-thumbs-up pr-1"></i>좋아요 <?=number_format(댓글의좋아요카운트가맹점리뷰($rowReply['pk_store_review_reply']))?></label>
												</div>
												<span class="px-1">·</span>
												<button type="button" class="btn-reply btn btn-info3 btn-xs mb-0 fw-400"><i class="fa fa-edit pr-1"></i>댓글달기</button>
											</div>
											<!--답글입력창-->
											<div class="con-reply">
												<div class="d-flex mt-3 ml-3">
													<textarea class="form-control" style="border:1px solid #dedede; height:36px; width:100%; padding:8px;" placeholder="댓글 내용을 입력해주세요" rows="2" id="답글내용_<?=$rowReply['pk_store_review_reply']?>"></textarea>
													<button type="button" class="btn btn-info5 px-3 fs-005 ml-1" onClick="go_reply_reply_review('답글내용_<?=$rowReply['pk_store_review_reply']?>','<?=$rowReply['pk_store_review_reply']?>');">확인</button>
												</div>
											</div>
											<!--//답글입력창-->
<?
$query = "select * from tbl_store_review_reply where review_id = '{$_GET['review_id']}' and fk_store_review_reply = '{$rowReply['pk_store_review_reply']}' order by 댓글일시 ASC";
$resultRR = db_query($query);

if(mysqli_num_rows($resultRR)>0){
?>										
											<!--답글-->
											<div class="list-reply">
												<ul>



<?

while($rowRR = db_fetch($resultRR)){

$rowM = get_member_row($rowRR["fk_member"]);
?>

													<li>
														<div class="d-flex align-items-start position-r">
															<div class="page-profile">
																<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),40,40,"2","assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
															</div>
															<div class="col lh-3 pr-0">
																<h5 class="fs--1 mb-1"><?=$rowM['닉네임']?></h5>
																<p class="fs--1 fw-300"><?=nl2br($rowRR['댓글내용'])?></p>
															</div>
															<p class="date position-ab mb-0 fs--1"><?=date("m.d H:i",strtotime($rowRR['댓글일시']))?></p>
														</div>
													</li>
<?}?>													
												</ul>
											</div>
											<!--//답글-->

<?}?>

										</div>
										<p class="date position-ab mb-0 fs--1"><?=$rowReply['등록일시']?></p>
									</div>
								</li>
<?}?>
								
							</ul>
						</div>
					</article>
					<!--//댓글-->
					
					<!--댓글입력창-->
					<div class="con-comment-input col-sm-10 col-lg-6 col-xl-4 p-0">
						<div class="d-flex">
							<textarea name="댓글내용" id="댓글내용" class="form-control" placeholder="댓글 내용을 입력해주세요" rows="2"></textarea>
							<button type="button" class="btn btn-primary col-3 px-3" onClick="go_reg_reply_review();">확인</button>
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