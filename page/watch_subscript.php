<?
    include "./inc_program.php"; 
    
    // 내가 구독한 크리에이터 정보 가져오기
    $query  = " SELECT B.creator_title, B.member_id, B.member_uid, C.페이지배경사진, C.페이지프로필사진   \n";
    $query .= " FROM   tbl_watch_video_subscription A, tbl_watch_setup B, tbl_member C  \n";
    $query .= " WHERE  A.isrt_user='".$ck_login_member_pk."'   \n";  // 내가 구독한 것만
    $query .= " AND    A.member_id = B.member_id   \n";    
    $query .= " AND    A.member_id = C.member_id   \n";    
    $query .= " ORDER BY A.wvs_id DESC   \n";
    $resultSubscription = db_query($query); 
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
    <section class="alazea-blog-area mt-3 mb-30">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h3><font color="#ff0066">구독 </font>채널</h3>
					<span>구독중인 채널/영상입니다.</span>
				</div>
				<!-- Search by Terms -->
				<? include "./inc_watch_search.php"; ?>
				<!-- Search by Terms -->	
			</div>

            <div class="row">
				<div class="col-12 col-md-12">


					<div class="row">
						<?
							while ($rowSubscription = mysqli_fetch_array($resultSubscription)) {
								// 등록영상수 가져오기
								$query  = " SELECT COUNT(wv_id) AS cnt  \n";
								$query .= " FROM   tbl_watch_video   \n";
								$query .= " WHERE  member_id = {$rowSubscription["member_id"]}   \n";  
								$query .= " AND    approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
								$query .= " AND    use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  

								$rowReg = db_select($query);

								$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
								$query .= " FROM   tbl_watch_video_subscription   \n";
								$query .= " WHERE  member_id = '{$rowSubscription["member_id"]}'    \n";

								$rowSubs = db_select($query);								
						?>
						<!-- Single CAFE Post Area -->
						<div class="col-12 col-md-12 col-lg-4">
							<div class="list list-default mt-3 mb-30">
								<a href="watch.php?txtRecordNo=<?=$rowSubscription["member_uid"]?>" title="">
										<div>
										<img src="<?=phpThumb("/_UPLOAD/".($rowSubscription['페이지배경사진']?$rowSubscription['페이지배경사진']:$rowSubscription['페이지프로필사진']),150,150,"2","assets/images/ex_img6.jpg")?>" width="150" height="150" class="radius-5"/>
									</div>
									<div class="con-info">
										<h4 class="fs-0 ellipsis"><?=$rowSubscription["creator_title"]?></h4>
										<span class="color-6 fs--1"><i class="fab fa-youtube opacity-60 mr-1"></i>등록영상 <?=$rowReg["cnt"]?></span>
										<br>
										<span class="color-6 fs--1"><i class="fas fa-user opacity-60 mr-1"></i>구독자 <?=$rowSubs["cnt"]?>명</span>
										<div class="mt-2">
											
											<a href="watch.php?txtRecordNo=<?=$rowSubscription["member_uid"]?>" class="btn btn-primary btn-xs btn-capsule"><i class="fas fa-eye fs--1 opacity-60"></i> 영상보기</a>
										</div>
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
</script>
</html>