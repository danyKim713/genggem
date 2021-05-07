<?
//    $NO_LOGIN = "Y";
	include "./inc_program.php"; 
    

	$strArea = $_GET["selArea"];
	$strSearchText = $_GET["txtSearchText"];

    // 코치인지 조회
    $query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
    $resultCoach = db_query($query);
    $cntCoach = mysqli_num_rows($resultCoach); 

    // 인기레슨
    $query  = " SELECT A.*, A.l_id, A.member_id, A.l_title, A.l_tag, A.l_price, A.l_area, A.l_intro, B.cat_nm, C.lesson_title   \n";
    $query .= " FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C   \n";
    $query .= " WHERE  A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    $query .= " AND    A.popularity_flg = 'AD001001'   \n";    //  인기 레슨만
	if (trim($strArea) != "") { 
	    $query .= " AND    A.클래스기본지역 = '{$strArea}'   \n";    //  클래스기본지역
	}
	if (trim($strSearchText) != "") { 
	    $query .= " AND    (A.l_title LIKE '%{$strSearchText}%' OR C.lesson_title LIKE '%{$strSearchText}%')  \n";    //  클래스명이나 레슨 타이틀
	}

    $query .= " AND    A.cat_id = B.cat_id   \n";
    $query .= " AND    A.member_id = C.member_id   \n";
    $query .= " ORDER BY RAND() LIMIT 8  \n";
    $resultPopLesson = db_query($query);    

    // 레슨목록
    $query  = " SELECT A.*, A.l_id, A.member_id, A.l_title, A.l_tag, A.l_price, A.l_area, A.l_intro, B.cat_nm, C.lesson_title   \n";
    $query .= " FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C   \n";
    $query .= " WHERE  A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    $query .= " AND    A.show_flg = 'AD001001'   \n";    //  노출 레슨만
    $query .= " AND    A.cat_id = B.cat_id   \n";
    $query .= " AND    A.member_id = C.member_id   \n";
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultLesson = db_query($query);    

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
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>


	<!-- ##### category Area Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">
			<div class="category-area mt-3">
				<!-- category Area -->
				<div class="row">

					<!-- category Widget -->
					<div class="col-12 col-sm-6 col-lg-12 text-center">
						<div class="single-footer-widget">
							<div class="social-info">
								<? 
							$query = "SELECT * FROM tbl_lesson_category WHERE use_flg='AD005001' ORDER BY seq ";
							$resultCategory = db_query($query); 

							while ($row = mysqli_fetch_array($resultCategory)) {
								$strImg = "";
								// 이미지 
								if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/LessonCatImg/".$row['cat_img'])) { 
									$strImg = "<img src=\"/ImgData/LessonCatImg/{$row["cat_img"]}\" width=\"20\"  alt=\"{$row["cat_nm"]}\">";
								}
						?>
								<a href='./class_cat_search.php?txtRecordNo=<?=$row['cat_id']?>' title='<?=$row["cat_nm"]?>'>
									<?=$strImg?> <?=$row["cat_nm"]?>
								</a>
								<? } ?>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2>인기 클래스</h2>
					<a href="./class_list.php"><button class="btn btn-outline-info btn-sm radius-2 ml-auto mt-1"> <i class="fas fa-map-marker-alt"></i> 내주변검색</button></a>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='class_list.php' class="form-inline">
						<select class="custom-select" id="selArea" name="selArea">
							<option value="">지역별</option>
							<?
								$query = "select distinct 지점1 from gf_weather_area where 지점1=지점2 order by 지점코드 ";
								$resultA = db_query($query);

								while($rowA = db_fetch($resultA)){
							?>
							<option <?=(trim($strArea) == trim($rowA['지점1'])) ? "selected":"";?> value="<?=$rowA['지점1']?>"><?=$rowA['지점1']?></option>
							<?
								}
							?>

						</select>
						<input class="form-control" id="txtSearchText" name="txtSearchText" type="text" placeholder="클래스/아티스트 검색." style="width:200px; height:38px;" value="<?=$strSearchText?>" />
						<button class="btn btn-secondary ml-2" id="btnSearch" style="font-size:14px; height:38px;">검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>

			<div class="row">
<?
	while($rowPopLesson = mysqli_fetch_array($resultPopLesson)) {

		// 나의 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowPopLesson["l_id"]}'  \n";
		$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";
		$rowZZim = db_select($query);    

//		$strZZim = "찜하기";
//		if ($rowZZim["cnt"] > 0) {
//			$strZZim = "찜해제";
//		}


		// 전체 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowPopLesson["l_id"]}'  \n";
		$rowTotalZZim = db_select($query); 
		$strTotalZZim = $rowTotalZZim["cnt"];

?>
                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
						<div class="post-thumb">
							 <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowPopLesson['사진1'],500,365,"2","assets/images/ex_img6.jpg")?>" width="100%" height="365" class="radius-5" /></a>
						</div>

                        <!-- Product Info -->
                        <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>">
						<div class="product-info mt-15">
                                <p><font size="2em" color=""><i class="fas fa-book-open"></i> <?=$rowPopLesson["cat_nm"]?> &nbsp; &nbsp; <i class="fas fa-user-circle"></i> <?=$rowPopLesson["lesson_title"]?></font></p>
								<p class="ellipsis-2"><font color="#000"><?=$rowPopLesson["l_title"]?></font></p>
                            
							<h6 class="mt-2"><strong><font color="#cc0066"><?=number_format($rowPopLesson["l_price"])?></font></strong>원</h6>
							<p style="font-size:12px; line-height:20px; color:#000;" class="mt-2 mb-2">
							<i class="fas fa-calendar-check opacity-50"></i> <?=$rowPopLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowPopLesson["클래스기본지역"]?></p></a>
							<a href="class_payment.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-check"></li> 강좌신청</a>
							<a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"  class="btn-o2 mt-2 mr-1"><li class="fas fa-search"></li> 상세보기</a>
							<a href="#" class="btn-o2 <?=($rowZZim["cnt"] > 0) ? "btn-warning" : "";?> mt-2 mr-1 btnZZim" data-val="<?=$rowPopLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a>
							
							<!-- 내가 찜한 클래스인 경우 -->
<!--							<a href="#" class="btn-o2 btn-warning mt-2 mr-1 btnZZim" data-val="<?=$rowPopLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a> -->
							<!-- // -->

                        </div></a>
                    </div>
                </div>

<?
	}
?>

            </div>
		</div>
	</section>
			

	<!-- ##### Service Area Start ##### -->
	<section class="our-services-area bg-gray section-padding-70-0">
		<div class="container">
			<div class="row">
				<div class="col-12 mb-3">
					<div class="section-heading text-center">
						<h2>Event & Service</h2>
						<p>오픈 클래스 이용전 확인하시고 다양한 혜택 받아가세요~</p>
					</div>
				</div>
			</div>

			<div class="row align-items-center justify-content-between">
				<div class="col-12 col-lg-5">
					<div class="alazea-service-area mb-100">

						
						<div class="single-service-area d-flex align-items-center">
							<!-- Icon -->
							<div class="service-icon ml-30 mr-30">
								<a href="./coupon.php"><img src="./assets/img/core-img/s1.png" alt=""></a>
							</div>
							<!-- Content -->
							<div class="service-content">
								<a href="./coupon.php"><h5>Coupon</h5>
								<p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p></a>
							</div>
						</div>

						
						<div class="single-service-area d-flex align-items-center">
							<!-- Icon -->
							<div class="service-icon ml-30 mr-30">
								<a href="./notice_view.php?notice_id=26"><img src="./assets/img/core-img/s2.png" alt=""></a>
							</div>
							<!-- Content -->
							<div class="service-content">
								<a href="./notice_view.php?notice_id=26"><h5>My class</h5>
								<p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p></a>
							</div>
						</div>

						<!-- Single Service Area -->
						<div class="single-service-area d-flex align-items-center">
							<!-- Icon -->
							<div class="service-icon ml-30 mr-30">
								<a href=""><img src="./assets/img/core-img/s3.png" alt=""></a>
							</div>
							<!-- Content -->
							<div class="service-content">
								<a href=""><h5>User Guide</h5>
								<p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p></a>
							</div>
						</div>

					</div>
				</div>

				<div class="col-12 col-lg-6">
					<div class="alazea-video-area bg-overlay mb-100">
						<img src="./assets/img/bg-img/23.jpg" alt="">
						<a href="http://www.youtube.com/watch?v=7HKoqNJtMTQ" class="video-icon">
							<i class="fa fa-play" aria-hidden="true"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- ##### Service Area End ##### -->

			

	<section class="new-arrivals-products-area">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-50">
					<h2>아티스트 추천 클래스</h2>
					<p>아티스트가 회원님께 추천하는 클래스입니다.</p>
				</div>
				
				<!-- Search by Terms -->
				<div class="search_by_terms">
					<a href="class_list.php"><button class="btn btn-outline-secondary  ml-1" id="btnSearch">전체클래스보기</button></a>		
				</div>
				<!-- Search by Terms -->
			</div>

			<div class="row">
				<?
					while($rowLesson = mysqli_fetch_array($resultLesson)) {
				?>
                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
                        

						<div class="post-thumb">
							 <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowLesson['사진1'],500,365,"2","assets/images/ex_img6.jpg")?>" class="radius-5" /></a>
						</div>

                        <!-- Product Info -->
                        <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>">
						<div class="product-info mt-15">
                                <p><font size="2em" color=""><i class="fas fa-book-open"></i> <?=$rowLesson["cat_nm"]?> &nbsp; &nbsp; <i class="fas fa-user-circle"></i> <?=$rowLesson["lesson_title"]?></font></p>
								<p class="ellipsis-2"><font color="#000"><?=$rowLesson["l_title"]?></font></p>
                            
							<h6 class="mt-2"><strong><font color="#cc0066"><?=number_format($rowLesson["l_price"])?></font></strong>원</h6>
							<p style="font-size:12px; line-height:20px; color:#000;" class="mt-2 mb-2">
							<i class="fas fa-calendar-check opacity-50"></i> <?=$rowLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowLesson["클래스기본지역"]?></p></a>
							<a href="class_payment.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-2"><li class="fas fa-check"></li> 강좌신청</a>
							<a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-2"><li class="fas fa-search"></li> 상세보기</a>
							<a href="#" class="btn-o2 mt-2 mr-2 btnZZim" data-val="<?=$rowLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a>
                        </div></a>
                    </div>
                </div>

				<?
					}
				?>

            </div>
        </div>
    </section>
    <!-- ##### open class End ##### -->



<?/** !-- 코치등급 회원에게만 노출 -->
<?    if ($cntCoach > 0) {  // 코치이면  ?>
	<a href="class_product.php" title="채널만들기" class=" color-6 fs-005">
		<button type="button" class=" btn btn-outline-primary btn-sm radius-5"><i class="fas fa-calendar-plus opacity-75"></i> 레슨관리 - 코치회원전용</button>
	</a>
<?    }  ?>
<!--// 끝--**/?>

	


	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="classlist"]').addClass('active');

	$(document).ready(function(){

	});
</script>

</html>