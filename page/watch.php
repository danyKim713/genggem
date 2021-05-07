<?
    include "./inc_program.php"; 
    

    
    $strRecordNo = $_GET["txtRecordNo"];


    // 현재 크리에이터 정보 가져오기
//    $query  = " SELECT member_id, UID  \n";
//    $query .= " FROM   tbl_member   \n";
//    $query .= " WHERE  UID='".$strRecordNo."'   \n";  
//    $rowCreatorInfo = db_select($query); 


    // 현재 크리에이터 정보 가져오기
    $query  = " SELECT A.member_id, A.member_uid, A.cat_id, A.creator_title, A.creator_explanation, B.페이지배경사진, B.페이지프로필사진   \n";
    $query .= " FROM   tbl_watch_setup A, tbl_member B   \n";
    $query .= " WHERE  A.member_uid = '{$strRecordNo}'   \n";  
    $query .= " AND    A.member_id = B.member_id   \n";  
    $rowWatchSet = db_select($query); 


    // 현재 크리에이터 구독자 수 
    $query  = " SELECT COUNT(wvs_id) AS cnt \n";
    $query .= " FROM   tbl_watch_video_subscription    \n";
    $query .= " WHERE  member_id='".$rowWatchSet["member_id"]."'   \n";  
    $rowSubscription = db_select($query);


    // 현재 크리에이터 영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.member_id='".$rowWatchSet["member_id"]."'   \n";   
    $query .= " AND  A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.member_id = B.member_id   \n";      
    $query .= " ORDER BY A.wv_id DESC   \n";

    $resultCreator = db_query($query); 

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<body class="mb-5">
<? include "./inc_nav.php"; ?>
    <div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg10.jpg);">
            <h2>Craft Video</h2>
        </div>
    </div>

	<? include "./inc_watch_nav.php"; ?>

	<!-- ##### Watch Area Start ##### -->
    <section class="alazea-blog-area">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h2>Creator</h2>
				</div>

				<!-- Search by Terms -->
				<? include "./inc_watch_search.php"; ?>
				<!-- Search by Terms -->			
			</div>

            <div class="row">				
				<div class="col-12 col-md-4">
                    <article class="con-watch mb-2 mt-2">	
						<!--영상정보-->
						<div class="con-watch-view py-4 px-3">
							<div class="con-watch-post d-flex align-items-start">
								<div class="page-profile text-center">
                                    <img src="<?=phpThumb("/_UPLOAD/".($rowWatchSet['페이지프로필사진']?$rowWatchSet['페이지프로필사진']:$rowWatchSet['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="80" height="80" class="rounded-circle">
									<div class="mt-2">
										<button type="button" class="btn-add btn btn-gray btn-sm btn-capsule btn-block"><i class="fas fa-check mr-1"></i>구독중</button>
										<a href="page_user.php?UID=<?=$rowWatchSet["member_uid"]?>"><button type="button" class="btn-add btn btn-outline-primary btn-sm btn-capsule btn-block mt-1">페이지보기</button></a>
									</div>
								</div>
								<div class="page-write col lh-3 pr-0">
									<div class="d-flex align-items-start justify-content-between">
										<div>
											<h5 class="fs-005 mb-1"><?=$rowWatchSet["creator_title"]?></h5>
											<span class="txt"><i class="fas fa-user opacity-50 mr-1 fs--1"></i>구독 <?=$rowSubscription["cnt"]?>명</span>
										</div>
									</div>
									
									<p class="description fs-005 fw-300 my-3"><?=$rowWatchSet["creator_explanation"]?>
									</p>
									<button type="button" class="btn-more btn btn-info2 btn-sm fs--1">더보기</button>
								</div>
							</div>
						</div>
					</article>
                </div>
				
				
				
				<div class="col-12 col-md-8">

					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between mt-4">					
							
						<!-- Shop Page Count -->
						<div class="section-heading">
							<h2><font color="#0066ff">Upload</font> Video</h2>
							<p>크리에이터가 업로드한 영상</p>
						</div>						
					</div>

					<div class="row">
						
						<?
							while ($rowCreator = mysqli_fetch_array($resultCreator)) { 
							$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
							$query .= " FROM   tbl_watch_video_subscription   \n";
							$query .= " WHERE  member_id = '{$rowCreator["member_id"]}'    \n";
							$rowSubscription = db_select($query);

							//유투브 썸네일 처리
							$v = getYoutubeIdFromUrl($rowCreator['v_link']);
							$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="265" height="200">';
						?>	
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-4">
							<div class="single-blog-post mb-30">
								<a href="watch_view.php?txtRecordNo=<?=$rowCreator["wv_id"]?>" title="">
									<div class="post-thumbnail mb-3">
										<?=$strImg?>
									</div>
									<div class="con-info con-lesson">
										<h4 class="fs-0 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowCreator['creator_title']?></h4>
										<p class="color-5"><?=cutstr($rowCreator['v_title'], 80)?></p>
										<span class="color-6 fs--1"><i class="fas fa-play-circle opacity-70 mr-1"></i><?=number_format($rowCreator["view_cnt"])?>회</span>
										<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-70 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</span>	
									</div>
								</a>
							</div>						
						</div>
						<?}?>

					</div>

                </div>
            </div>
        </div>
    </section>
    <!-- ##### End ##### -->




	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_vod.php"; ?>
</body>
<script>
	$('.btn-more').on("click",function(){
		$('.description').toggleClass('full');
		if($('.description').hasClass('full')){
	$(this).text('간략히');         
		} else {
				$(this).text('더보기');
		}
	});
	$('.nav_category li[data-name="gnb-watch"]').addClass('active');
	$('.nav_bottom li[data-name="watchhome"]').addClass('active');
</script>
</html>