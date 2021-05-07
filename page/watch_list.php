<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";
?>

<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<?
	
	// 영상설정정보 가져오기
    $query  = " SELECT member_id, member_uid, cat_id, creator_title  \n";
    $query .= " FROM   tbl_watch_setup   \n";
    $query .= " WHERE  member_id='".$ck_login_member_pk."'   \n";  // 인증된 영상
    $resultWatchSet = db_query($query); 


    $strWatchSetCat = "";

    if ($resultWatchSet) {
        $rowWatchSetCat = mysqli_fetch_array($resultWatchSet);
        $strWatchSetCat = $rowWatchSetCat["cat_id"];
    }


    // 맞춤영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.cat_id IN ({$strWatchSetCat})   \n";   // 영상설정의 관심영상카테고리에 속한 영상만
    $query .= " AND    A.use_flg = 'AD005001'   \n";   //  사용여부가 사용인것만  
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY RAND() LIMIT 4   \n";

    $resultSetMovie = db_query($query); 

    // 추천영상정보 가져오기[구독중인 영상채널 6개, 최근시청한 영상4개 리스팅]
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.exposure_flg = 'EXPOSREC'  \n";   // 노출위치가 추천영상인 것만
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY RAND() LIMIT 4   \n";

    $resultRecom = db_query($query); 

    // 신규영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY A.wv_id DESC   \n";
    $query .= " LIMIT 50   \n";

    $resultNew = db_query($query); 


?>


<body class="mb-5">
<? include "./inc_nav.php"; ?>
    <div class="breadcrumb-area">
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg10.jpg);">
            <h2>Craft Video</h2>
        </div>
    </div>

	<? include "./inc_watch_nav.php"; ?>

	<?/*-- 영상카테고리 기존 불러오기
	<div class="category-area2 mt-3">
		<!-- category Area -->
		<div class="row">
			<div class="col-12 col-sm-12 col-lg-12 text-center">
				<div class="single-footer-widget">
					<div class="social-info">
						<? 
							$query = "SELECT * FROM tbl_watch_category WHERE use_flg='AD005001' ORDER BY seq ";
							$resultCategory = db_query($query); 

							while ($row = mysqli_fetch_array($resultCategory)) {
								$strImg = "";
								// 이미지 
								if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchCatImg/".$row['cat_img'])) { 
									$strImg = "<img src=\"/ImgData/WatchCatImg/{$row["cat_img"]}\" width=\"30\"  alt=\"{$row["cat_nm"]}\">";
								}
						?>
						<a href='watch_category.php?txtRecordNo=<?=$row["cat_id"]?>' title='<?=$row["cat_nm"]?>'>
							<?=$strImg?> <?=$row["cat_nm"]?>
						</a>
						<? } ?>
					</div>
				</div>
			</div>
		</div>
	</div> --*/?>


	<!-- ##### Watch Area Start ##### -->
    <section class="alazea-blog-area">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h2>Video</h2>
				</div>

				<!-- Search by Terms -->
				<? include "./inc_watch_search.php"; ?>
				<!-- Search by Terms -->			
			</div>

            <div class="row">				
				<div class="col-12 col-md-4">
                    <div class="post-sidebar-area">

                        <!-- ##### Single Widget Area ##### -->
						<div class="single-widget-area">
							<div class="post-thumb mb-4">
								 <a href=""><img src="assets/img/bg-img/cafe_guide.jpg" width="100%" height="75" class="radius-5" /></a>
							</div>

							<div class="widget-title mt-5 shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
								<div class="section-heading">
									<h4><font color="#ff3399">맞춤</font> 영상</h4>
									<p>회원님 맞춤영상입니다.</p>
								</div>
							</div>


                            <!-- Single Latest Posts -->
							<?
								while ($rowSetMovie = db_fetch($resultSetMovie)) { 

									$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
									$query .= " FROM   tbl_watch_video_subscription   \n";
									$query .= " WHERE  member_id = '{$rowSetMovie["member_id"]}'    \n";
									$rowSubscription = db_select($query);

									//유투브 썸네일 처리
									$v = getYoutubeIdFromUrl($rowSetMovie['v_link']);
									$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="150" height="113">';
									
							?>
							<a href="watch_view.php?txtRecordNo=<?=$rowSetMovie["wv_id"]?>" title="">
                            <div class="single-latest-post d-flex align-items-center">
                                <div class="post-thumb">
                                     <?=$strImg?>
                                </div>
                                <div class="post-content">
									<a href="watch_view.php?txtRecordNo=<?=$rowSetMovie["wv_id"]?>" title=""><h4 class="fs-005 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowSetMovie['creator_title']?></h4>
									<p class="color-5 ellipsis-2"><?=cutstr($rowSetMovie['v_title'], 75)?></p>
									<span class="color-6 fs--1"><i class="fa fa-play-circle opacity-70 mr-1"></i><?=number_format($rowSetMovie['view_cnt'])?></span> <span class="bar"></span> <span class="color-6 fs--1"><i class="fas fa-bookmark opacity-70 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</a>
                                </div>
                            </div>
							</a>
							<?}?>
                            
                        </div>
                        
                    </div>
                </div>
				
				
				
				<div class="col-12 col-md-8">
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">									
							
						<!-- Shop Page Count -->
						<div class="section-heading">
							<h2><font color="#ff0066">추천</font> 영상</h2>
							<p>회원님께 추천드리는 영상입니다.</p>
						</div>
						<!-- <div class="search_by_terms">
							<a href="#"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-comments fs--1 color-warning"></i> 가입카페 전체보기</button></a>	
						</div> -->
					</div>


					<div class="row justify-content-center">
						<?
							while ($rowRecom = mysqli_fetch_array($resultRecom)) { 

								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowRecom["member_id"]}'    \n";
								$rowSubscription = db_select($query);

								//$strImg = "";

								//if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchVideo/{$rowMember["UID"]}/".$rowRecom['v_thumbnail'])) { 
									//$strImg = "<img src=\"/ImgData/WatchVideo/{$rowMember["UID"]}/{$rowRecom["v_thumbnail"]}\" width=\"150\" height=\"84\">";
								//}

								//$src = phpThumb('/ImgData/WatchVideo/'.$rowRecom["member_uid"].'/'.$rowRecom["v_thumbnail"],150,84,"2","");

								//$strImg = '<img src="'.$src.'"/>';

								//유투브 썸네일 처리
								$v = getYoutubeIdFromUrl($rowRecom['v_link']);
								$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="265" height="200">';

						?>
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-3">
							<div class="single-blog-post mb-20">
								<a href="watch_view.php?txtRecordNo=<?=$rowRecom["wv_id"]?>" title="">
									<div class="post-thumbnail mb-3">
										<?=$strImg?>
									</div>
									<div class="con-info con-lesson">
										<h4 class="fs-0 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowRecom['creator_title']?></h4>
										<p class="color-5"><?=cutstr($rowRecom['v_title'], 56)?></p>
										<span class="color-6 fs--1"><i class="fa fa-play-circle opacity-70 mr-1"></i><?=$rowRecom['view_cnt']?>회</span>
										<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-bookmark opacity-70 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</span>	
									</div>
								</a>
								
							</div>
						</div>
						<?}?>
					</div>

					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between mt-4">									
							
						<!-- Shop Page Count -->
						<div class="section-heading">
							<h2><font color="#0066ff">New</font> Video</h2>
							<p>새로 등록된 영상입니다.</p>
						</div>						
					</div>

					<div class="row">
						
						<?
							while ($rowNew = mysqli_fetch_array($resultNew)) { 
								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowNew["member_id"]}'    \n";
								$rowSubscription = db_select($query);

								//$strImg = "";

								//if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchVideo/{$rowMember["UID"]}/".$rowNew['v_thumbnail'])) { 
									//$strImg = "<img src=\"/ImgData/WatchVideo/{$rowMember["UID"]}/{$rowNew["v_thumbnail"]}\" width=\"150\" height=\"84\">";
									//$strImg = '<img src="'.$src.'" width="150" height="84"/>';
								//}

								//$src = phpThumb('/ImgData/WatchVideo/'.$rowNew["member_uid"].'/'.$rowNew["v_thumbnail"],150,84,"2","");

								//$strImg = '<img src="'.$src.'" width="150" height="84"/>';

								//유투브 썸네일 처리
								$v = getYoutubeIdFromUrl($rowNew['v_link']);
								$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="265" height="200">';
						?>	
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-4">
							<div class="single-blog-post mb-30">
								<a href="watch_view.php?txtRecordNo=<?=$rowNew["wv_id"]?>" title="">
									<div class="post-thumbnail mb-3">
										<?=$strImg?>
									</div>
									<div class="con-info con-lesson">
										<h4 class="fs-0 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowNew['creator_title']?></h4>
										<p class="color-5"><?=cutstr($rowNew['v_title'], 85)?></p>
										<span class="color-6 fs--1"><i class="fa fa-play-circle opacity-70 mr-1"></i><?=number_format($rowNew["view_cnt"])?>회</span>
										<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-bookmark opacity-70 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</span>	
									</div>
								</a>
								
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
	$('.nav_bottom li[data-name="watchhome"]').addClass('active');

	$(document).ready(function(){
	});
</script>
</html>