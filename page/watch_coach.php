<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<?
    $strRecordNo   = $_GET["txtRecordNo"];
    $strSearchText = trim($_GET["txtSearchText"]);


    $query_where = "";
    if ($strSearchText != "") {
        $query_where = " AND    A.v_title LIKE '%{$strSearchText}%'  \n"; 
    }

    // 현재 코치의 영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.member_uid = '{$strRecordNo}'   \n";  
    $query .= " AND    A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";       //  사용여부가 사용인것만  
    $query .= $query_where;
    $query .= " AND    A.member_id = B.member_id   \n";   
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultCoachWatch = db_query($query); 



    // 현재 코치의 영상정보 가져오기
    $query  = " SELECT creator_title  \n";
    $query .= " FROM   tbl_watch_setup    \n";
    $query .= " WHERE  member_uid = '{$strRecordNo}'   \n";  

    $rowWatchSet = db_select($query); 


?>
<body class="mb-6">
	<? include "./inc_Top.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					<!--tab-->
					<div id="tab-menu" class="clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0 active"><a href="watch_list.php" title="영상">영상목록</a></li>
							<li class="col p-0"><a href="watch_upload.php" title="영상등록">영상등록</a></li>
							<li class="col p-0"><a href="watch_my.php" title="내영상">내영상</a></li>
						</ul>
					</div>
					<!--tab-->	

					<!--영상 검색-->
					<article class="mb-2 mt-5">
						<div class="p-3 position-r">
							<div class="w-75">
                                <form name='frmCoach' id='frmCoach' method='get' action='watch_coach.php'>
                                <input type="hidden" name="txtRecordNo" id="txtRecordNo" value="<?=$strRecordNo?>">
								<input type="text" class="form-control" id="txtSearchText" name="txtSearchText" placeholder="영상을 검색해 보세요."  value="<?=$strSearchText?>" />
								<button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-3 mb-1" id="btnSearch">검색</button>
                                </form>
							</div>
						</div>
					</article>
					<!--//영상 검색-->

					<!--인기/추천 영상 : 구독중인 채널의 영상 랜덤출력 // 관심카테고리 영상 랜덤 출력 // 리스팅 무제한 -->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">'<?=$rowWatchSet["creator_title"]?>' 영상</h3>
						<div class="list list-default mt-3">
							<ul>
<?
    while($rowCoachWatch = mysqli_fetch_array($resultCoachWatch)) {
        $query  = " SELECT COUNT(wvs_id) AS cnt   \n";
        $query .= " FROM   tbl_watch_video_subscription   \n";
        $query .= " WHERE  member_id = '{$rowCoachWatch["member_id"]}'    \n";
        $rowSubscription = db_select($query);


        $strImg = "";
		$src = phpThumb('/ImgData/WatchVideo/'.$rowCoachWatch["member_uid"].'/'.$rowCoachWatch["v_thumbnail"], 150, 84,"2","");
		$strImg = '<img src="'.$src.'"/>';
?>
								<li>
									<a href="watch_view.php?txtRecordNo=<?=$rowCoachWatch["wv_id"]?>" title="">
										<div>
											<?=$strImg?>
										</div>
										<div class="con-info con-lesson">
											<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> <?=$rowCoachWatch['creator_title']?></h4>
											<p class="color-5"><?=cutstr($rowCoachWatch['v_title'], 58)?></p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i><?=$rowCoachWatch['view_cnt']?>회</span>
											<span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</span>	
										</div>
									</a>
								</li>
<?
    }
?>

							</ul>
						</div>
					</article>
					<!--//인기 영상-->
					
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
	$('.nav_category li[data-name="gnb-watch"]').addClass('active');
	$('.nav_bottom li[data-name="watchbest"]').addClass('active');

	$(document).ready(function(){
        // 구독중 클릭시
        $(document).on('click', '#btnSearch', function(event) {
            $('#frmCoach').submit();
        });
	});


</script>
</html>