<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<body>
	<? include "./inc_Top.php"; ?>
	<section>
		<div class="container mt-5">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-8 col-xl-8 px-0">
				<!--tab-->
					<div id="tab-menu" class="tab-sub clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0"><a href="page_friends.php?member_id=<?=$_GET['member_id']?>" title="친구">친구</a></li>
							<li class="col p-0 active"><a href="page_following.php?member_id=<?=$_GET['member_id']?>" title="팔로잉">팔로잉</a></li>
							<li class="col p-0"><a href="page_follower.php?member_id=<?=$_GET['member_id']?>" title="팔로워">팔로워</a></li>
						</ul>
					</div>
					<!--tab-->
<?
if($_GET['member_id']){
	
	$query = "select * from tbl_member M, gf_follower F where M.member_id = F.parent_member_id and F.child_member_id = '{$member_id}'";

}else{

	$query = "select * from tbl_member M, gf_follower F where M.member_id = F.parent_member_id and F.child_member_id = '{$rowMember['member_id']}'";

}
$resultFM = db_query($query);
?>
					<!-- 나의 팔로잉 전체 목록 보여줌 -->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">팔로잉 <span class="color-primary"><?=number_format(mysqli_num_rows($resultFM))?></span></h3>
						<div class="list list-default mt-3">
							<ul>

<?
while($rowFM = db_fetch($resultFM)){
	$query = "select count(*) as cnt from gf_follower where parent_member_id = '{$rowFM['member_id']}'";
	$rowCNT = db_select($query);
	$팔로워수 = $rowCNT['cnt'];
?>

								<li>
									<a href="page_user.php?UID=<?=$rowFM['UID']?>" title="">
										<div>
											<img src="<?=phpThumb("/_UPLOAD/".$rowFM['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
										</div>
										<div class="con-info con-follow">
											<h4 class="fs-005 ellipsis mb-1"><a href="page_user.php?UID=<?=$rowFM['UID']?>"><?=$rowFM['닉네임']?></a> <span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 팔로워 <?=number_format($팔로워수)?></span></h4>
											<p class="color-5"><a href="page_user.php?UID=<?=$rowFM['UID']?>"><?=$rowFM['페이지이름']?></a></p>

<? if($rowFM['member_id'] != $rowMember['member_id']){?>

<? if(팔로잉여부($_GET['member_id']?$_GET['member_id']:$rowFM['member_id'], $rowMember['member_id'])){?>

											<button type="button" class="btn btn-primary btn-sm btn-capsule mr-2" 
											<?if(!$_GET['member_id']){?>
												onClick="unfollow('<?=$rowFM['member_id']?>');"
											<?}?>
												><i class="fas fa-check fs--1 opacity-5"></i> 팔로잉</button>
<?}else{?>
											<button type="button" class="btn btn-sm btn-capsule mr-2" 
											<?if(!$_GET['member_id']){?>
												onClick="follow('<?=$rowFM['member_id']?>');"
											<?}?>
												>팔로우</button>
<?}?>

<?}?>
											
										</div>
									</a>
								</li>
<?}?>								
							</ul>
						</div>
					</article>
					<!--//목록끝-->


<? if(!$_GET['member_id']){?>

<!--추천 친구 // 비슷한 지역, 연령대의 사용자 랜덤 20명 추출-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">추천 페이지</h3>
						<div class="list list-default mt-3">
							<ul>

<?
$query = "select * from tbl_member where member_id not in(select parent_member_id from gf_follower where child_member_id = '{$rowMember['member_id']}') order by rand() LIMIT 0,10";
$resultFM = db_query($query);

while($rowFM = db_fetch($resultFM)){
?>

								<li>
									<div>
										<img src="<?=phpThumb("/_UPLOAD/".$rowFM['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
									</div>
									<div class="con-info con-follow">
										<h4 class="fs-005 ellipsis mb-1"><?=$rowFM['name']?></h4>
										<p class="color-5"><?=$rowFM['페이지이름']?></p>
<? if(팔로잉여부($rowFM['member_id'], $rowMember['member_id'])){?>

											<button type="button" class="btn btn-primary btn-sm btn-capsule mr-2" onClick="unfollow('<?=$rowFM['member_id']?>');"><i class="fas fa-check fs--1 opacity-5"></i> 팔로잉</button>
<?}else{?>
											<button type="button" class="btn btn-sm btn-capsule mr-2" onClick="follow('<?=$rowFM['member_id']?>');">팔로우</button>
<?}?>
										<a href="page_me.php" class="btn btn-outline-gray btn-sm btn-capsule"><i class="fas fa-address-book opacity-50 mr-1"></i>페이지보기</a>
									</div>
								</li>

<?}?>

							</ul>
						</div>
					</article>
					<!--//추천 친구-->
<?}?>
					
					
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom_page.php"; ?>
</body>

<script>
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="friend"]').addClass('active');
</script>
</html>