<?
include "include_save_header.php";
?>

<? 
$pageScale = 10;

$start = ($pageNo-1)*$pageScale;
$limit = " LIMIT ".$start.", ".$pageScale;

$query = "select * from tbl_member M where member_id != '{$rowMember['member_id']}' order by member_id DESC {$limit} ";
$resultM = db_query($query);

while($rowM = db_fetch($resultM)){
	$query = "select count(*) as cnt from gf_follower where parent_member_id = '{$rowM['member_id']}'";
	$rowF = db_select($query);
	$팔로워수 = $rowF['cnt'];

	$친구여부 = 친구여부($rowMember['member_id'], $rowM['member_id']);
?>

								<?=페이지리스트용($rowM['member_id'])?>
						
								<?/** <li>
									<a href="page_user.php?UID=<?=$rowM['UID']?>" title="">
										<div>
											<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),0,0,"2","assets/images/user_img.jpg")?>" width="80" height="80" class="radius-5"/>
										</div>
										<div class="con-info">
											<h4 class="fs-0 ellipsis"><?=$rowM['닉네임']?> <span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 팔로워 <?=number_format($팔로워수)?></span></h4>
											<!-- <p class="color-5"><?=$rowM['페이지이름']?></p> -->

<? if($친구여부 == true){?>
										<span class="color-6 fs--1"><button type="button" class="btn btn-primary btn-sm btn-capsule mr-2" onClick="mgt_friend('un_friend', '<?=$rowMember['member_id']?>', '<?=$rowM['member_id']?>');"><i class="fas fa-check fs--1 opacity-5"></i> 친구</button></span>
<?}else{?>
										<span class="color-6 fs--1"><button type="button" class="btn btn-sm btn-outline-primary btn-capsule mr-2" onClick="mgt_friend('submit_friend', '<?=$rowMember['member_id']?>', '<?=$rowM['member_id']?>');">+ 친구</button></span>
<?}?>


										<?= 팔로잉버튼($rowMember['member_id'], $rowM['member_id'])?>

										</div>
									</a>
								</li> **/?>

<?}?>