<?
    include "./inc_program.php"; 
    

    $strSearchText = trim($_GET["txtSearchText"]);
    $query_where = "";
    if ($strSearchText != "") {
        $query_where = " AND    B.v_title LIKE '%{$strSearchText}%'  \n"; 
    }

    // 내가 좋아요한 영상 정보 가져오기
    $query  = " SELECT B.wv_id, B.member_id, B.member_uid, B.cat_id, B.v_title, B.v_tag, B.v_link, B.v_thumbnail,  \n";
    $query .= "        B.v_open_flg, B.approval_flg, B.exposure_flg, B.v_explanation, B.view_cnt, B.isrt_dt, C.creator_title   \n";
    $query .= " FROM   tbl_watch_video_appraisal A, tbl_watch_video B, tbl_watch_setup C  \n";
    $query .= " WHERE  A.member_id='".$ck_login_member_pk."'   \n";  // 내가 좋아요 한 영상만
    $query .= " AND    B.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    B.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= $query_where;
    $query .= " AND    A.wv_id = B.wv_id   \n";            // 영상ID
    $query .= " AND    A.member_id = B.member_id   \n";    // 영상등록자
    $query .= " AND    A.member_id = C.member_id   \n";    
    $query .= " ORDER BY B.wv_id DESC   \n";

    $resultLike = db_query($query); 
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
					<h3><font color="#ff0066">찜/좋아요 </font>영상</h3>
					<span>회원님께서 찜한 영상입니다.</span>
				</div>

				<!-- Search by Terms -->
				<? include "./inc_watch_search.php"; ?>
				<!-- Search by Terms -->				
			</div>

            <div class="row">
				<div class="col-12 col-md-12">


					<div class="row">
						<?
							while ($rowLike = mysqli_fetch_array($resultLike)) {
								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowLike["member_id"]}'    \n";
								$rowSubscription = db_select($query);

								//유투브 썸네일 처리
								$v = getYoutubeIdFromUrl($rowLike['v_link']);
								$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="265" height="200">';
						?>
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-6 col-lg-3">
							<div class="single-blog-post mb-30">
								<a href="watch_view.php?txtRecordNo=<?=$rowLike["wv_id"]?>" title="">
									<div class="post-thumbnail mb-3">
										<?=$strImg?>
									</div>
									<div class="con-info con-lesson">
										<h4 class="fs-0 ellipsis"><i class="fas fa-video-camera align-text-top fs--1 color-warning mt-1"></i> <?=$rowLike['creator_title']?></h4>
										<p class="color-5"><?=cutstr($rowLike['v_title'], 90)?></p>
										<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i><?=number_format($rowLike['view_cnt'])?>회</span>
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
        // 구독중 클릭시
        $(document).on('click', '#btnSearch', function(event) {
            $('#frmSearch').submit();
        });
	});
</script>
</html>