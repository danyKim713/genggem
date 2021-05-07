<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<?
$query = "select * from gf_channel_bbs where pk_channel_bbs = '{$pk_channel_bbs}'";
$rowB = db_select($query);

$query = "select * from gf_channel where pk_channel = '{$rowB['fk_channel']}'";
$rowChannel = db_select($query);

//채널 멤버가 아니면 튕기게 해야 함....
$query = "select * from gf_channel_member where fk_channel = '{$rowB['fk_channel']}' and fk_member = '{$rowMember['member_id']}'";
$rowM = db_select($query);

if($rowM['강퇴여부']=="Y"){
	msg_page('이미 강퇴당한 모임입니다.');
}

if(!$rowM['pk_channel_member']  && $rowMember['member_id'] != $rowChannel['member_id']){
	msg_page('모임에 가입해야 상세 페이지를 보실 수 있습니다.');
}


$query = "select count(*) as cnt from gf_channel_bbs_like where fk_channel_bbs = '{$rowB['pk_channel_bbs']}'";
$rowL = db_select($query);
$좋아요수 = number_format($rowL['cnt']);

$query = "select count(*) as cnt from gf_channel_reply where fk_channel_bbs = '{$rowB['pk_channel_bbs']}' and fk_channel_reply in ('0', '')";
$rowL = db_select($query);
$댓글수 = number_format($rowL['cnt']);

$rowM = get_member_row($rowB['fk_member']);
?>

<body class="mb-6">

<header class="header top_fixed">
	<h2 class="header-title text-center"><img src="./assets/img/core-img/logo_b.png"></h2>
</header>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-10 col-xl-6 p-0">
					<!--게시글-->
					<article class="p-3 mb-2 position-r">

							<!-- 작성자 정보-->
							<div class="d-flex align-items-end mb-3">
								<div class="page-profile">
									<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),50,50,"2","assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
								</div>
								<div class="col page-write lh-3">
									<h3 class="fs-05 mb-0"><?=$rowM['닉네임']?></h3>
									<span class="date fs--1"><?=date("Y.m.d H:i", strtotime($rowB['등록일시']))?></span>
								</div>
							</div>
							<!-- //작성자 정보-->
							<!--작성글 및 태그-->
							<div class="page-write">
								<p class="post"><?=nl2br($rowB['내용'])?></p>
							</div>
							<!--//작성글 및 태그-->
								<!--사진-->
								<div class="list-card my-3">
									<ul class="card-columns">

<?
$query = "select * from gf_channel_bbs_img where fk_channel_bbs = '{$rowB['pk_channel_bbs']}'";
$resultI = db_query($query);

while($rowI = db_fetch($resultI)){
?>

										<li class="card border-none">
											<a href="<?=phpThumb("/_UPLOAD/".$rowI['이미지파일명'],500,500,"2","")?>" data-lightbox="menu">
												<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".($rowI['이미지파일명']),300,300,"2","assets/images/ex_img6.jpg")?>" alt="" />
											</a>
										</li>
<?}?>
									</ul>
								</div>
								<!--//사진-->
								<!--버튼-->
								<div class="page-box text-center">
									<div class="row m-0">
										<div class="col p-0 ">
											<div class="checkbox">
												<input id="chk1" name="chk_good" type="checkbox" class="invisible good_<?=$rowB['pk_channel_bbs']?>" <?=$좋아요수 > 0 ?"checked":""?>>
												<label for="chk1" class="color-5 mb-0 fw-400" onClick="go_like_channel_bbs('<?=$rowB['pk_channel_bbs']?>','like_id_<?=$rowB['pk_channel_bbs']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary" id="like_id_<?=$rowB['pk_channel_bbs']?>"><?=$좋아요수?></span></label>
											</div>
										</div>
										<!-- <div class="col p-0">
											<a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=number_format($댓글수)?></span></a>
										</div> -->
									</div>
								</div>
								<!--//버튼-->
					</article>
					<!--//게시글-->
					<!--댓글-->
					<article class="p-3 mb-1">
						<!-- <h2 class="main-tlt display-inline">댓글 <span class="color-primary"><?=$댓글수?></span></h2> -->
						<div class="list-comment">
							<ul>
<?
$query = "select * from gf_channel_reply where fk_channel_bbs = '{$rowB['pk_channel_bbs']}' and fk_channel_reply is NULL order by 댓글일시 ASC";
$resultR = db_query($query);

$idx = 0;
while($rowR = db_fetch($resultR)){
	$idx++;

	$rowM = get_member_row($rowR['fk_member']);

	$query = "select count(*) as cnt from gf_channel_reply_like where fk_channel_reply = '{$rowR['pk_channel_reply']}'";
	$rowL = db_select($query);
	$좋아요수 = number_format($rowL['cnt']);

?>

								<li>
									<div class="d-flex align-items-start position-r">
										<div class="page-profile">
											<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),50,50,"2","assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
										</div>
										<div class="page-write col lh-3 pr-0">
											<h5 class="fs-005 mb-0"><?=$rowM['닉네임']?></h5>
											<p class="post fs-005 fw-300 mb-2"><?=$rowR['댓글내용']?>
											</p>
											<div class="d-flex lh-2">
												<div class="checkbox check-primary">
													<input id="chk2" name="chk_good" type="checkbox" class="invisible">
													<label for="chk2" class="btn-reply btn btn-info2 btn-xs mb-0 fw-400" onClick="go_like_channel_bbs_reply('<?=$rowR['pk_channel_reply']?>','reply_like_id_<?=$rowR['pk_channel_reply']?>');"><i class="fa fa-thumbs-up pr-1"></i>좋아요 <span id="reply_like_id_<?=$rowR['pk_channel_reply']?>"><?=$좋아요수?></span></label>
												</div>
												<span class="px-1">·</span>
												<button type="button" class="btn-reply btn btn-info3 btn-xs mb-0 fw-400"><i class="fa fa-edit pr-1"></i>댓글달기</button>

											</div>
											<!--답글입력창-->
											<div class="con-reply">
												<div class="d-flex mt-3 ml-3">
													<textarea id="댓글내용_<?=$idx?>" style="border:1px solid #dedede; height:36px; width:100%; padding:8px;" placeholder="댓글 내용을 입력해주세요" rows="2"></textarea>
													<button type="button" class="btn btn-info5 px-3 fs-005 ml-1" onclick="go_reg_channel_댓글답글등록('댓글내용_<?=$idx?>', '<?=$rowR['pk_channel_reply']?>');">확인</button>
												</div>
											</div>
											<!--//답글입력창-->
										

<?
$query = "select * from gf_channel_reply where fk_channel_bbs = '{$pk_channel_bbs}' and fk_channel_reply = '{$rowR['pk_channel_reply']}' order by 댓글일시 ASC";
$resultRR = db_query($query);

while($rowRR = db_fetch($resultRR)){

$rowMM = get_member_row($rowRR);
?>
											<!--답글-->
											<div class="list-reply">
												<ul>
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
												</ul>
											</div>
											<!--//답글-->

<?}?>

										</div>
										<p class="date position-ab mb-0 fs--1"><?=date("m.d H:i",strtotime($rowR['댓글일시']))?></p>
									</div>
								</li>

<?}?>

								
							</ul>
						</div>
					</article>
					<!--//댓글-->
					
					
				</div>
			</div>
			
		</div>
		<!--댓글입력창-->
		<div class="con-comment-input col-sm-10 col-lg-6 col-xl-4 p-0">
			<div class="d-flex">
				<textarea id="댓글내용" class="form-control" placeholder="댓글 내용을 입력해주세요" rows="2"></textarea>
				<button type="button" class="btn btn-primary btn-sm col-3" onClick="go_reg_channel_댓글등록();">확인</button>
			</div>
		</div>
		<!--//댓글입력창-->
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