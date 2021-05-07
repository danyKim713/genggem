<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<?
	$strSearchCat = $_GET["selSearchCat"];
    $strSearchText = trim($_GET["txtSearchText"]);
    $query_where = "";
    if ($strSearchCat != "") {
        $query_where .= " AND    A.cat_id = '{$strSearchCat}'  \n"; 
    }

    if ($strSearchText != "") {
        $query_where .= " AND    A.v_title LIKE '%{$strSearchText}%'  \n"; 
    }

    // 영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= $query_where;
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultSearch = db_query($query); 
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


	<!-- ##### Watch Area Start ##### -->
    <section class="alazea-blog-area">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h3>영상검색</h3>
					<span><?if (trim($strSearchText) != "") echo "'".trim($strSearchText)."'으로"; ?> 검색한 결과입니다.</span>
				</div>

				<!-- Search by Terms -->
				<? include "./inc_watch_search.php"; ?>
				<!-- Search by Terms -->				
			</div>

            <div class="row">
				<div class="col-12 col-md-12">


					<div class="row">
						<?
							while($rowSearch = mysqli_fetch_array($resultSearch)) {
								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowSearch["member_id"]}'    \n";
								$rowSubscription = db_select($query);

								//유투브 썸네일 처리
								$v = getYoutubeIdFromUrl($rowSearch['v_link']);
								$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="265" height="200">';
						?>
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-3">
							<div class="single-blog-post mb-30">
								<a href="watch_view.php?txtRecordNo=<?=$rowSearch["wv_id"]?>" title="">
									<div class="post-thumbnail mb-3">
										<?=$strImg?>
									</div>
									<div class="con-info con-lesson">
										<h4 class="fs-0 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowSearch['creator_title']?></h4>
										<p class="color-5"><?=cutstr($rowSearch['v_title'], 90)?></p>
										<span class="color-6 fs--1"><i class="fas fa-play-circle opacity-50 mr-1"></i><?=number_format($rowSearch['view_cnt'])?>회</span>
										<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</span>	
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
	});


</script>
</html>