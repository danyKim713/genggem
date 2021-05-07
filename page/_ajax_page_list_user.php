<?
include "include_save_header.php";
?>

<? 
$pageScale = 10;

$start = ($pageNo-1)*$pageScale;
$limit = " LIMIT ".$start.", ".$pageScale;

$query = "select * from gf_page_article where member_id = (select member_id from tbl_member where UID = '{$UID}') order by pk_page_article DESC {$limit} ";
$result = db_query($query);

while($row = db_fetch($result)){
?>
								<li>
									
									<!-- <a href="page_boardview.php" title="" class="clearfix"> -->
										<!--날짜,글,태그-->
										<a href="page_boardview.php?pk_page_article=<?=$row['pk_page_article']?>" title="" class="clearfix">
										<div class="page-write">
											<span class="date"><?=date("Y년 m월 d일 H:i", strtotime($row['등록일시']))?></span>
											<p class="post"><?=$row['내용']?>&nbsp; <button class="btn btn-info2 btn-xs btn-capsule">+more</button></p>
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
														<input id="chk1" name="chk_good" type="checkbox" class="invisible good_<?=$row['pk_page_article']?>" <?=좋아요카운트($row['pk_page_article'])>0?"checked":""?>>
														<label for="chk1" class="color-5 mb-0 fw-400" onClick="go_like('<?=$row['pk_page_article']?>');"><i class="far fa-thumbs-up fs-005 pr-1 color-5" ></i>좋아요 <span class="color-primary"><?=number_format(좋아요카운트($row['pk_page_article']))?></span></label>
													</div>
												</div>
												<div class="col p-0">
													<a href="page_boardview.php?pk_page_article=<?=$row['pk_page_article']?>"><i class="far fa-comment-dots fs-005 pr-1"></i> 댓글 <span class="color-primary"><?=number_format(댓글수카운트($row['pk_page_article']))?></span></a>
												</div>
												<!-- <div class="col p-0">
													<a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>
												</div> -->
											</div>
										</div>
										<!--//버튼-->
								</li>

<?}?>