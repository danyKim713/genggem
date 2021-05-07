<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<?
    //현재 크리에이터 정보 가져오기
    $query  = " SELECT member_id, UID, 페이지프로필사진, 페이지배경사진  \n";
    $query .= " FROM   tbl_member   \n";
    $query .= " WHERE  UID='".$rowMember["UID"]."'   \n";  
    $rowCreatorInfo = db_select($query); 
echo $query;
	// 영상설정정보 가져오기
    $query  = " SELECT member_id, member_uid, cat_id, creator_title, creator_explanation  \n";
    $query .= " FROM   tbl_watch_setup   \n";
    $query .= " WHERE  member_id='".$ck_login_member_pk."'   \n";  // 인증된 영상
    $rowWatchSet = db_select($query); 

    // 내영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.member_id='".$ck_login_member_pk."'   \n";  // 내영상만
    $query .= " AND    A.member_id = B.member_id   \n";      
    $query .= " ORDER BY A.wv_id DESC   \n";

    $resultMy = db_query($query); 

    // 나의 구독자 수 
    $query  = " SELECT COUNT(wvs_id) AS cnt \n";
    $query .= " FROM   tbl_watch_video_subscription    \n";
    $query .= " WHERE  member_id='".$ck_login_member_pk."'   \n";  // 내영상만
    $rowSubscription = db_select($query)

?>
<body class="mb-6">

<header class="header top_fixed">
    <a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
    <h2 class="header-title text-center">내영상관리</h2>
</header>

	<section>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-10 col-xl-6 px-0">

					<article class="con-watch mb-2 mt-5">	
						<!-- 크리에이터 정보 -->
						<div class="con-watch-view py-4 px-3">
							<div class="con-watch-post d-flex align-items-start">

								<div class="page-profile text-center">
									<!-- 아티스트 사진 -->
									<img src="<?=phpThumb("/_UPLOAD/".($rowCreatorInfo['페이지프로필사진']?$rowCreatorInfo['페이지프로필사진']:$rowCreatorInfo['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="80" height="80" class="rounded-circle">

									<div class="mt-2">
										<!-- <button type="button" class="btn-add btn btn-gray btn-sm btn-capsule btn-block"><i class="fas fa-check mr-1"></i>구독중</button> -->
										<a href="page_me.php"><button type="button" class="btn-add btn btn-primary btn-sm btn-capsule btn-block mt-1">페이지보기</button></a>
									</div>
								</div>
								<div class="page-write col lh-3 pr-0">
									<div class="d-flex align-items-start justify-content-between">
										<div>
											<h5 class="fs-005 mb-1">크리에이터 제목 : <?=$rowWatchSet["creator_title"]?></h5>
											<span class="txt"><i class="fas fa-user opacity-50 mr-1 fs--1"></i>구독 <?=$rowSubscription["cnt"]?>명</span>
										</div>
									</div>
									<p class="description fs-005 fw-300 my-3"><?=$rowWatchSet["creator_explanation"]?>
									</p>
									<button type="button" class="btn-more btn btn-info2 p-1 fs--01">더보기</button>
								</div>
							</div>
						</div>
					</article>

					<!--내가 등록한 영상 : 등록한 영상 모두 리스팅 : 등록 날짜 최근순-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">업로드한 영상</h3>
						<div class="list list-default mt-3">
							<ul>
							<?
								while ($rowMy = mysqli_fetch_array($resultMy)) { 
									//$strImg = "";

								   // if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchVideo/{$rowMember["UID"]}/".$rowMy['v_thumbnail'])) { 
									//    $strImg = "<img src=\"/ImgData/WatchVideo/{$rowMember["UID"]}/{$rowMy["v_thumbnail"]}\" width=\"150\" height=\"84\">";
								   // }
									//유투브 썸네일 처리
									$v = getYoutubeIdFromUrl($rowMy['v_link']);
									$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="130" height="100">';
							?>
								<li>
										<div>
											<?=$strImg?>
										</div>
										<div class="con-info con-lesson">
											<span class="fs-0"> 
<?
										if ($rowMy["approval_flg"] == "SAATHYAU") {
?>
											<button type="button" class="btn btn-info2 p-1 fs--01">게재중</button>
<?
										} else if ($rowMy["approval_flg"] == "SAATHNAU") {
?>
											<button type="button" class="btn btn-info3 p-1 fs--01">게재중지</button>
<?
										} else if ($rowMy["approval_flg"] == "SAATHAPY") {
?>
											<button type="button" class="btn btn-info4 p-1 fs--01">게재대기</button>
<?
										} 
?>

											<a btn="수정" href="watch_upload_modify.php?txtRecordNo=<?=$rowMy["wv_id"]?>" class="btn btn-info p-1 fs--01"> 수정 </a>
											</span>
											<p class="color-5 ellipsis-2 mt-2"><a href="watch_view.php?txtRecordNo=<?=$rowMy['wv_id']?>" title=""><?=cutstr($rowMy['v_title'], 58)?></a></p>
											<span class="color-6 fs--1"><i class="fas fa-play-circle opacity-50 mr-1"></i><?=$rowMy['view_cnt']?>회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 <?=$rowSubscription["cnt"]?>명</span>	
										</div>
								</li>
							<?
								}
							?>

							</ul>
						</div>
					</article>
					<!--//내가 등록한 영상-->
					
					<? include "./inc_Bottom_vod.php"; ?>
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	$('.slider-banner').slick({
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 3000
	});
	//더보기
	$('.btn-more').on("click",function(){
		$('.description').toggleClass('full');
		if($('.description').hasClass('full')){
	$(this).text('간략히');         
		} else {
				$(this).text('더보기');
		}
	});
	$('.nav_category li[data-name="gnb-watch"]').addClass('active');
	$('.nav_bottom li[data-name="myvideo"]').addClass('active');
</script>
</html>