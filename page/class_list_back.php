<?
    include "./inc_program.php"; 

	$strArea = $_GET["selArea"];
	$strSearchText = $_GET["txtSearchText"];
	
//    $strRecordNo = $_GET["txtRecordNo"];        


//    $query  = " SELECT name   \n";
//    $query .= " FROM   tbl_member  \n";
//    $query .= " WHERE  member_id = '".$strRecordNo."'   \n";   
//    $rowCoachInfo = db_select($query); 


    $query  = " SELECT A.*, B.cat_nm, C.lesson_title  \n";
    $query .= " FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C   \n";
    $query .= " WHERE    A.sale_flg = 'GS730YSA'   \n";    // 판매중인것만
	if (trim($strArea) != "") { 
	    $query .= " AND    A.클래스기본지역 = '{$strArea}'   \n";    //  클래스기본지역
	}
	if (trim($strSearchText) != "") { 
	    $query .= " AND    (A.l_title LIKE '%{$strSearchText}%' OR C.lesson_title LIKE '%{$strSearchText}%')  \n";    //  클래스명이나 레슨 타이틀
	}
    $query .= " AND    A.cat_id = B.cat_id   \n"; 
	$query .= " AND    A.member_id = C.member_id   \n";
    $query .= " ORDER BY A.l_id DESC   \n";
//echo $query;
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
            <h2>cafehands open class<br>
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
					<h2>Class List</h2>
					<p>기본 : 전체클래스 목록 / 지역선택시 : 서울지역 클래스입니다. / 가까운 거리의 클래스입니다.</p>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='class_list.php' class="form-inline">
						<select class="custom-select widget-title">
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
						<input class="form-control" id="txtSearchText" name="txtSearchText" type="text" placeholder="클래스/아티스트 검색." style="width:170px;" value="<?=$strSearchText?>"/>
						<button class="btn btn-outline-secondary  ml-1" id="btnSearch">검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>

			<div class="row">

<?
	while ($rowLesson = mysqli_fetch_array($resultLesson)) {
		// 나의 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";
		$query .= " AND    member_id = '{$rowMember["member_id"]}'  \n";
		$rowZZim = db_select($query);    

//		$strZZim = "찜하기";
//		if ($rowZZim["cnt"] > 0) {
//			$strZZim = "찜해제";
//		}


		// 전체 찜정보 가져오기
		$query  = " SELECT COUNT(lz_id) AS cnt   \n";
		$query .= " FROM   tbl_lesson_zzim    \n";
		$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";

		$rowTotalZZim = db_select($query); 
		$strTotalZZim = $rowTotalZZim["cnt"];

?>
                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
				
                        <!-- Product Image -->
						<div class="post-thumb">
							 <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowLesson['사진1'],500,365,"2","assets/images/ex_img6.jpg")?>" width="100%" height="365" class="radius-5" /></a>
						</div>
                        <!-- <div>
                           <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><img src="/_UPLOAD/<?=$rowLesson['사진1']?>" alt="" width="100%" height="200" class="radius-5"></a>
                        </div> -->
                        <!-- Product Info -->
                        <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>">
						<div class="product-info mt-15">
                                <p><font size="2em" color=""><i class="fas fa-book-open"></i> <?=$rowLesson["cat_nm"]?> &nbsp;&nbsp;<i class="fas fa-user-circle"></i> <?=$rowLesson["lesson_title"]?></font></p>
								<p class="ellipsis-2"><font color="#000"><?=$rowLesson["l_title"]?></font></p>
                            
							<h6 class="mt-2"><strong><font color="#cc0066"><?=number_format($rowLesson["l_price"])?></font></strong>원</h6>
							<p style="font-size:12px; line-height:20px; color:#000;" class="mt-2 mb-2">
							<i class="fas fa-calendar-check opacity-50"></i> <?=$rowLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowLesson["클래스기본지역"]?></p></a>
							<a href="class_payment.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-2"><li class="fas fa-check"></li> 강좌신청</a>
							<a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-2"><li class="fas fa-search"></li> 상세보기</a>
							<a href="#" class="btn-o2 <?=($rowZZim["cnt"] > 0) ? "btn-warning" : "";?> mt-2 mr-2 btnZZim" data-val="<?=$rowLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a>
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
	$('.nav_bottom li[data-name="classlist"]').addClass('active');
</script>

</html>