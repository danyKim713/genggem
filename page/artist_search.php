<?
    $NO_LOGIN = "Y";
	include "./inc_program.php"; 

    $strSearchArtist = trim($_GET["txtSearchArtist"]);  // 아티스트 검색어
    $strSearchArea   = trim($_GET["selSearchArea"]);  // 지역 검색어


    $arrWhere = array();
	$arrSearchWord = array();
    if ($strSearchArea != "") {
        $arrWhere[]  = "     B.아티스트기본지역 LIKE '%{$strSearchArea}%'  \n"; 
		$arrSearchWord[] = $strSearchArea; 
    }
    if ($strSearchArtist != "") {
        $arrWhere[]  = "     (B.lesson_title LIKE '%{$strSearchArtist}%' OR B.lesson_searchword LIKE '%{$strSearchArtist}%')  \n"; 
		$arrSearchWord[] = $strSearchArtist; 
    }

	$strWhere = implode(" AND ", $arrWhere);
	$strSearchWord = implode("' / '", $arrSearchWord);

	if ($strWhere != "") {
		$strWhere = " AND ".$strWhere;
	}


	// 아티스트
    $query  = " SELECT A.co_id, A.member_id, B.lesson_title, B.background_photo, B.member_uid, B.아티스트기본지역, B.profile_photo, B.lesson_greetings     \n";
    $query .= " FROM   tbl_coach A, tbl_lesson_setup B    \n";
    $query .= " WHERE  A.use_flg = 'AD005001'   \n";    //  사용중인 아티스트만
    $query .= $strWhere;
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " ORDER BY B.lesson_title ASC   \n";
    $resultSearch = db_query($query);  
    $nResultCnt = mysqli_num_rows($resultSearch);  

?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>

	<!-- ##### category Area Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between mt-3">			
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2>아티스트 List</h2>
<?	if ($nResultCnt <= 0) { ?>
					<!-- 검색결과 없을 경우 -->
					<p><?=(trim($strSearchWord) != "") ? "'".trim($strSearchWord)."'으로":"전체";?> 검색한 아티스트가 없습니다.</p>
<?	} else { ?>
					<!-- 검색결과 있을 경우 -->
					<p><?=(trim($strSearchWord) != "") ? "'".trim($strSearchWord)."'으로":"전체";?> 검색한 아티스트 입니다..</p>
<? } ?>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form action="artist_search.php" method="get" class="form-inline">
						<select class="custom-select" id="selSearchArea" name="selSearchArea" style="width:150px" onchange="javascript:frmSearch.submit()">
							<option value="">지역별</option>
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
						<input class="form-control" id="txtSearchArtist" name="txtSearchArtist" type="text" placeholder="아티스트 검색." style="width:170px;" value="<?=$strSearchArtist?>" />
						<button class="btn btn-outline-secondary  ml-1" id="btnSearch">검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>	

			
			<div class="row">
				

<?
	// 아티스트
	while ($rowSearch = mysqli_fetch_array($resultSearch)) {

		// 아티스트의 클래스 수
		$query  = " SELECT COUNT(l_id) AS l_cnt   \n";
		$query .= " FROM   tbl_lesson    \n";
		$query .= " WHERE  member_id = {$rowSearch["member_id"]}   \n";    //  현재 아티스트것만
		$query .= " AND    sale_flg = 'GS730YSA'   \n";    //  판매중인 클래스만 
		$rowClass = db_select($query);  
?>
				<!-- view -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
				
						<!-- Product Image -->
						<div class="post-thumb">
							 <a href="artist.php?txtRecordNo=<?=$rowSearch["co_id"]?>"><img src="<?=phpThumb("/ImgData/WatchImg/{$rowSearch['member_uid']}/{$rowSearch["profile_photo"]}",500,365,"2","assets/images/ex_img6.jpg")?>" class="radius-5" /></a>

						</div>

                        <a href="artist.php?txtRecordNo=<?=$rowSearch["co_id"]?>" title="">
						<div class="product-info mt-15">
                                <p class="ellipsis"><font size="2em" color=""><i class="fas fa-user-circle"></i> <?=$rowSearch["lesson_title"]?></font></p>
								<p style="height:40px;line-height:20px;" class="ellipsis-2"><font color="#000"><!--인사말--><?=$rowSearch["lesson_greetings"]?></font></p>
							<p style="font-size:12px; line-height:20px; color:#000;" class=" mt-2">
							<i class="fas fa-list opacity-50 mr-1"></i>클래스 <?=number_format($rowClass["l_cnt"])?> ea</p>
                        </div></a>
                    </div>
                </div>
<?
	}
?>
            </div>
		</div>
	</section>

<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="artist"]').addClass('active');
</script>
</html>