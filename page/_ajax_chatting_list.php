<?
$_GET['CID'] = $_SESSION['S_CID'];

include "include_save_header.php";

$query = "select * from gf_chatting_entrance where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
$rowE = db_select($query);

if(!$rowE['pk_chatting_entrance']){
	$rowE['채팅참가일시'] = date("Y-m-d H:i:s");
}


$query = "select * from gf_chatting_history where fk_channel = '{$rowChannel['pk_channel']}' and 채팅일시 >= '{$rowE['채팅참가일시']}' order by 채팅일시 ASC ";
$resultC = db_query($query);

while($rowC = db_fetch($resultC)){

	$rowM = get_member_row($rowC['fk_member']);
?>
								<input type="hidden" class="pk_chatting_history" value="<?=$rowC['pk_chatting_history']?>"/>

<? 
	if($rowC['fk_member'] != $rowMember['member_id']){
?>

								<div class="received-box talk-box d-flex chatting-list">
								<div class="talk-profile">
									<div class="dropdown">
										<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지프로필사진']?$rowM['페이지프로필사진']:$rowM['페이지배경사진']),33,33,"2","assets/images/user_img.jpg")?>" alt="프로필 이미지" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"/>
										<div class="dropdown-menu text-center">
											<a class="dropdown-item" href="page_user.php?UID=<?=$rowM['UID']?>" title="페이지보기">
												<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지배경사진']?$rowM['페이지배경사진']:$rowM['페이지프로필사진']),33,33,"2","assets/images/user_img.jpg")?>" alt="프로필 이미지" width="24"/>
												<span>페이지보기</span>
											</a>
											<!-- <button class="dropdown-item" type="button" title="태그메세지">
												<i class="fas fa-at fs-1 color-5"></i>
												<span>태그메세지</span>
											</button> -->
										</div>
									</div>
								</div>
								<div class="msg-box">
									<div class="msg-width">
										<p class="name mb-1 fs--1"><?=$rowM['name']?></p>
										<div class="msg"><?=$rowC['채팅내용']?></div>
										<span class="time"><?=date("m-d H:i",strtotime($rowC['채팅일시']))?></span>
									</div>
								</div>
							</div>
<?}else{?>
							<div class="sent-box talk-box d-flex justify-content-end">
								<div class="msg-box">
									<div class="msg-width">
										<div class="msg"><?=$rowC['채팅내용']?></div>
										<span class="time"><?=date("m-d H:i",strtotime($rowC['채팅일시']))?></span>
									</div>
								</div>
							</div>

<?}?>
							
<?}?>