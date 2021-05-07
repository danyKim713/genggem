<?
    $NO_LOGIN = "Y";
	include "./inc_program.php"; 
	$nListCntPerPage = 12;  // 페이지당 목록수


    // 추천코치
    $query  = " SELECT A.co_id, A.member_id, A.coach_career, A.career_memo, A.use_flg, A.recomm_flg, A.memo, B.member_uid, B.background_photo, B.profile_photo, B.lesson_title, lesson_greetings   \n";
    $query .= " FROM   tbl_coach A, tbl_lesson_setup B \n";
    $query .= " WHERE  A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
    $query .= " AND    A.recomm_flg = 'AD001001'   \n";
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultRecommCoach = db_query($query); 
/*
    $query  = " SELECT A.co_id, A.member_id, A.coach_career, A.career_memo, A.use_flg, A.recomm_flg, A.memo, B.member_uid, B.background_photo, B.profile_photo, B.lesson_title, lesson_greetings   \n";
    $query .= " FROM   tbl_coach A, tbl_lesson_setup B \n";
    $query .= " WHERE  A.use_flg = 'AD005001'   \n";    //  사용중인 코치만
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultCoach = db_query($query); 
*/
?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<script>
	var nPageNo = 1;


	$(document).ready(function(){
		$(window).scroll(function(){
			var maxHeight = $(document).height();
			var currentHeight = $(window).scrollTop() + $(window).height();

			if(maxHeight <= currentHeight + 220){
				getMoreArtist();
			}
		});

		getMoreArtist();

	});
	

	function getMoreArtist() {
			$.ajax({
				url: './artist_list_add.php',
				type: 'post',
				data: {
					txtPageNo: nPageNo,
					txtPageListCnt: <?=$nListCntPerPage?>,
				},
				async:false,
				datatype: 'text',
				success: function(Data) {
					Data = $.trim(Data);
					$('#divCoach').append(Data);

					if (Data != "")	{
						nPageNo++;
					}

				},
				error: function(res) {
					alert('데이터를 불러오지 못했습니다.');
				}  						
			});

	}
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

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2>Best Artist</h2>
					<p>회원분들이 많이 찾으시는 아티스트입니다.</p>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearchArtist' id='frmSearchArtist' method='get' action='artist_search.php' class="form-inline">
						<input class="form-control" id="txtSearchArtist" name="txtSearchArtist" type="text" placeholder="아티스트 검색." style="width:170px;" />
						<button class="btn btn-outline-secondary  mr-3 ml-1" id="btnSearch">검색</button>
					</form>						
				</div>
				<!-- Search by Terms -->				
			</div>
			
			<div class="row">
				<?
					while ($rowRecommCoach = mysqli_fetch_array($resultRecommCoach)) {

						// 내영상정보 가져오기
						$query  = " SELECT COUNT(wv_id) AS cnt   \n";
						$query .= " FROM   tbl_watch_video   \n";
						$query .= " WHERE  member_id='{$rowRecommCoach["member_id"]}'   \n"; 
						$query .= " AND    use_flg = 'AD005001'   \n"; 

						$resultWatch = db_select($query); 

						// 아티스트의 클래스 수
						$query  = " SELECT COUNT(l_id) AS cnt   \n";
						$query .= " FROM   tbl_lesson    \n";
						$query .= " WHERE  member_id = {$rowRecommCoach["member_id"]}   \n";    //  현재 아티스트것만
						$query .= " AND    sale_flg = 'GS730YSA'   \n";    //  판매중인 클래스만 
						$rowClass = db_select($query); 

						$strImg = "";
						// 이미지 
						if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchImg/{$rowRecommCoach['member_uid']}/{$rowRecommCoach["profile_photo"]}")) { 
							$strImg = '<img src="'.phpThumb("/ImgData/WatchImg/{$rowRecommCoach['member_uid']}/{$rowRecommCoach["profile_photo"]}",500,365,"2","assets/images/ex_img6.jpg").'" class="radius-5" />';
						}

				?>
                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
						<div class="post-thumb">
							 <a href="artist.php?txtRecordNo=<?=$rowRecommCoach["co_id"]?>"><?=$strImg?></a>
						</div>
                        <!-- Product Info -->
                        <a href="artist.php?txtRecordNo=<?=$rowRecommCoach["co_id"]?>" title="">
						<div class="product-info mt-15">
                                <p class="ellipsis"><font size="2em" color=""><i class="fas fa-user-circle"></i> <?=$rowRecommCoach["lesson_title"]?></font></p>
								<p style="height:40px;line-height:20px;" class="ellipsis-2"><font color="#000"><!--인사말--><?=$rowRecommCoach["lesson_greetings"]?></font></p>
							<p style="font-size:12px; line-height:20px; color:#000;" class=" mt-2">
							<i class="fas fa-list opacity-50 mr-1"></i>클래스 <?=number_format($rowClass["cnt"])?> ea <!-- ㅣ <i class="fab fa-youtube opacity-50 mr-1"></i>영상 <?=number_format($resultWatch["cnt"])?> ea --></p>
                        </div></a>
                    </div>
                </div>
				<?
					 }
				?>

            </div>


			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h3>ARTIST LIST</h3>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name="frmSearchArea" action="artist_search.php" method="get" class="form-inline">
						<select class="custom-select" id="selSearchArea" name="selSearchArea" style="width:150px" onchange="javascript:frmSearchArea.submit()">
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
					</form>						
				</div>
				<!-- Search by Terms -->				
			</div>

			
			<div class="row" id="divCoach">

            </div>
        </div>
    </section>
    <!-- ##### open class End ##### -->



	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>

</html>