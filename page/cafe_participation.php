<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<body>
<header class="header top_fixed">
	<h2 class="header-title text-center">참여자명단</h2>
</header>
	<section>
		<div class="container header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">

<?
$query = "select * from gf_moim where pk_moim = '{$pk_moim}'";
$rowMoim = db_select($query);

$참여인원수 = db_count("gf_moim_member", " fk_moim='{$pk_moim}'", $field="*");
?>

					<!--모임멤버 리스트-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">모임 참여멤버 <span class="color-purple"><?=$참여인원수?></span>/<?=$rowMoim['모임정원']?></h3>
						<div class="list list-default mt-3">
							<ul>


								<!-- <li>
									<div>
										<img src="assets/images/user_img.jpg" width="70" height="70" class="rounded-circle">
									</div>
									<div class="con-info con-follow">
										<h4 class="fs-005 ellipsis mb-1">멤머 이름<small class="color-6"><i class="fas fa-medal fs--1 color-purple ml-1"></i>  운영진</small></h4>
										<p class="color-5">페이지 제목</p>
										<button type="button" class="btn btn-outline-primary btn-sm btn-capsule mr-1">+ 팔로우</button>
										<a href="channel_participation.php" class="btn btn-outline-gray btn-sm btn-capsule"><i class="fas fa-address-book opacity-50 mr-1"></i>페이지보기</a>
									</div>
								</li> -->

<?
$query = "select * from gf_moim_member where fk_moim = '{$pk_moim}'";
$resultMM = db_query($query);

while($rowMM = db_fetch($resultMM)){

	$rowM = get_member_row($rowMM['fk_member']);
?>

								<li>
									<div>
										<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']),110,110,"2","assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
									</div>
									<div class="con-info con-follow">
										<h4 class="fs-005 ellipsis mb-1"><?=$rowM['닉네임']?></h4>
										<p class="color-5"><?=$rowM['페이지이름']?></p>

										<?= 팔로잉버튼($rowMember['member_id'], $rowM['member_id'])?>

										<?/*<a href="page_user.php?UID=<?=$rowM['UID']?>" class="btn btn-info2 btn-sm btn-capsule"><i class="fas fa-address-book opacity-50 mr-1"></i>페이지보기</a>

<? if($rowMoim['운영진_member_id']==$rowM['member_id']){?>
										<a href="#" class="btn btn-primary btn-sm btn-capsule mr-2"><i class="fas fa-address-book opacity-50 mr-1"></i>운영진</a>
<?}else{?>
										<a href="javascript:go_운영진_지정('<?=$rowM['member_id']?>');" class="btn btn-gray btn-sm btn-capsule"><i class="fas fa-address-book opacity-50 mr-1"></i>운영진 지정</a>
<?}?>*/?>
									</div>
								</li>
<?}?>

							</ul>
						</div>
					</article>
<?
$참여여부 = db_count("gf_moim_member", " fk_moim='{$pk_moim}' and fk_member = '{$rowMember['member_id']}'", $field="*") > 0;

if($참여여부 > 0){
?>
					<!-- 해당 모임에 참여중인 회원에게만 노출 -->
					<div class="m-3">
						<a href="javascript:join_cancel_moim_go_list('<?=$rowMoim['pk_moim']?>');" class="btn-block btn btn-gray color-danger fs-005">모임참여 취소</a>
					</div>
					<!--끝-->
<?}?>

					<!--//멤버 리스트-->
					
					
				</div>
			</div>
		</div>
	</section>
</body>
</html>