<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<? 
	if($rowChannel['member_id'] != $rowMember['member_id']){
		msg_page('모임장만 접근가능합니다.');
	}

	$_SESSION['S_CID'] = $_GET['CID'];
?>

<body>
<header class="header top_fixed">
	<h2 class="header-title text-center">카페멤버관리</h2>
</header>
	<section>
		<div class="container header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">

					<!--모임멤버 리스트-->
					<article class="p-3 mb-2">
						<div class="d-flex align-items-center">
							<h3 class="mr-auto main-tlt display-inline">채널멤버 <span class="color-primary"><?=$채널참여인원수?></span></h3>
							<!-- <button type="button"  class="btn btn-outline-danger btn-xs fs--1">선택멤버 강퇴</button> 
							<div class="checkbox check-square ml-1">
								<input id="chkAll" type="checkbox" class="invisible"/>
								<label for="chkAll" name="member" class="fs-1 mb-0"><i class="biko-check color-5"></i></label>
							</div>-->
						</div>
						<div class="list list-default mt-3">
							<ul>
								<li class="d-flex align-items-center">

<?
$row모임장 = get_member_row($rowChannel['member_id']);
?>

									<div>
										<img src="<?=phpThumb("/_UPLOAD/".($row모임장['페이지프로필사진']?$row모임장['페이지프로필사진']:$row모임장['페이지배경사진']),70,70,"2","assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
									</div>
									<div class="con-info con-follow">
										<h4 class="fs-005 ellipsis mb-1"><?=$row모임장['name']?><small class="color-6"><i class="fas fa-medal fs--1 color-primary ml-1"></i>  모임장</small></h4>
										<p class="color-5"><?=$row모임장['페이지이름']?></p>
									</div>
								</li>

<?
$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and 운영진여부 = 'Y' and 강퇴여부 = 'N'";
$result = db_query($query);

while($row = db_fetch($result)){
	$rowM = get_member_row($row['fk_member']);
?>

								<li class="d-flex align-items-center">
									<div>
										<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),70,70,"2","assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
									</div>
									<div class="con-info con-follow">
										<h4 class="fs-005 ellipsis mb-1"><?=$rowM['name']?><small class="color-6"><i class="fas fa-medal fs--1 color-purple ml-1"></i>  운영진</small></h4>
										<p class="color-5"><?=$rowM['페이지이름']?></p>
										<button type="button"  class="btn btn-gray btn-sm" onClick="go_운영진해제('<?=$rowM['member_id']?>');">운영진 해제</button>
										<button type="button"  class="btn btn-outline-danger btn-sm" onClick="go_강퇴('<?=$rowM['member_id']?>');">강퇴</button>
									</div>
									<!-- <div class="ml-auto checkbox check-square">
										<input id="chk1" type="checkbox" class="invisible"/>
										<label for="chk1" name="member" class="fs-1 mb-0"><i class="biko-check color-5"></i></label>
									</div> -->
								</li>
<?}?>


<?
$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and 운영진여부 = 'N' and 강퇴여부 = 'N'";
$result = db_query($query);

while($row = db_fetch($result)){
	$rowM = get_member_row($row['fk_member']);
?>
								
								<li class="d-flex align-items-center">
									<div>
										<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),70,70,"2","assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
									</div>
									<div class="con-info con-follow">
										<h4 class="fs-005 ellipsis mb-1"><?=$rowM['name']?></h4>
										<p class="color-5"><?=$rowM['페이지이름']?></p>
										<button type="button"  class="btn btn-gray btn-sm" onClick="go_운영진지정('<?=$rowM['member_id']?>');">운영진 지정</button>
										<button type="button"  class="btn btn-outline-danger btn-sm" onClick="go_강퇴('<?=$rowM['member_id']?>');">강퇴</button>
									</div>
									<!-- <div class="ml-auto checkbox check-square">
										<input id="chk3" type="checkbox" class="invisible"/>
										<label for="chk3" name="member" class="fs-1 mb-0"><i class="biko-check color-5"></i></label>
									</div> -->
								</li>

<?}?>


							</ul>
						</div>
					</article>
					<!--//멤버 리스트-->
					
					<? include "./inc_Bottom_channel.php"; ?>
				</div>
			</div>
		</div>
	</section>
</body>

</html>