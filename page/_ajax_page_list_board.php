<?
include "include_save_header.php";
?>

<? 
$pageScale = 10;

$start = ($pageNo-1)*$pageScale;
$limit = " LIMIT ".$start.", ".$pageScale;

$query = "select * from 
	gf_page_article A, tbl_member M 
	
	where 
		A.member_id = M.member_id 
		and (M.member_id in 
			(
				select parent_member_id from gf_follower F1, tbl_member M1 where F1.parent_member_id = M1.member_id and M1.공개여부 != '미공개' and F1.child_member_id = '{$rowMember['member_id']}'
					UNION
				select origin_member_id from gf_friends F2, tbl_member M2 where F2.origin_member_id = M.member_id and M2.공개여부 != '미공개' and F2.friend_member_id = '{$rowMember['member_id']}' and F2.진행상태 = '친구수락'
					UNION
				select friend_member_id from gf_friends F3, tbl_member M3 where F3.friend_member_id  = M3.member_id and M3.공개여부 != '미공개' and F3.origin_member_id = '{$rowMember['member_id']}' and F3.진행상태 = '친구수락'
			)
			)
		
	order by 
		pk_page_article DESC {$limit}";

$result = mysqli_query($conn, $query);

while($row = db_fetch($result)){
?>
								<li>

<? if($row['member_id'] == $rowMember['member_id']){?>

									<div class="dropdown position-ab btn-right-top">
										<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
										<div class="dropdown-menu">
											<a class="dropdown-item" href="javascript:go_modify_page('<?=$row['pk_page_article']?>');" title="글 수정">글 수정</a>
											<a class="dropdown-item" href="javascript:go_delete_page('<?=$row['pk_page_article']?>');" title="글 삭제">글 삭제</a>
										</div>
									</div>

<?}?>

									<!-- <a href="page_boardview.php" title="" class="clearfix"> -->
										<!--날짜,글,태그-->
										<!-- 작성자 정보-->
										<a href="page_boardview.php?pk_page_article=<?=$row['pk_page_article']?>" title="" class="clearfix">
										<div class="d-flex align-items-end mb-3">
											<div class="page-profile">
												<img src="<?=phpThumb("/_UPLOAD/".$row['페이지프로필사진'], 0, 0, "-2","assets/images/user_img.jpg")?>" width="35" height="35" class="rounded-circle">
											</div>
											<div class="col page-write lh-3">
											  <h3 class="fs-005 mb-0"><?=$row['name']?></h3>
												<span class="date fs--1"><?=date("Y년 m월 d일 H:i", strtotime($row['등록일시']))?></span>
											</div>
										</div>
										
										<div class="page-write">
											<span class="date"><?=date("Y년 m월 d일 H:i", strtotime($row['등록일시']))?></span> 
											<p class="post"><?=$row['내용']?></p>
											<div class="fs-005 mt-1 color-6">

<?
$query = "select * from gf_page_article_tag where fk_page_article = '{$row['pk_page_article']}'";
$resultTAG = db_query($query);

while($rowTAG = db_fetch($resultTAG)){
?>
												<span class="mr-2">#<?=$rowTAG['태그내용']?></span>
<?}?>
											</div>
										</div>
										</a>
										<!--//날짜,글,태그-->

										<!--사진-->
										<div class="list-card my-3">
											<!--사진이 3개이상일 경우 숫자표기 class : card-cover 추가하고 아래 숫자표기-->
											<ul class="card-columns">
<?
$query = "select * from gf_page_photo where fk_page_article = '{$row[pk_page_article]}'";
$resultPHOTO = db_query($query);
for ($i=0; $i<mysqli_num_rows($resultPHOTO); $i++){
	$rowPHOTO = mysqli_fetch_array($resultPHOTO);
?>
												<li class="card border-none">
													<span data-lightbox="review">
													<a href="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],500,500,"2","")?>" data-lightbox="menu">
														<img class="card-img img-fluid" src="<?=phpThumb("/_UPLOAD/".$rowPHOTO['이미지파일명'],110,110,"2","")?>" alt="" />
													</a>
													</span>
												</li>
<?}?>

											</ul>
										</div>
										<!--//사진-->
									<!-- </a> -->
										<!--버튼-->
										<div class="page-box text-center">
											<div class="row m-0">
												<div class="col p-0 ">
													<div class="checkbox">
														<input id="chk1" name="chk_good" type="checkbox" class="invisible">
														<label for="chk1" class="color-5 mb-0 fw-400" onClick="go_like('<?=$row['pk_page_article']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary"><?=number_format(좋아요카운트($row['pk_page_article']))?></span></label>
													</div>
												</div>
												<div class="col p-0">
													<a href="page_boardview.php?pk_page_article=<?=$row['pk_page_article']?>"><i class="far fa-comment-dots fs-005 pr-1"></i> 댓글<span class="color-primary"><?=number_format(댓글수카운트($row['pk_page_article']))?></span></a>
												</div>
												<!-- <div class="col p-0">
													<a href="javascript:copyToAddress('page-address')"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>

													<span id="copyAddress" class="text-address">https://golfen.kr/pay/page_user.php?UID=<?=$row[UID]?></span>

												</div> -->
											</div>
										</div>
										<!--//버튼-->
								</li>

<?}?>