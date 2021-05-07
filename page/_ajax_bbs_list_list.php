<?
@session_start();

$_GET['CID'] = $_SESSION['S_CID'];

include "include_save_header.php";

$pageScale = 10;

$start = ($pageNo-1)*$pageScale;
$limit = " LIMIT ".$start.", ".$pageScale;

$query = "select * from  gf_channel_bbs where fk_channel = '{$rowChannel['pk_channel']}' order by pk_channel_bbs DESC {$limit} ";
$resultB = db_query($query);

while($rowB = db_fetch($resultB)){

	$rowM = get_member_row($rowB['fk_member']);

	$query = "select count(*) as cnt from gf_channel_bbs_like where fk_channel_bbs = '{$rowB['pk_channel_bbs']}'";
	$rowL = db_select($query);
	$좋아요수 = number_format($rowL['cnt']);

	$query = "select count(*) as cnt from gf_channel_reply where fk_channel_bbs = '{$rowB['pk_channel_bbs']}' /* and fk_channel_reply in ('0', '') */";

	$rowL = db_select($query);
	$댓글수 = number_format($rowL['cnt']);

	$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
	$rowSysop = db_select($query);
?>
					<article class="p-3 mb-2 position-r" id="divBBS_<?=$rowB["pk_channel_bbs"]?>">
<? 
	// 작성자이거나 운영자일 경우 삭제버튼 노출
	if (($rowMember["member_id"] == $rowB["fk_member"]) || $rowSysop["운영진여부"]) {
?>
						<a href="javascript:void(0)" title="게시글 삭제" id="btnBBS_<?=$rowB["pk_channel_bbs"]?>" class="position-ab btn btn-info3 btn-xs btn-right-top color-5 mt-2 mr-3 btnBBS"><i class="fas fa-times"></i> 삭제</a>
<? 
	} 
?>
						<!-- 작성자 정보-->
						<div class="d-flex align-items-end mb-3">
							<div class="page-profile">
								<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),50,50,"2","assets/images/user_img.jpg")?>" width="50" height="50" class="rounded-circle">
							</div>
							<div class="col page-write lh-2">
								<h3 class="fs-05 mb-0"><?=$rowM['닉네임']?></h3>
								<span class="date fs--1"><?=date("Y.m.d H:i", strtotime($rowB['등록일시']))?></span>
							</div>
						</div>
						<!-- //작성자 정보-->

						<!--작성글 및 태그-->
						<a href="cafe_boardview.php?pk_channel_bbs=<?=$rowB['pk_channel_bbs']?>" onClick="popct(this.href, '500', '700');return false" class="clearfix">
						<div class="page-write mt-4">
							<p class="post"><?=cutstr($rowB['내용'], 56)?></p>
						</div>
						<!--//작성글 및 태그-->

						<!--사진-->
						<div class="list-card">
							<!--사진이 3개이상일 경우 숫자표기 class : card-cover 추가하고 아래 숫자표기-->
							<ul class="card-columns">

							<?
							$query = "select * from gf_channel_bbs_img where fk_channel_bbs = '{$rowB['pk_channel_bbs']}'";
							$resultI = db_query($query);

							$Inum = db_num_rows($resultI);
							$idx = 0;
							while($rowI = db_fetch($resultI)){
								$idx++;

								if($idx > 4){
									continue;
								}
							?>

								<li class="card border-none">
								<? if($idx == 4 && $Inum > 4){?>
									<span class="card-cover"><?=($Inum-4)?>장 +</span>
								<?}?>
									<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".($rowI['이미지파일명']),300,300,"2","assets/images/ex_img6.jpg")?>" alt="" />
								</li>
							<?}?>

							</ul>
						</div>
						</a>
						<!--//사진-->

						<!--버튼-->
						<div class="page-box text-center">
							<div class="row m-0">
								<div class="col p-0 ">
									<div class="checkbox">
										<input id="chk1" name="chk_good" type="checkbox" class="invisible good_<?=$rowB['pk_channel_bbs']?>" <?=$좋아요수 > 0 ? "checked" : ""?>>
										<label for="chk1" class="color-5 mb-0 fw-400" onClick="go_like_channel_bbs('<?=$rowB['pk_channel_bbs']?>','like_id_<?=$rowB['pk_channel_bbs']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5" ></i>좋아요 <span class="color-primary" id="like_id_<?=$rowB['pk_channel_bbs']?>"><?=$좋아요수?></span></label>
									</div>
								</div>
								<div class="col p-0">
									<a href="cafe_boardview.php?pk_channel_bbs=<?=$rowB['pk_channel_bbs']?>" onClick="popct(this.href, '500', '700');return false" class="clearfix"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=$댓글수?></span></a>
								</div>
								<!-- <div class="col p-0">
									<a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>
								</div> -->
							</div>
						</div>
						<!--//버튼-->
					</article>

<?}?>