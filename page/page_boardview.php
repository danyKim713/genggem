<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<?
$query = "select * from gf_page_article where pk_page_article = '{$_GET['pk_page_article']}'";
$row = db_select($query);

$query = "select * from tbl_member where member_id = '{$row['member_id']}'";
$rowM = db_select($query);

$query = "select * from gf_page_reply where fk_page_article = '{$_GET['pk_page_article']}'";
$resultReplyCNT = db_query($query);
$댓글수 = mysqli_num_rows($resultReplyCNT);

$query = "select * from gf_page_reply where fk_page_article = '{$_GET['pk_page_article']}' and fk_page_reply	 = '0' order by 등록일시 DESC";
$resultReply = db_query($query);
?>

<script>
	$(function(){
		lightbox.option({
			'resizeDuration': 200,
			'wrapAround': true
		})
	});	

	
<?
if($row['member_id'] == $rowMember['member_id']){
?>
	function go_modify_page(pk_page_article){
		top.location.href = "page_modify.php?pk_page_article="+pk_page_article;
	}

	function go_delete_page(pk_page_article){
		if(confirm('정말로 해당 페이지 글을 삭제하시겠습니까?')){
			$.post("_ajax_page_delete.php",{
				pk_page_article: pk_page_article
			},function(result){
				if(result == "SUCCESS"){
					alert('성공적으로 삭제되었습니다.');
					top.location.reload(true);
				}else{
					alert('오류가 발생했습니다. 관리자에게 문의바랍니다.');
				}
			});
		}
	}

<?}?>
</script>

<body>

<header class="header top_fixed">
	<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
	<h2 class="header-title text-center">게시글보기</h2>
</header>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<!--게시글-->
					<article class="p-3 mb-2 position-r">

<?
if($row['member_id'] == $rowMember['member_id']){
?>

							<div class="dropdown position-ab btn-right-top">
								<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="javascript:go_modify_page('<?=$row['pk_page_article']?>');" title="글 수정">글 수정</a>
									<a class="dropdown-item" href="javascript:go_delete_page('<?=$row['pk_page_article']?>');" title="글 삭제">글 삭제</a>
								</div>
							</div>

<?}?>

							<!-- 작성자 정보-->
							<div class="d-flex align-items-end mb-3">
								<div class="page-profile">
									<img src="<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'], 0, 0, 0,  "assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
								</div>
								<div class="col page-write lh-3">
									<h3 class="fs-005 mb-0"><?=$rowM['name']?></h3>
									<span class="date fs--1"><?=$row['등록일시']?></span>
								</div>
							</div>
							<!-- //작성자 정보-->
							<!--작성글 및 태그-->
							<div class="page-write">
								<p class="post"><?=$row['내용']?></p>
								<div class="fs-005 mt-1 color-6">

<?
$query = "select * from gf_page_article_tag where fk_page_article = '{$row['pk_page_article']}'";
$resultT = db_query($query);

while($rowT = db_fetch($resultT)){
?>

									<span class="mr-2">#<?=$rowT['태그내용']?></span>
<?}?>
								</div>
							</div>
							<!--//작성글 및 태그-->
								<!--사진-->
								<div class="list-card my-3">
									<ul class="card-columns">
<?
$query = "select * from gf_page_photo where fk_page_article = '{$row[pk_page_article]}'";
$resultPHOTO = db_query($query);
for ($i=0; $i<mysqli_num_rows($resultPHOTO); $i++){
	$rowPHOTO = mysqli_fetch_array($resultPHOTO);
?>
										<li class="card border-none">
											<a href="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","")?>" data-lightbox="menu">
											<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],147,147,"2","assets/images/ex_img6.jpg")?>" alt="" />
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
												<input id="chk1" name="chk_good" type="checkbox" class="invisible good_<?=$row['pk_page_article']?>" <?=좋아요카운트($row['pk_page_article'])>0?"checked":""?> onChange="go_like('<?=$row['pk_page_article']?>','like_id_<?=$row['pk_page_article']?>');">
												<label for="chk1" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5" ></i>좋아요 <span class="color-primary" id="like_id_<?=$row['pk_page_article']?>"><?=좋아요카운트($row['pk_page_article'])?></span></label>
											</div>
										</div>
										<div class="col p-0">
											<a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=number_format($댓글수)?></span></a>
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
											<img src="<?=phpThumb("/_UPLOAD/".$rowM['페이지프로필사진'], 40, 40, "2", "assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
										</div>
										<div class="page-write col lh-3 pr-0">
											<h5 class="fs-005 mb-0"><?=$rowM['name']?></h5>
											<p class="post fs-005 fw-300 mb-2"><?=nl2br($rowReply['댓글내용'])?>
											</p>
											<div class="d-flex lh-2">
												<div class="checkbox check-primary">
													<input id="chk_<?=$idxR?>" name="chk_good" type="checkbox" class="invisible">
													<label for="chk_<?=$idxR?>" class="color-5 mb-0 fw-400" onClick="go_reply_like('<?=$rowReply['pk_page_reply']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <?=number_format(댓글의좋아요카운트($rowReply['pk_page_reply']))?></label>
												</div>
												<span class="px-1">·</span>
												<button type="button" class="btn-reply btn btn-transparent color-primary p-0">답글달기</button>
											</div>
											<!--답글입력창-->
											<div class="con-reply">
												<div class="d-flex mt-3">
													<textarea class="form-control" placeholder="답글 내용을 입력해주세요" rows="2" id="답글내용_<?=$rowReply['pk_page_reply']?>"></textarea>
													<button type="button" class="btn btn-outline-secondary col-3 px-3" onClick="go_reply_reply('답글내용_<?=$rowReply['pk_page_reply']?>','<?=$rowReply['pk_page_reply']?>');">확인</button>
												</div>
											</div>
											<!--//답글입력창-->
<?
$query = "select * from gf_page_reply where fk_page_article = '{$_GET['pk_page_article']}' and fk_page_reply = '{$rowReply['pk_page_reply']}' order by 등록일시 ASC";
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
																<img src="<?=phpThumb("/_UPLOAD/".$rowMM['페이지프로필사진'], 30, 30, "2", "assets/images/user_img.jpg")?>" width="30" height="30" class="rounded-circle">
															</div>
															<div class="col lh-3 pr-0">
																<h5 class="fs-005 mb-1"><?=$rowMM['name']?></h5>
																<p class="fs-005 fw-300"><?=nl2br($rowRR['댓글내용'])?></p>
															</div>
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
							<button type="button" class="btn btn-primary col-3 px-3" onClick="go_reg_reply();">확인</button>
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