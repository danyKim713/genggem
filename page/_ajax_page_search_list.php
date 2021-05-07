<?
include "include_save_header.php";
?>

<?
$필드배열 = array("name","닉네임","페이지이름","출신지역","출신고등학교","출신대학교");

$where = array();
for ($i=0; $i<sizeof($필드배열); $i++){
	$where[] = " {$필드배열[$i]} like '%$keyword%'";
}

$where = implode (" or ", $where);

$query = "select * from tbl_member where ({$where}) and 공개여부 = '전체공개' and member_id != '{$rowMember['member_id']}'";
$result = db_query($query);
?>
						
						
<?
if(mysqli_num_rows($result)==0){
?>
						<h3 class="main-tlt display-inline">'<?=$keyword?>'으로 검색되는 페이지가 없습니다.</h3>
<?}else{?>
						<h3 class="main-tlt display-inline">'<?=$keyword?>'으로 검색한 결과입니다.</h3>
						<div class="list list-default mt-3">
							<ul>

<?
while($rowM = db_fetch($result)){	
	$query = "select count(*) as cnt from gf_follower where parent_member_id = '{$rowM['member_id']}'";
	$row = db_select($query);
	$팔로워수 = $row['cnt'];
?>

								<?=페이지리스트용($rowM['member_id'])?>
								
								<?/**<li>
									
										<div>
											<a href="page_user.php?UID=<?=$rowM['UID']?>" title=""><img src="assets/images/user_img.jpg" width="90" height="90" class="radius-5"/></a>
										</div>
										<div class="con-info">
											<h4 class="fs-0 ellipsis"><a href="page_user.php?UID=<?=$rowM['UID']?>" title=""><?=$rowM['닉네임']?> <span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i> 팔로워 <?=number_format($팔로워수)?></span></a></h4>
											<!-- <p class="color-5"><a href="page_user.php?UID=<?=$rowM['UID']?>" title=""><?=$rowM['페이지이름']?></a></p> -->

										<?= 친구버튼($rowMember['member_id'], $rowM['member_id']);?>

										<?= 팔로잉버튼($rowMember['member_id'], $rowM['member_id']);?>								
										</div>
								</li>**/?>
<?}?>
							</ul>
						</div>
<?}?>