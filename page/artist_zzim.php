<?
    include "./inc_program.php"; 

	// 내가 찜한 아티스트 정보 가져오기
	$query  = " SELECT A.cz_id, A.co_id, A.co_member_id, A.co_uid, A.isrt_user, A.isrt_dt,    \n";
	$query .= "        B.member_id, B.coach_career, B.career_memo, B.use_flg, B.recomm_flg,   \n";
	$query .= "        B.memo, C.member_uid, C.background_photo, C.profile_photo, C.lesson_title, C.lesson_greetings   \n";
	$query .= " FROM   tbl_coach_zzim A, tbl_coach B, tbl_lesson_setup C     \n";
	$query .= " WHERE  A.isrt_user = '{$rowMember["member_id"]}'  \n";  // 내가 찜한 것
	$query .= " AND    A.co_member_id = B.member_id  \n";
	$query .= " AND    A.co_member_id = C.member_id  \n";
    $resultArtist = db_query($query); 

	$nCount = mysqli_num_rows($resultArtist);


?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
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
					<h2>찜아티스트</h2>
					<p>회원님이 찜한 아티스트입니다.</p>
				</div>
			
			</div>
			
			<div class="row">

                <!-- Single Product Area -->
<?
	if ($nCount > 0) {
		while ($rowArtist = mysqli_fetch_array($resultArtist)) {
			// 아티스트의 클래스 수
			$query  = " SELECT COUNT(l_id) AS cnt   \n";
			$query .= " FROM   tbl_lesson    \n";
			$query .= " WHERE  member_id = {$rowArtist["member_id"]}   \n";    //  현재 아티스트것만
			$query .= " AND    sale_flg = 'GS730YSA'   \n";    //  판매중인 클래스만 
			$rowClass = db_select($query); 

			$strImg = "";
			// 이미지 
			if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchImg/{$rowArtist['member_uid']}/{$rowArtist["profile_photo"]}")) { 
				$strImg = '<img src="'.phpThumb("/ImgData/WatchImg/{$rowArtist['member_uid']}/{$rowArtist["profile_photo"]}",500,365,"2","assets/images/ex_img6.jpg").'" class="radius-5" />';
			}


?>
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
						<div class="post-thumb">
							 <a href="artist.php?txtRecordNo=<?=$rowArtist["co_id"]?>"><?=$strImg?></a>
						</div>
                        <!-- Product Info -->
                        <a href="artist.php?txtRecordNo=<?=$rowArtist["co_id"]?>" title="">
						<div class="product-info mt-15">
							<p class="ellipsis"><font size="2em" color=""><i class="fas fa-user-circle"></i> <?=$rowArtist["lesson_title"]?></font></p>
							<p style="height:40px;line-height:20px;" class="ellipsis-2"><font color="#000"><!--인사말--><?=$rowArtist["lesson_greetings"]?></font></p>
							<p style="font-size:12px; line-height:20px; color:#000;" class=" mt-2">
							<i class="fas fa-list opacity-50 mr-1"></i>클래스 <?=number_format($rowClass["cnt"])?> ea </p>
                        </div></a>
                    </div>
                </div>
<?
		}
	} else {
?>
                <div class="col-12 col-sm-6 col-lg-3">
					회원님이 찜한 아티스트가 없습니다.
                </div>
<?
	}
?>
				<!-- // -->

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