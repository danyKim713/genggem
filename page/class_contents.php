<?
    $NO_LOGIN = "Y";
	include "./inc_program.php"; 
    

	$strSearchArea = $_GET["selSearchArea"];
	$strSearchText = $_GET["txtSearchText"];
    $strBCat = $_GET["txtBCat"];

    // 코치인지 조회
    $query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
    $resultCoach = db_query($query);
    $cntCoach = mysqli_num_rows($resultCoach); 


	$query  = " SELECT PP.*, QQ.할인금액  \n";
    $query .= " FROM   (SELECT A.*, B.cat_nm, C.lesson_title, D.co_id   \n";
    $query .= "         FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coach D    \n";
    $query .= "         WHERE  A.l_id = '{$strRecordNo}'   \n";   
    $query .= "         AND    A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    if ($strBCat != "") {
        $query .= "         AND    A.cat_id = {$strBCat}   \n";
    }
    $query .= "         AND    A.cat_id = B.cat_id   \n";
    $query .= "         AND    A.member_id = C.member_id   \n";
    $query .= "         AND    A.member_id = D.member_id) PP LEFT OUTER JOIN  tbl_coupon QQ  ON PP.쿠폰 = QQ.c_id \n";
    $rowLesson = db_select($query);    

    // 인기클래스
	$query  = " SELECT PP.*, QQ.할인금액  \n";
    $query .= " FROM   (SELECT A.*, B.cat_nm, C.lesson_title   \n";
    $query .= "         FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coach D  \n";
    $query .= "         WHERE  A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    if ($strBCat != "") {
        $query .= "         AND    A.cat_id = {$strBCat}   \n";
    }
    $query .= "         AND    A.popularity_flg = 'AD001001'   \n";    //  인기 레슨만
    $query .= "         AND    A.show_flg = 'AD001001'   \n";    //  노출 레슨만
    $query .= "         AND    D.use_flg = 'AD005001'   \n";    //  코치(사용여부)
    $query .= "         AND    A.cat_id = B.cat_id   \n";
    $query .= "         AND    A.member_id = C.member_id  \n";
    $query .= "         AND    A.member_id = D.member_id) PP LEFT OUTER JOIN  tbl_coupon QQ  ON PP.쿠폰 = QQ.c_id \n";
    $query .= " ORDER BY RAND() LIMIT 10  \n";
    $resultPopLesson = db_query($query);    

    // 뉴클래스목록(최신 50개 중 랜덤으로 5개)
    $query  = " SELECT RRR.*   \n";
    $query .= " FROM   (SELECT PP.*, QQ.할인금액   \n";
    $query .= "         FROM   (SELECT A.*, B.cat_nm, C.lesson_title   \n";
    $query .= "			        FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coach D   \n";
    $query .= "			        WHERE  A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    if ($strBCat != "") {
        $query .= "                 AND    A.cat_id = {$strBCat}   \n";
    }

    $query .= "                 AND    A.show_flg = 'AD001001'   \n";    //  노출 레슨만
    $query .= "			        AND    A.cat_id = B.cat_id   \n";
    $query .= "                 AND    D.use_flg = 'AD005001'   \n";    //  코치(사용여부)
    $query .= "			        AND    A.member_id = C.member_id \n";
    $query .= "                 AND    A.member_id = D.member_id) PP LEFT OUTER JOIN  tbl_coupon QQ  ON PP.쿠폰 = QQ.c_id \n";
    $query .= "			ORDER BY PP.isrt_dt DESC LIMIT 50)  AS RRR \n";
    $query .= " ORDER BY RAND() LIMIT 20   \n";

    $resultLesson = db_query($query);    

    // 추천클래스목록
	$query  = " SELECT PP.*, QQ.할인금액  \n";
    $query .= " FROM   (SELECT A.*, B.cat_nm, C.lesson_title   \n";
    $query .= "         FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coach D   \n";
    $query .= "         WHERE  A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    if ($strBCat != "") {
        $query .= "         AND    A.cat_id = {$strBCat}   \n";
    }
    $query .= "         AND    A.show_flg = 'AD001001'   \n";    //  노출 레슨만
    $query .= "         AND    D.use_flg = 'AD005001'   \n";    //  코치(사용여부)
    $query .= "         AND    A.cat_id = B.cat_id   \n";
    $query .= "         AND    A.member_id = C.member_id \n";
    $query .= "         AND    A.member_id = D.member_id) PP LEFT OUTER JOIN  tbl_coupon QQ  ON PP.쿠폰 = QQ.c_id \n";
    $query .= " ORDER BY RAND() LIMIT 18  \n";

    $resultRecommLesson = db_query($query);    



?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<script>
	$(document).ready(function(){
        // 찜하기
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
	});
</script>
<!-- ##### img Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>레슨/클래스<br>
			<font size="4px" color="">누구나 함께하는 열린 공간!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>

	<!-- ##### Blog Area Start ##### -->
    <div class="alazea-blog-area">
        <div class="container">
			<div class="category-area2 mt-3">
				<!-- category Area -->
				<div class="row">
					<? include "./inc_class_category.php"; ?>
				</div>
			</div>

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading">
					<h2>레슨/클래스</h2>
					<a href="./class_list.php"><button class="btn btn-outline-info btn-sm radius-2 ml-auto mt-1"> <i class="fas fa-map-marker-alt"></i> 내주변 클래스 보기</button></a>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='class_list.php' class="form-inline">
						<input type="hidden" name="txtBCat" value="<?=$strBCat?>">
						<input type="hidden" name="txtSearchCat" value="<?=$strSearchCat?>">
						<select class="custom-select" id="selSearchArea" name="selSearchArea" style="width:102px" onchange="javascript:frmSearch.submit()">
							<option selected>지역별</option>
							<?
								$query = "select distinct 지점1 from gf_weather_area where 지점1=지점2 order by 지점코드 ";
								$resultA = db_query($query);

								while($rowA = db_fetch($resultA)){
							?>
							<option <?=(trim($strSearchArea) == trim($rowA['지점1'])) ? "selected":"";?> value="<?=$rowA['지점1']?>"><?=$rowA['지점1']?></option>
							<?
								}
							?>
						</select>
						<input class="form-control" id="txtSearchText" name="txtSearchText" type="text" placeholder="클래스 검색" value="<?=$strSearchText?>" style="width:110px; height:38px;" />
						<button class="btn btn-secondary ml-2" id="btnSearch" style="font-size:14px; height:38px;">검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>

            <div class="row">				
				<div class="col-12 col-md-4">
                    <div class="post-sidebar-area">

                        <!-- ##### Single Widget Area ##### -->
                        <div class="single-widget-area">
							<div class="post-thumb mb-4">
								 <a href="class_event.php"><img src="assets/img/bg-img/class_event.jpg" width="100%" height="75" class="radius-5" /></a>
							</div>

							<div class="widget-title mt-5 shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
								<div class="section-heading">
									<h4><font color="#ff3399">인기</font> 클래스</h4>
									<p>많이 사랑받는 클래스입니다.</p>
								</div>
								<div class="search_by_terms">
									<a href="class_list.php?txtSearchPop=Y"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-book-open fs--1 color-warning"></i> 인기 클래스 보기</button></a>	
								</div>
							</div>


                            <!-- Single Latest Posts -->
							<?
								while($rowPopLesson = mysqli_fetch_array($resultPopLesson)) {

									// 나의 찜정보 가져오기
									$query  = " SELECT COUNT(lz_id) AS cnt   \n";
									$query .= " FROM   tbl_lesson_zzim    \n";
									$query .= " WHERE  l_id = '{$rowPopLesson["l_id"]}'  \n";
									$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";
									$rowZZim = db_select($query);    


									// 전체 찜정보 가져오기
									$query  = " SELECT COUNT(lz_id) AS cnt   \n";
									$query .= " FROM   tbl_lesson_zzim    \n";
									$query .= " WHERE  l_id = '{$rowPopLesson["l_id"]}'  \n";
									$rowTotalZZim = db_select($query); 
									$strTotalZZim = $rowTotalZZim["cnt"];

							?>
                            <div class="single-latest-post d-flex align-items-center">
                                <div class="post-thumb">
                                     <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowPopLesson['사진1'],164,120,"2","assets/images/ex_img6.jpg")?> width="100%" height="120" class="radius-5" /></a>
                                </div>

                                <div class="post-content">
									<a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>" class="ellipsis"><i class="fas fa-user-circle color-6"></i> <?=cutstr($rowPopLesson['lesson_title'], 30)?></a><br>
									<!-- <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>" class="ellipsis fs--1"><i class="fas fa-book-open color-6"></i> <?=$rowPopLesson["cat_nm"]?></a><br> -->
									<a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>" class="ellipsis-2 fs--1"><?=cutstr($rowPopLesson['l_title'], 40)?></a><br>
                                    <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>" class="fs-005"><strike><strong><font color="#000"><?=number_format($rowPopLesson["l_price"]);?></font></strong>원</strike></a><br>
                                    <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>" class="fs-005"><strong><font color="#cc0066"><?=(trim($rowPopLesson["쿠폰"]) != "" && trim($rowPopLesson["쿠폰사용여부"]) == "AD005001") ? number_format($rowPopLesson["l_price"] - $rowPopLesson["할인금액"]) : number_format($rowPopLesson["l_price"]);?></font></strong>원</a><br>
                                    <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>" class="color-5 fs--01"><i class="fas fa-calendar-check opacity-50"></i> <?=$rowPopLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowPopLesson["클래스기본지역"]?></a><br>

									<div style="margin-top:5px;"><a href="class_payment.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"  class="btn-o3 mt-2 ellipsis"><li class="fas fa-check"></li> 레스/클래스 신청</a>
									<!-- <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"  class="btn-o3 mt-2 mr-1"><li class="fas fa-search"></li> 상세보기</a> -->
									<a href="#" class="btn-o3 <?=($rowZZim["cnt"] > 0) ? "btn-warning" : "";?> mt-2 btnZZim" data-val="<?=$rowPopLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a></div>
									
                                </div>
                            </div>
<?
	}
?>
                            
                        </div>                        
                    </div>
                </div>
				
				
				
				<div class="col-12 col-md-8">
					
					<!-- new class // 정열 가로 3개 2줄 총 6개-->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#0066ff">New</font> 클래스</h2>
							<p>새로 개설된 클래스입니다.</p>
						</div>
						<div class="search_by_terms">
							<a href="class_list.php"><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-book-open fs--1 color-warning"></i> 클래스 전체보기</button></a>	
						</div>
					</div>

					<div class="row">
<?
	while($rowLesson = mysqli_fetch_array($resultLesson)) {
		// 나의 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";
		$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";
		$rowZZim = db_select($query);    

		// 전체 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";
		$rowTotalZZim = db_select($query); 
		$strTotalZZim = $rowTotalZZim["cnt"];
?>

						<div class="col-12 col-sm-6 col-lg-4">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								<!-- Product Image -->
								<div class="post-thumb">
									 <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowLesson['사진1'],500,365,"2","assets/images/p-2.jpg")?>" width="100%" height="365" class="radius-5" /></a>
								</div>

								<!-- Product Info -->
								<a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>">
								<div class="product-info mt-15">
									<p><font size="2em" color=""><i class="fas fa-book-open"></i> <?=$rowLesson["cat_nm"]?> &nbsp; &nbsp; <i class="fas fa-user-circle"></i> <?=$rowLesson["lesson_title"]?></font></p>
									<p class="ellipsis-2"><font color="#000"><?=$rowLesson["l_title"]?></font></p>
									<h6 class="mt-1"><strike><strong><font color="#000"><?=number_format($rowLesson["l_price"]);?></font></strong>원</strike></h6>									
									<h6 class="mt-2"><strong><font color="#cc0066"><?=(trim($rowLesson["쿠폰"]) != "" && trim($rowLesson["쿠폰사용여부"]) == "AD005001") ? number_format($rowLesson["l_price"] - $rowLesson["할인금액"]) : number_format($rowLesson["l_price"]);?></font></strong>원</h6>
									<p style="font-size:12px; line-height:20px; color:#000;" class="mt-2 mb-2">
									<i class="fas fa-calendar-check opacity-50"></i> <?=$rowLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowLesson["클래스기본지역"]?></p></a>
									<a href="class_payment.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-check"></li> 레스/클래스 신청</a>
									<!-- <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-search"></li> 상세보기</a> -->
									<a href="#" class="btn-o2 <?=($rowZZim["cnt"] > 0) ? "btn-warning" : "";?> mt-2 mr-1 btnZZim" data-val="<?=$rowLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a>
								</div></a>
							</div>
						</div>
<?
	}
?>
					</div>
					<!-- // new class -->



					<!-- best class // 정열 가로 3개 3줄 총 9개 // 아티스트 추천 설정 상품 랜덤 노출 -->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#ff0066">추천</font> 클래스</h2>
							<p>아티스트가 회원님께 추천하는 클래스입니다.</p>
						</div>
						<div class="search_by_terms">
							<a href="class_list.php?txtSearchRecomm=Y""><button class="btn btn-primary-dark" style="font-size:12px;"><i class="fas fa-book-open fs--1 color-warning"></i> 추천클래스 전체보기</button></a>					
						</div>
					</div>

					<div class="row">
						
<?
	while($rowRecommLesson = mysqli_fetch_array($resultRecommLesson)) {
		// 나의 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowRecommLesson["l_id"]}'  \n";
		$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";
		$rowZZim = db_select($query);    

		// 전체 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowRecommLesson["l_id"]}'  \n";
		$rowTotalZZim = db_select($query); 
		$strTotalZZim = $rowTotalZZim["cnt"];
?>
						<!-- Single Product Area -->
						<div class="col-12 col-sm-6 col-lg-4">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								<!-- Product Image -->
								

								<div class="post-thumb">
									 <a href="class_detail.php?txtRecordNo=<?=$rowRecommLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowRecommLesson['사진1'],500,365,"2","assets/images/ex_img6.jpg")?>" class="radius-5" /></a>
								</div>

								<!-- Product Info -->
								<a href="class_detail.php?txtRecordNo=<?=$rowRecommLesson["l_id"]?>">
								<div class="product-info mt-15">
										<p><font size="2em" color=""><i class="fas fa-book-open"></i> <?=$rowRecommLesson["cat_nm"]?> &nbsp; &nbsp; <i class="fas fa-user-circle"></i> <?=$rowRecommLesson["lesson_title"]?></font></p>
										<p class="ellipsis-2"><font color="#000"><?=$rowRecommLesson["l_title"]?></font></p>
									<h6 class="mt-1"><strike><strong><font color="#000"><?=number_format($rowRecommLesson["l_price"]);?></font></strong>원</strike></h6>
									
									<h6 class="mt-1"><strong><font color="#cc0066"><?=(trim($rowRecommLesson["쿠폰"]) != "" && trim($rowRecommLesson["쿠폰사용여부"]) == "AD005001") ? number_format($rowRecommLesson["l_price"] - $rowRecommLesson["할인금액"]) : number_format($rowRecommLesson["l_price"]);?></font></strong>원</h6>
									<p style="font-size:12px; line-height:20px; color:#000;" class="mt-2 mb-2">
									<i class="fas fa-calendar-check opacity-50"></i> <?=$rowRecommLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowRecommLesson["클래스기본지역"]?></p></a>
									<a href="class_payment.php?txtRecordNo=<?=$rowRecommLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-check"></li> 레스/클래스 신청</a>
									<!-- <a href="class_detail.php?txtRecordNo=<?=$rowRecommLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-search"></li> 상세보기</a> -->
									<a href="#" class="btn-o2 <?=($rowZZim["cnt"] > 0) ? "btn-warning" : "";?> mt-2 mr-1 btnZZim" data-val="<?=$rowRecommLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a>
								</div></a>
							</div>
						</div>

<?
	}
?>

					</div>
					<!-- // best class -->

                </div>
            </div>
        </div>
    </div>
    <!-- ##### Area End ##### -->


	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="classlist"]').addClass('active');

	$(document).ready(function(){

	});
</script>

</html>