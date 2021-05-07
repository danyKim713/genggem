<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<?

	$strSearchCat = $_GET["selSearchCat"];
    $strSearchText = trim($_GET["txtSearchText"]);
    $arrWhere = array();

	$strSearchCatNM = "";

    if ($strSearchCat != "") {
        $arrWhere[] = "     A.cat_id = '{$strSearchCat}'  \n"; 
		$query = "SELECT cat_nm FROM tbl_watch_category WHERE cat_id = {$strSearchCat} ";
		$rowCatNM = db_select($query); 
		$strSearchCatNM = $rowCatNM["cat_nm"];
    }

    if ($strSearchText != "") {
        $arrWhere[] = "     A.v_title LIKE '%{$strSearchText}%'  \n"; 
    }

	$strWhere = implode(' AND ', $arrWhere);

	if (trim($strWhere) != "") {
		$strWhere  = " WHERE  " . $strWhere . " AND    ";
	} else {
		$strWhere .= " WHERE ";
	}

    // 추천영상정보 가져오기[구독중인 영상채널 6개, 최근시청한 영상4개 리스팅]
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " {$strWhere}   \n";
    $query .= "        A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.exposure_flg = 'EXPOSREC'  \n";   // 노출위치가 추천영상인 것만
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY RAND() LIMIT 4   \n";

    $resultRecom = db_query($query); 

    // 신규영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " {$strWhere}   \n";
    $query .= "        A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY A.wv_id DESC   \n";
    $query .= " LIMIT 50   \n";

    $resultNew = db_query($query); 

?>
<body class="mb-5">
<? include "./inc_nav.php"; ?>
    <div class="breadcrumb-area">
        <!-- Top background Area -->
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
					<h4><font color="#ff0066"><?if ($strSearchCat != "") {?>'<?=$strSearchCatNM?>'<?}?> </font>추천영상</h4>
					<span>회원님께 추천드리는 영상입니다.</span>
				</div>

				<!-- Search by Terms -->
				<? include "./inc_watch_search.php"; ?>
				<!-- Search by Terms -->			
			</div>

            <div class="row">
				<div class="col-12 col-md-12">


					<div class="row">
						<?
							while ($rowRecom = mysqli_fetch_array($resultRecom)) { 
								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowRecom["member_id"]}'    \n";
								$rowSubscription = db_select($query);

								//유투브 썸네일 처리
								$v = getYoutubeIdFromUrl($rowRecom['v_link']);
								$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="300" height="226">';
						?>
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-3">
							<div class="single-blog-post mb-30">
								<a href="watch_view.php?txtRecordNo=<?=$rowRecom['wv_id']?>" title="">
										<div class="post-thumbnail mb-3">
											<?=$strImg?>
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowRecom['creator_title']?></h4>
											<p class="color-5"><?=cutstr($rowRecom['v_title'], 68)?></p>
											<span class="color-6 fs--1"><i class="fas fa-play-circle opacity-50 mr-1"></i><?=$rowRecom['view_cnt']?>회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</span>	
										</div>
									</a>

								
							</div>
						</div>
						<?}?>
					</div>

					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">									
							
						<!-- Shop Page Count -->
						<div class="section-heading mt-4">
							<h3><font color="#0066ff">New</font> Video</h3>
							<p><?if ($strSearchCat != "") {?>'<strong><?=$strSearchCatNM?></strong>'에<?}?> 새로 등록된 영상입니다.</p>
						</div>						
					</div>

					<div class="row mb-5">
						
						<?
							while ($rowNew = mysqli_fetch_array($resultNew)) {
								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowNew["member_id"]}'    \n";
								$rowSubscription = db_select($query);

								//유투브 썸네일 처리
								$v = getYoutubeIdFromUrl($rowNew['v_link']);
								$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="265" height="200">';
						?>	
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-12 col-lg-3">
							<div class="single-blog-post mb-30">
								<a href="watch_view.php?txtRecordNo=<?=$rowNew["wv_id"]?>" title="">
									<div class="post-thumbnail mb-3">
										<?=$strImg?>
									</div>
									<div class="con-info con-lesson">
										<h4 class="fs-0 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowNew['creator_title']?></h4>
										<p class="color-5"><?=cutstr($rowNew['v_title'], 85)?></p>
										<span class="color-6 fs--1"><i class="fa fa-play-circle opacity-70 mr-1"></i><?=number_format($rowNew["view_cnt"])?>회</span>
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
	$('.nav_bottom li[data-name="watchhome"]').addClass('active');

    $(document).ready(function(){
        // 구독중 클릭시
        $(document).on('click', '#btnSearch', function(event) {
            $('#frmBest').submit();
        });
	});
</script>
</html>