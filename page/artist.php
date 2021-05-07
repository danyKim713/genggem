<?
    $NO_LOGIN = "Y";
	include "./inc_program.php"; 
    
    $strRecordNo = $_GET["txtRecordNo"];        


    $query  = " SELECT A.co_id, A.member_id, A.coach_career, A.career_memo, A.use_flg, A.recomm_flg, A.memo, B.member_uid, B.background_photo, B.profile_photo, B.lesson_title, B.lesson_greetings, B.lesson_searchword, B.아티스트기본지역, C.UID, C.name, C.country_id, C.시도, C.구군   \n";
    $query .= " FROM   tbl_coach A, tbl_lesson_setup B, tbl_member C \n";
    $query .= " WHERE  A.co_id = '{$strRecordNo}'   \n";    
    $query .= " AND    A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " AND    A.member_id = C.member_id   \n";
    $rowCoach = db_select($query); 

    $strImg = "";
    $strImg2 = "";

    if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchImg/{$rowCoach['member_uid']}/{$rowCoach["background_photo"]}")) { 
        $strImg = "/ImgData/WatchImg/{$rowCoach['member_uid']}/{$rowCoach["background_photo"]}";
    }

    if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchImg/{$rowCoach['member_uid']}/{$rowCoach["profile_photo"]}")) { 
        $strImg2 = "/ImgData/WatchImg/{$rowCoach['member_uid']}/{$rowCoach["profile_photo"]}";
    }

	// 나의 코치 찜정보 가져오기
	$query  = " SELECT COUNT(cz_id) AS cnt   \n";
	$query .= " FROM   tbl_coach_zzim    \n";
	$query .= " WHERE  co_id = '{$strRecordNo}'  \n";
	$query .= " AND    isrt_user = '{$rowMember["member_id"]}'  \n";
	$rowArtistZZim = db_select($query); 

    // 문의글 가져오기
    $query  = " SELECT A.lq_id, A.coach_id, A.member_id, A.member_uid, A.q_memo, A.q_img, A.isrt_dt, B.name, B.페이지배경사진, B.페이지프로필사진, B.닉네임   \n";
    $query .= " FROM   tbl_lesson_question A, tbl_member B  \n";
    $query .= " WHERE  coach_id='{$rowCoach["member_id"]}'   \n"; 
    $query .= " AND    A.member_id = B.member_id   \n";
    $resultQuestion = db_query($query); 
	$nQuestionCnt = mysqli_num_rows($resultQuestion);

    // 레슨 목록
    $query  = " SELECT A.l_id, A.member_id, A.member_uid, A.l_title, A.l_tag, A.l_price, A.cat_id, A.l_area, A.사진1, A.l_intro, A.sale_flg,  B.cat_nm  \n";
    $query .= " FROM   tbl_lesson A, tbl_lesson_category B   \n";
    $query .= " WHERE  A.member_id = '{$rowCoach["member_id"]}'   \n";   
    $query .= " AND    A.sale_flg = 'GS730YSA'   \n";    // 판매중인것만
    $query .= " AND    A.cat_id = B.cat_id   \n";   
    $query .= " ORDER BY l_id DESC   \n";
    $resultLesson = db_query($query); 
	$nLessonCount = mysqli_num_rows($resultLesson);

    // 관련영상 가져오기
    $query  = " SELECT COUNT(wv_id) AS cnt   \n";
    $query .= " FROM   tbl_watch_video   \n";
    $query .= " WHERE  member_id='{$rowCoach["member_id"]}'   \n"; 
    $query .= " AND    approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    use_flg = 'AD005001'   \n"; 

    $resultWatch = db_select($query); 

    // 등록한 영상정보 가져오기
    $query  = " SELECT A.wv_id, A.member_id, A.member_uid, A.cat_id, A.v_title, A.v_tag, A.v_link, A.v_thumbnail,  \n";
    $query .= "        A.v_open_flg, A.approval_flg, A.exposure_flg, A.v_explanation, A.view_cnt, A.isrt_dt, B.creator_title   \n";
    $query .= " FROM   tbl_watch_video A, tbl_watch_setup B   \n";
    $query .= " WHERE  A.member_id='{$rowCoach["member_id"]}'   \n";  // 현재 코치의 영상만
    $query .= " AND    A.approval_flg = 'SAATHYAU'   \n";  // 인증된 영상
    $query .= " AND    A.use_flg = 'AD005001'   \n";   //  사용여부가 사용인것만  
    $query .= " AND    A.member_id = B.member_id   \n";      
    $query .= " ORDER BY A.wv_id DESC   \n";

    $resultWatchList = db_query($query); 
	$nWatchCount = mysqli_num_rows($resultWatchList);
?>

<!DOCTYPE HTML>
<html lang="en">

<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<? include "./inc_class.php"; ?>

    <!-- ##### Blog Content Area Start ##### -->
    <section class="blog-content-area mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Blog Posts Area -->
                <div class="col-12 col-sm-9 col-md-4">
                    <div class="post-sidebar-area">

                        <!-- ##### Single Widget Area ##### -->
                        <div class="single-widget-area">
							<form name='frmSearch' id='frmSearch' method='get' action='artist_search.php' class="search-form">
								<input class="form-control" id="txtSearchText" name="txtSearchText" type="text" placeholder="코치 검색" />
                                <button type="submit" id="btnSearch"><i class="icon_search"></i></button>
                            </form>
                        </div>

                        <!-- ##### Single Widget Area ##### -->
                        <div class="single-widget-area">
                            <!-- Author Widget -->
                            <div class="author-widget">
                                <div class="author-thumb-name d-flex align-items-center">
                                    <!-- 코치 사진 -->
									<div class="author-thumb js-image-preview" style="background-image:url(<?=$strImg2?>)"></div>
                                    <div class="author-name">
                                        <h5><?=$rowCoach['lesson_title']?></h5>
                                        <p onclick="copyToAddress('#copyAddress')" class="address fs--1 d-inline"> 블로그주소<br>
										<span id="copyAddress" class="text-address">https://<?=$_SERVER['HTTP_HOST']?>/page/artist.php?txtRecordNo=<?=$rowCoach["co_id"]?></span>
										<button class="text-copy background-white">공유</button>
										</p>
										<!-- 자신의 블로그인 경우에만 노출 -->
										<? if ($ck_login_member_pk == $rowCoach["member_id"]) { ?>
										<p><a href="class_set.php" class="float-right fs-005 color-6">설정 <i class="fas fa-cog mr-1"></i></a></p>
										<? } ?>
										<!-- // -->
                                    </div>
                                </div>
                                
								<div class="w-100 ml-2 text-center">
									<a href="class_userapply.php?txtRecordNo=<?=$strRecordNo?>"><button type="button" class="btn btn-primary btn-sm btn-capsule mr-2"><i class="fas fa-comment fs--1 opacity-5"></i> 문의/글쓰기</button></a>
									<button type="button" class="btn <?=($rowArtistZZim["cnt"] > 0) ? "btn-info" : "btn-primary";?> btn-sm btn-capsule" id="btnCoachZZim" data-val="<?=$strRecordNo?>"><i class="fas fa-heart fs--1 opacity-5"></i><span id="spnZZim"> <?=($rowArtistZZim["cnt"] > 0) ? "코치 찜해제" : "코치 찜하기";?></span></button>
								</div>
                            </div>
                        </div>


						<div class="single-widget-area user-info">
							<ul class="author-widget user-info-list">
								<li>
									<label><i class="fab fa-font-awesome-flag color-8 fs--1"></i> 국적</label>
									<div class="d-table-cell">
										<span class="fs--1"><?=get_국적($rowCoach['country_id'])?></span>
									</div>
								</li>
								<li>
									<label><i class="fas fa-location-arrow color-8 fs--1"></i> 기본지역</label>
									<div class="d-table-cell">
										<span class="fs--1"><?=$rowCoach['아티스트기본지역']?></span>
									</div>
								</li>
								<li>
									<label><i class="fas fa-gem color-8 fs--1"></i> 등록영상</label>
									<div class="d-table-cell">
										<span class="fs--1">등록영상 <?=number_format($resultWatch["cnt"])?>ea <a href="watch.php?txtRecordNo=<?=$rowCoach["member_uid"]?>"><button class="text-copy background-white">영상보기</button></a></span>
									</div>
								</li>
								<li class="d-flex align-itmes-top mt-2">
									<label><i class="fas fa-bars color-8 fs--1 mt-1"></i> 가입한 카페</label>
									<div class="d-table-cell">
										<ul class="d-inline-block">
											<?
                                        /*
											$query = "select CID, 채널이름, member_id from gf_channel_member A, gf_channel B where A.fk_channel = B.pk_channel and fk_member = '{$rowCoach["member_id"]}' and A.강퇴여부 = 'N' and B.사용여부='Y'

											UNION

											select CID, 채널이름, member_id from gf_channel where member_id = '{$rowCoach["member_id"]}' and 사용여부='Y'

											";
                                        */

											$query  = " SELECT CID, 채널이름, member_id   ";
                                            $query .= " FROM   gf_channel_member A, gf_channel B ";
                                            $query .= " WHERE  A.fk_member = '{$rowCoach["member_id"]}' ";
                                            $query .= " AND    A.강퇴여부 = 'N' ";
                                            $query .= " AND    B.사용여부='Y'  ";
                                            $query .= " AND    A.fk_channel = B.pk_channel  ";
                                            $query .= " AND    A.fk_member = B.member_id  ";
                                            $query .= " UNION  ";
                                            $query .= " SELECT CID, 채널이름, member_id ";
                                            $query .= " FROM   gf_channel ";
                                            $query .= " WHERE  member_id = '{$rowCoach["member_id"]}' ";
                                            $query .= " AND    사용여부='Y'  ";

											//위에건 까페 멤버일 경우고, 밑에건 방장일때일거예요...

        									$resultC = db_query($query);
 
											while($rowC = db_fetch($resultC)){
											?>

											<li>
												<a href="cafe.php?CID=<?=$rowC['CID']?>" title="클럽 바로가기" class="fs--1 color-6"><?=$rowC['채널이름']?> <?if($rowC['member_id']==$rowMember['member_id']){?>(모임장)<?}?></a>
											</li>

											<?}?>
										</ul>	
									</div>
								</li>
							</ul>
						</div>


						<!--등록한 영상 : 관련 영상 리스팅 //랜덤-->
						<div class="single-widget-area">
							<div class="widget-title mt-5 shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
								<div class="section-heading">
									<h4><font color="#ff3399">코치</font> 영상</h4>
									<p>코치가 등록한 영상 입니다.</p>
								</div>
								<div class="search_by_terms">
									<a href="watch.php?txtRecordNo=<?=$rowCoach["member_uid"]?>"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-book-open fs--1 color-warning"></i> 영상 더보기</button></a>	
								</div>
							</div>

<?
	if ($nWatchCount > 0) {
		while ($rowWatchList = mysqli_fetch_array($resultWatchList)) {


			$query  = " SELECT COUNT(wvs_id) AS cnt   \n";
			$query .= " FROM   tbl_watch_video_subscription   \n";
			$query .= " WHERE  member_id = '{$rowWatchList["member_id"]}'    \n";
			 
			$rowSubscription = db_select($query);

			$v = getYoutubeIdFromUrl($rowWatchList['v_link']);
			$src = 'https://img.youtube.com/vi/'.$v.'/default.jpg"';

?>
							<div class="single-latest-post d-flex align-items-center">
                                <div class="post-thumb">
                                     <a href="watch_view.php?txtRecordNo=<?=$rowWatchList["wv_id"]?>" title=""><img src="<?=$src?>" width="150" height="84" /></a>
                                </div>

                                <div class="post-content">
									<a href="watch_view.php?txtRecordNo=<?=$rowWatchList["wv_id"]?>" title="" class="ellipsis"><i class="fas fa-user-circle color-6"></i> <?=$rowWatchList['creator_title']?></a><br>
									<a href="watch_view.php?txtRecordNo=<?=$rowWatchList["wv_id"]?>" title="" class="ellipsis-2"><i class="fas fa-book-open color-6"></i> <?=cutstr($rowWatchList['v_title'], 58)?></a><br>

                                    <a href="watch_view.php?txtRecordNo=<?=$rowWatchList["wv_id"]?>" title="" class="color-5 fs--1"><i class="fas fa-eye opacity-50"></i> <?=number_format($rowWatchList["view_cnt"])?> 회</a><br>
									<!-- <span class="bar"></span><span class="color-6 fs--1"><i class="fas fa-user opacity-50 mr-1"></i>구독자 <?=number_format($rowSubscription["cnt"])?>명</span>	 -->
									
                                </div>
                            </div>
<?
		}
	} else {
?>
							<div class="single-latest-post d-flex align-items-center">
                                등록한 영상이 없습니다.
                            </div>
<?
	}
?>
<!--

							<div class="list list-default mt-3">
								<ul>
								
									<li>
										
											<div>
												
											</div>
											<div class="con-info con-lesson">
												<h4 class="fs-0 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> </h4>
												<p class="color-5"></p>
												<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>회</span>
												
											</div>
										</a>
									</li>
								
								</ul>
							</div>
-->
						</div>
						<!--//등록 영상-->

                    </div>
                </div>			
				
				
				
				
				<div class="col-12 col-md-8">
                    <div class="blog-posts-area">

                        <!-- 배경 / 인사말 -->
                        <div class="single-post-details-area">
                            <div class="post-content">
								<div class="js-image-preview background-10" style="background-image:url(<?=$strImg?>)">
								</div>
                                <blockquote>
                                    <div class="blockquote-text">
                                        <?=str_replace(chr(13), "<br>", $rowCoach["lesson_greetings"])?>
                                    </div>
                                </blockquote>
                            </div>
                        </div>

                        <!-- Post Tags & Share -->
                        <div class="post-tags-share d-flex justify-content-between align-items-center">
                            <!-- Tags -->
                            <ol class="popular-tags d-flex align-items-center flex-wrap">
                                <li><span>Tag:</span></li>
                                <li><?=$rowCoach['lesson_searchword']?></li>
                            </ol>
                            <!-- Share -->
                            <div class="post-share">
                                <!-- <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a> -->
                                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </div>
                        </div>						


						<!-- 등록한 클래스 -->
                        <div class="single-widget-area">
							<div class="widget-title mt-5 shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
								<div class="section-heading">
									<h4>Lesson</h4>
									<p>코치가 등록한 <font color="#ff3399">클래스</font> 입니다.</p>
								</div>
								<div class="search_by_terms">
									<a href="class_list.php?txtSearchText=<?=$rowCoach["lesson_title"]?>"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-book-open fs--1 color-warning"></i> 클래스 더보기</button></a>	
								</div>
							</div>

<?
	if ($nLessonCount > 0) {
			while ($rowLesson = mysqli_fetch_array($resultLesson)) {
				// 나의 클래스 찜정보 가져오기
				$query  = " SELECT COUNT(lz_id) AS cnt   \n";
				$query .= " FROM   tbl_lesson_zzim    \n";
				$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";
				$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";

				$rowZZim = db_select($query);    

				// 전체 클래스 찜정보 가져오기
				$query  = " SELECT COUNT(lz_id) AS cnt   \n";
				$query .= " FROM   tbl_lesson_zzim    \n";
				$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";

				$rowTotalZZim = db_select($query); 
				$strTotalZZim = $rowTotalZZim["cnt"];

				$strCls = ($rowZZim["cnt"] > 0) ? "btn-warning" : "";

				$query  = " SELECT COUNT(cz_id) AS cnt   \n";
				$query .= " FROM   tbl_coach_zzim    \n";
				$query .= " WHERE  co_id = '{$strRecordNo}'  \n";
				$query .= " AND    isrt_user = '{$rowMember["member_id"]}'  \n";


?>


                            <!-- class goods -->
                            <div class="single-latest-post d-flex align-items-center">
                                <div class="post-thumb">
                                     <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowLesson['사진1'],164,120,"2","./assets/images/ex_img6.jpg")?>" width="100%" height="120" class="radius-5" /></a>
                                </div>

                                <div class="post-content">
									<a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>" class="ellipsis-2"><i class="fas fa-book-open color-6"></i> <?=$rowLesson["cat_nm"]?> : <?=$rowLesson["l_title"]?></a><br>
                                    <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>" class="fs-005"><strong><font color="#cc0066"><?=number_format($rowLesson["l_price"])?></font></strong>원<br>
                                    <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>" class="color-5 fs--1"><i class="fas fa-calendar-check opacity-50"></i> <?=$rowLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowLesson["클래스기본지역"]?></a><br>

									<div style="margin-top:5px;"><a href="class_payment.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1 ellipsis"><li class="fas fa-check"></li> 강좌신청</a>
									<a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-search"></li> 상세보기</a>
									<a href="javascript:void()" class="btn-o2 <?=$strCls?> mt-2 mr-1 btnZZim" data-val="<?=$rowLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a></div>
									
                                </div>
                            </div>

<?
			}
	} else {
?>
                            <div class="single-latest-post d-flex align-items-center">
                                등록한 클래스가 없습니다.
                            </div>

<?
	}
?>
                            
                        </div>



                        <!--문의글//페이징없음 무제한 스크롤 리스팅-->
                        <div class="comment_area clearfix">
                            <h4><span class="color-primary"><?=number_format($nQuestionCnt)?></span> Comments</h4>
							
							<div class="mb-2">
								<div class="list list-page">
									<ul>
									<?
										$i = 0;
										while ($rowQuestion = mysqli_fetch_array($resultQuestion)) {

											// 문의댓글 : 현재 회원의 좋아요 선택여부 가져오기
											$query  = " SELECT COUNT(lqa_id) AS cnt    \n"; 
											$query .= " FROM   tbl_lesson_question_appraisal  \n";
											$query .= " WHERE  lq_id = '{$rowQuestion['lq_id']}'   \n"; 

											$rowCommentMyAppraisal = db_select($query); 

											$strCheck = "";
											if ($rowCommentMyAppraisal["cnt"] > 0) {
												$strCheck = "checked";
											}
											// 문의댓글 수 가져오기
											$query  = " SELECT COUNT(lqc_id) AS cnt   \n";
											$query .= " FROM   tbl_lesson_question_comment  \n";
											$query .= " WHERE  lq_id='{$rowQuestion["lq_id"]}'   \n"; 
											$query .= " AND    depth = 1  \n";   // 댓글인 경우만

											$rowComment = db_select($query); 

											$strImg = "";

											// 이미지 
											if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/LessonQuestion/{$strRecordNo}/{$rowQuestion['q_img']}")) { 
												$strImg = "<img class=\"card-img img-fluid\" src=\"/ImgData/LessonQuestion/{$strRecordNo}/{$rowQuestion['q_img']}\" alt=\"\">";
											}


									?>

										<li<?=($rowQuestion['member_id'] == $ck_login_member_pk) ? " class='liQuestion'" : ""; ?>>
									<?     
											if ($rowQuestion['member_id'] == $ck_login_member_pk) {
									?>
											<div class="dropdown position-ab btn-right-top2">
												<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="./class_question_modify.php?txtRecordNo=<?=$rowQuestion["lq_id"]?>" title="글 수정">글 수정</a>
													<a class="dropdown-item btnDelete" href="javascript:void(0)" title="글 삭제">글 삭제</a>
													<input type="hidden" name="txtQuestionID" class="txtQuestionID" value="<?=$rowQuestion["lq_id"]?>">
												</div>
											</div>
										<?
												}
										?>
											


											<li class="single_comment_area">
												<div class="comment-wrapper d-flex">
													<!-- Comment Meta -->
													<div class="comment-author">
														<img src="<?=phpThumb("/_UPLOAD/".($rowQuestion['페이지배경사진']?$rowQuestion['페이지배경사진']:$rowQuestion['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
													</div>
													<!-- Comment Content -->
													<div class="comment-content">
														<div class="d-flex align-items-center justify-content-between">
															<h5><?=$rowQuestion["닉네임"]?></h5>
															<span class="comment-date"><?=str_replace("-", ".", $rowQuestion["isrt_dt"])?></span>
														</div>
														<p><a href="class_read.php?txtRecordNo=<?=$rowQuestion["lq_id"]?>" title="" class="clearfix"><?=$rowQuestion["q_memo"]?></a></p>
														<!-- <a class="active" href="#">ㄴReply</a> -->
														<!--사진-->
														<div class="list-card my-3">
															<!--사진이 3개이상일 경우 숫자표기 class : card-cover 추가하고 아래 숫자표기-->
															<ul class="card-columns">
																<li class="card border-none">
																	<?=$strImg?>
																</li>
															</ul>
														</div>
														<!--//사진-->

														<!--버튼-->
														<div class="page-box text-center">
															<div class="row m-0">
																<div class="col p-0 ">
																	<div class="checkbox">
																		<input type="hidden" name="txtQID[]" class="txtQID" value="<?=$rowQuestion["lq_id"]?>">
																		<input id="chkGood<?=$i?>" name="chkGood[]" type="checkbox" <?=$strCheck?> class="invisible chkGood">
																		<label for="chkGood<?=$i++?>" class="color-5 mb-0 lblGood fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary"><?=$rowCommentMyAppraisal["cnt"]?></span></label>
																	</div>
																</div>
																<div class="col p-0">
																	<a href="class_read.php?txtRecordNo=<?=$rowQuestion["lq_id"]?>"><i class="far fa-comment-dots fs-005 pr-1"></i> 댓글<span class="color-primary"><?=number_format($rowComment["cnt"])?></span></a>
																</div>
															</div>
														</div>
														<!--//버튼-->
													</div>
												</div>
											</li>											
										</li>
									<?
										}
									?>
								
									</ul>
								</div>
							</div>
							<!--//게시글-->







                            <ol>
                                <!-- Single Comment Area -->
                                
                                
                            </ol>
                        </div>

                        

                    </div>
                </div>

                


            </div>
        </div>
    </section>
    <!-- ##### Blog Content Area End ##### -->



<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_class.php"; ?>

</body>


<script>

    $(document).ready(function(){



        // 클래스찜 클릭시
        $(document).on('click', '.btnZZim', function(event) {
			idx = $('.btnZZim').index(this)
            $.ajax({
                url: './class_detail_action.php',
                type: 'post',
                data: {
                    txtRecordNo: $(this).data("val"),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    arrData = Data.split("@");

                    if (arrData[0] == "SUCCESSI") {
                        $('.lblZZimCnt').eq(idx).html(arrData[1]);
						$(".btnZZim").eq(idx).addClass( 'btn-warning' );
                    } else if (arrData[0] == "SUCCESSD") {
                        $('.lblZZimCnt').eq(idx).html(arrData[1]);
						$(".btnZZim").eq(idx).removeClass( 'btn-warning' );
                    } else {
						alert(arrData[1]);
					}

                } 

            });
        });

        // 코치 찜 버튼 클리시
        $(document).on('click', '#btnCoachZZim', function(event) {
            $.ajax({
                url: './artist_zzim_action.php',
                type: 'post',
                data: {
                    txtRecordNo: $(this).data("val"),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    arrData = Data.split("@");

					if (arrData[0] == "SUCCESSI") {
						$('#btnCoachZZim').removeClass( 'btn-primary' );
						$('#btnCoachZZim').addClass( 'btn-info' );
						alert("코치를 찜하였습니다");
						$('#spnZZim').html(' 코치 찜해제');
                    } else if (arrData[0] == "SUCCESSD") {
						$('#btnCoachZZim').removeClass( 'btn-info' );
						$('#btnCoachZZim').addClass( 'btn-primary' );
						alert("코치 찜해제 하였습니다");
						$('#spnZZim').html(' 코치 찜하기');

                    } else {
						alert(arrData[1]);
					}
                } 
            });
        });

        // 문의 좋아요 클릭시
        $(document).on('click', '.chkGood', function(event) {
            var idx = $('.chkGood').index(this);
            var nCnt = parseInt($('.lblGood > span').eq(idx).text());

            $.ajax({
                url: './class_read_action.php',
                type: 'post',
                data: {
                    txtAction: "QUESTIONGOOD",
                    txtRecordNo: $('.txtQID').eq(idx).val(),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    if (Data == "SUCCESSD") {
                        $('.chkGood').eq(idx).attr("checked", false);
                        $('.lblGood > span').eq(idx).text(nCnt - 1);
                    } else if (Data == "SUCCESSI") {
                        $('.chkGood').eq(idx).attr("checked", true);
                        $('.lblGood > span').eq(idx).text(nCnt + 1);
                    } 
                } 
            });
        });

        // 삭제 좋아요 클릭시
        $(document).on('click', '.btnDelete', function(event) {
            var idx = $('.btnDelete').index(this);

			if (confirm("문의글을 삭제하시겠습니까?")) {

				$.ajax({
					url: './class_view_action.php',
					type: 'post',
					data: {
						txtAction: "QUESTIONDEL",
						txtRecordNo: $('.txtQuestionID').eq(idx).val(),
					},
					datatype: 'text',
					success: function(Data) {
						Data = $.trim(Data);
						if (Data == "SUCCESS") {
							$('.liQuestion').eq(idx).remove();
							alert("문의글이 삭제되었습니다.");
						} else {
							alert(Data);
						}
					} 
				});

			}
        });

    });
</script>

</html>