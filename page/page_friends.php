<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<body class="mb-5">
	<? include "./inc_Top.php"; ?>
	<section>
		<div class="container mt-5">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-8 col-xl-8 px-0">
				<!--tab-->
					<div id="tab-menu" class="tab-sub clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0 active"><a href="page_friends.php?member_id=<?=$_GET['member_id']?>" title="친구">친구</a></li>
							<li class="col p-0"><a href="page_following.php?member_id=<?=$_GET['member_id']?>" title="팔로잉">팔로잉</a></li>
							<li class="col p-0"><a href="page_follower.php?member_id=<?=$_GET['member_id']?>" title="팔로워">팔로워</a></li>
						</ul>
					</div>
					<!--tab-->

					<!--친구 리스트 // 나의 친구리스트 모두 보여줌-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">친구리스트 <span class="color-primary">
						
<? if($_GET['member_id']){?>
						<?=number_format(전체친구수($_GET['member_id']))?>
<?}else{?>
						<?=number_format(전체친구수($rowMember['member_id']))?>
<?}?>						
						
						</span></h3>
						<div class="list list-default mt-3">
							<ul>

<?
if($_GET['member_id']){

	$query = "select * from tbl_member M, gf_friends F where M.member_id = F.friend_member_id and F.origin_member_id = '{$_GET['member_id']}' and F.진행상태 = '친구수락' UNION select * from tbl_member M, gf_friends F where M.member_id = F.origin_member_id and F.friend_member_id = '{$_GET['member_id']}' and F.진행상태 = '친구수락'";

}else{

	$query = "select * from tbl_member M, gf_friends F where M.member_id = F.friend_member_id and F.origin_member_id = '{$rowMember['member_id']}' and F.진행상태 = '친구수락' UNION select * from tbl_member M, gf_friends F where M.member_id = F.origin_member_id and F.friend_member_id = '{$rowMember['member_id']}' and F.진행상태 = '친구수락'";

}
$resultFM = db_query($query);

$member_id_array = array();
while($rowFM = db_fetch($resultFM)){

	if($rowFM['member_id'] == $rowMember['member_id']){
		continue;
	}
	
	if(in_array($rowFM['member_id'],$member_id_array)){
		continue;
	}
	$member_id_array[] = $rowFM['member_id'];

	$팔로워수 = 팔로워수($rowFM['member_id']);
?>

								<?=친구리스트용($rowFM['member_id'])?>
								
								<?/**<li>
									<a href="javascript:void(0)" title="">
										<div>
											<img src="<?=phpThumb("/_UPLOAD/".($rowFM['페이지프로필사진']?$rowFM['페이지프로필사진']:$rowFM['페이지배경사진']), 0, 0, 0,"assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
										</div>
										<div class="con-info con-follow">
											<h4 class="fs-005 ellipsis mb-1"><?=$rowFM['닉네임']?></h4>
											<p class="color-5"><a href="page_user.php?UID=<?=$rowFM['UID']?>"><?=$rowFM['페이지이름']?></a></p>

<? if($rowFM['member_id'] != $rowMember['member_id']){?>

											<?= 친구버튼($rowMember['member_id'], $rowFM['member_id']); ?>
											<!-- <button type="button" class="btn btn-primary btn-sm btn-capsule mr-2" onClick="mgt_friend('un_friend', '<?=$rowMember['member_id']?>','<?=$rowFM['member_id']?>');"><i class="fas fa-check fs--1 opacity-5"></i> 친구</button> -->
<?}?>
<? if($rowFM['member_id'] != $rowMember['member_id']){?>
											<?=팔로잉버튼($rowMember['member_id'], $rowFM['member_id']);?>
<?}?>
										</div>
									</a>
								</li>**/?>
<?}?>
							</ul>
						</div>
					</article>
					<!--//팔로워 리스트-->

<? if(!$_GET['member_id']){?>

<?
$query = "select * from tbl_member M, gf_friends F where M.member_id = F.origin_member_id and F.friend_member_id = '{$rowMember['member_id']}' and F.진행상태 = '친구신청중' UNION ALL select * from tbl_member M, gf_friends F where M.member_id = F.friend_member_id and F.origin_member_id = '{$rowMember['member_id']}' and F.진행상태 = '친구신청중'";

$resultFS = db_query($query);	
?>

					<!-- 친구신청 리스트 -->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">친구요청 <span class="color-primary"><?=number_format(db_num_rows($resultFS))?></span></h3>
						<div class="list list-default mt-3">
							<ul>

								
<?
while($rowFS = db_fetch($resultFS)){

	if(친구여부($rowFS['member_id'], $rowMember['member_id'])){
		continue;
	}

?>
								<?= 친구신청리스트($rowFS['member_id'])?>
<?}?>

								
							</ul>
						</div>
					</article>
					<!--//친구신청-->

					<!--추천 친구 // 비슷한 지역, 연령대의 사용자 랜덤 20명 추출-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">추천친구</h3>
						<div class="list list-default mt-3">
							<ul>

<?
$query = "select * from tbl_member where member_id != '{$rowMember['member_id']}' and 공개여부 = '전체공개' and member_id not in (
	select origin_member_id from gf_friends where origin_member_id = '{$rowMember['member_id']}' or friend_member_id = '{$rowMember['member_id']}'
	UNION ALL
	select friend_member_id from gf_friends where origin_member_id = '{$rowMember['member_id']}' or friend_member_id = '{$rowMember['member_id']}'
) order by rand() LIMIT 0,20";
$resultRF = db_query($query);

while($rowRF = db_fetch($resultRF)){
?>
								<?=친구리스트용($rowRF['member_id'])?>
								<?/**
								<li>
									<div>
										<a href="page_user.php?UID=<?=$rowRF['UID']?>"><img src="<?=phpThumb("/_UPLOAD/".$rowRF['페이지프로필사진'], 0, 0, 0,"assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle"></a>
									</div>
									<div class="con-info con-follow">
										<h4 class="fs-005 ellipsis mb-1"><?=$rowRF['닉네임']?></h4>
										<p class="color-5"><?=$rowRF['페이지이름']?></p>
									
											<?= 친구버튼($rowMember['member_id'], $rowRF['member_id']); ?>

										<a href="page_user.php?UID=<?=$rowRF['UID']?>" class="btn btn-outline-gray btn-sm btn-capsule"><i class="fas fa-address-book opacity-50 mr-1"></i>페이지보기</a>
									</div>
								</li>
								**/?>

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