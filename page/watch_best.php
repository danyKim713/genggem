<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<?
    $strSearchText = trim($_GET["txtSearchText"]);
    $query_where = "";
    if ($strSearchText != "") {
        $query_where = " AND    A.v_title LIKE '%{$strSearchText}%'  \n"; 
    }

    // 추천영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= " AND    A.exposure_flg = 'EXPOSREC'  \n";   // 노출위치가 추천영상인 것만
    $query .= $query_where;
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultRecom = db_query($query); 
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
					<h3><font color="#ff0066">인기 </font>영상</h3>
					<span>회원님이 많이 시청한 영상입니다.</span>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='watch_search.php' class="form-inline mb-2">
						<select class="custom-select" onchange="window.open(value,'_self');">
							<option selected>영상분류</option>					
							<?
								for ($i=1; $i<=count($cat_nm); $i++){
								$m = $i<10?"0".$i:$i;
							?>
							<option value="watch_search.php?txtRecordNo=<?=$cat_nm[$i-1]?>" title='<?=$cat_nm[$i-1]?>'><?=$cat_nm[$i-1]?></a></option>
							<?}?>
						</select>
						<input class="form-control mr-2" id="txtSearchText" name="txtSearchText" type="text" placeholder="영상을 검색해 보세요." style="width:170px;" />
						<button class="btn btn-info3" id="btnSearch"><i class="fas fa-search"></i> 검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>

            <div class="row">
				<div class="col-12 col-md-12">


					<div class="row">
						<?
							while($rowRecom = mysqli_fetch_array($resultRecom)) {

								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowRecom["member_id"]}'    \n";
								$rowSubscription = db_select($query);

								//유투브 썸네일 처리
								$v = getYoutubeIdFromUrl($rowRecom['v_link']);
								$strImg = '<img src="https://img.youtube.com/vi/'.$v.'/default.jpg" width="265" height="200">';


						?>
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-12 col-lg-3">
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