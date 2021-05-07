<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<body>
	<header class="header top_fixed">
		<h2 class="header-title text-center"><img src="./assets/img/core-img/logo_b.png"></h2>
	</header>

	<section>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-10 col-xl-10 px-0">

					<article class="p-3 mb-2 mt-5">

<?
$query = "select * from gf_gallery where pk_gallery = '{$pk_gallery}'";
$rowG = db_select($query);

if($rowG['fk_member'] == $rowMember['member_id']){
?>
						<a href="javascript:go_delete_gallery('<?=$pk_gallery?>','<?=$CID?>');" title="게시글 삭제" class="position-ab btn-right-top btn-danger color-9 p-1 mt-2 mr-2 fs--1 radius-5">삭제</i></a>
<?}?>


						<div class="list-card mt-4">
							<div class="card-columns">

<?
//채널 멤버가 아니면 튕기게 해야 함....
$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
$rowM = db_select($query);

if($rowM['강퇴여부']=="Y"){
	msg_page('이미 강퇴당한 클럽입니다.');
}

if(!$rowM['pk_channel_member'] && $rowMember['member_id'] != $rowChannel['member_id']){
	msg_page('클럽에 가입해야 상세 페이지를 보실 수 있습니다.');
}

$query = "select * from gf_gallery_reply where fk_gallery = '{$pk_gallery}'";
$resultReplyCNT = db_query($query);
$댓글수 = mysqli_num_rows($resultReplyCNT);

$query = "select * from gf_gallery_reply where fk_gallery = '{$pk_gallery}' and fk_gallery_reply = '0' order by 등록일시 DESC";
$resultReply = db_query($query);


$query = "select * from gf_gallery_img where fk_gallery = '{$pk_gallery}'";
$result = db_query($query);

while($row = db_fetch($result)){
?>

								
									<span data-lightbox="review">
									<a href="<?=phpThumb("/_UPLOAD/".$row['이미지파일명'],500,500,"2","assets/images/ex_img3.jpg")?>" data-lightbox="menu">
										<img class="card-img img-fluid mb-3" src="<?=phpThumb("/_UPLOAD/".($row['이미지파일명']),300,300,"2","assets/images/ex_img3.jpg")?>" alt="">
									</a>
									</span>
									 <!-- <figcaption class="figure-caption"><?=$rowM['name']?></figcaption> -->
								
<?}?>
							</div>

						</div>
					</article>

					<!--댓글-->
					<article class="p-3 mb-5">
						<h2 class="main-tlt display-inline">댓글 <span class="color-primary"><?=number_format($댓글수)?></span></h2>
						<div class="list-comment mt-3">
							<ul>

<?
$idxR = 0;

while($rowReply = db_fetch($resultReply)){
	$query = "select * from tbl_member where member_id = '{$rowReply['member_id']}'";
	$rowM = db_select($query);

	$idxR++;
?>

								<li>
									<div class="d-flex align-items-start position-r">
										<div class="page-profile">
											<img src="<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'], 50, 50, "2", "assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
										</div>
										<div class="page-write col lh-3 pr-0">
											<h5 class="fs-005 mb-0"><?=$rowM['닉네임']?></h5>
											<p class="post fs-005 fw-300 mb-2"><?=nl2br($rowReply['댓글내용'])?>
											</p>
											<div class="d-flex lh-2">
												<div class="checkbox check-primary">
													<input id="chk_<?=$idxR?>" name="chk_good" type="checkbox" class="invisible" <?=댓글의좋아요카운트갤러리($rowReply['pk_gallery_reply']) > 0 ? "checked" : ""?>>
													<label for="chk_<?=$idxR?>" class="color-5 mb-0 fw-400" onClick="go_gallery_reply_like('<?=$rowReply['pk_gallery_reply']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <?=number_format(댓글의좋아요카운트갤러리($rowReply['pk_gallery_reply']))?></label>
												</div>
												<span class="px-1"> · </span>
												<button type="button" class="btn-reply btn-gray color-5 mb-0 fw-400">댓글달기</button>
											</div>
											<!--답글입력창-->
											<div class="con-reply">
												<div class="d-flex mt-3">
													<textarea placeholder="댓글 내용을 입력해주세요" rows="2" id="답글내용_<?=$rowReply['pk_gallery_reply']?>" style="border:1px solid #dedede; height:36px; width:100%; padding:8px;"></textarea>
													<button type="button" class="btn btn-secondary col-3 px-3 fs-005" onClick="go_gallery_reply_reply('답글내용_<?=$rowReply['pk_gallery_reply']?>','<?=$rowReply['pk_gallery_reply']?>');">확인</button>
												</div>
											</div>
											<!--//답글입력창-->
<?
$query = "select * from gf_gallery_reply where fk_gallery = '{$pk_gallery}' and fk_gallery_reply = '{$rowReply['pk_gallery_reply']}' order by 등록일시 ASC";
$resultRR = db_query($query);

if(mysqli_num_rows($resultRR)>0){
?>										
											<!--답글-->
											<div class="list-reply">
												<ul>

<?
while($rowRR = db_fetch($resultRR)){
	$rowMM = get_member_row($rowRR['member_id']);
?>

													<li>
														<div class="d-flex align-items-start position-r">
															<div class="page-profile">
																<img src="<?=phpThumb("/_UPLOAD/".$rowMM['페이지프로필사진'], 50, 50, "2", "assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
															</div>
															<div class="col lh-3 pr-0">
																<h5 class="fs-005 mb-1"><?=$rowMM['name']?></h5>
																<p class="fs-005 fw-300"><?=nl2br($rowRR['댓글내용'])?></p>
															</div>
															<p class="date position-ab mb-0 fs--1"><?=$rowRR['등록일시']?></p>
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
							<button type="button" class="btn btn-primary col-3 px-3 fs-005" onClick="go_gallery_reg_reply();">확인</button>
						</div>
					</div>
					<!--//댓글입력창-->
					
					
				</div>
			</div>
		</div>
		
	</section>
</body>

<script>
	$('.nav_category li[data-name="gnb-channel"]').addClass('active');
	$('.nav_bottom li[data-name="mychannel"]').addClass('active');

	$(document).ready(function(){
		$('.btn-reply').on("click",function(){
			$(this).parent('div').next().toggleClass("active");
			console.log('text');
		});
	});

</script>
</html>