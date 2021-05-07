<?
    include "./inc_program.php"; 

    
    // 코치인지 조회
    $query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
    $resultCoach = db_query($query);
    $cntCoach = mysqli_num_rows($resultCoach); 


    // 레슨목록
    $query  = " SELECT A.l_id, A.member_id, A.l_title, A.l_tag, A.l_price, A.l_area, A.l_intro, A.사진1,  A.클래스시작일, A.클래스기본지역, B.cat_nm, C.lesson_title   \n";
    $query .= " FROM   tbl_lesson_zzim K, tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coach D   \n";
    $query .= " WHERE  K.member_id='".$ck_login_member_pk."'   \n";    // 내가 찜한 것만
    $query .= " AND    A.sale_flg = 'GS730YSA'   \n";    //  판매중인 레슨만 
    $query .= " AND    A.show_flg = 'AD001001'   \n";    // 노출중인것만
    $query .= " AND    D.use_flg = 'AD005001'   \n";    // 코치(사용중)
    $query .= " AND    A.cat_id = B.cat_id   \n";
    $query .= " AND    K.l_id = A.l_id   \n";    
    $query .= " AND    A.member_id = C.member_id   \n";
    $query .= " AND    A.member_id = D.member_id   \n";
    $query .= " ORDER BY A.isrt_dt DESC   \n";

    $resultLesson = db_query($query);    
    $cntLesson = mysqli_num_rows($resultLesson); 
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
					<h2>찜 클래스</h2>
					<p>회원님이 찜한 클래스 입니다.</p>
				</div>			
			</div>

			<div class="row">
                <!-- Single Product Area -->
<?
	if ($cntLesson > 0) {
		while($rowLesson = mysqli_fetch_array($resultLesson)) {
			// 전체 찜정보 가져오기
			$query  = " SELECT COUNT(lz_id) AS cnt   \n";
			$query .= " FROM   tbl_lesson_zzim    \n";
			$query .= " WHERE  l_id = '{$rowLesson["l_id"]}'  \n";
			$rowTotalZZim = db_select($query); 
			$strTotalZZim = $rowTotalZZim["cnt"];

?>
								
                <div class="col-12 col-sm-6 col-lg-3 divZZim">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">

                        <!-- Product Image -->
						<div class="post-thumb">
							 <a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><img src="<?=phpThumb("/_UPLOAD/".$rowLesson['사진1'],500,365,"2","assets/images/ex_img6.jpg")?>" width="100%" height="365" class="radius-5" /></a>
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
							<a href="javascript:void()" class="btn-o2 btn-warning mt-2 mr-2 btnZZim" data-val="<?=$rowLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a>
                        </div></a>
                    </div>
                </div>
<?
		}
	} else {
?>
                <div class="col-12 col-sm-6 col-lg-3">
					회원님이 찜한 클래스가 없습니다.
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

	$(document).ready(function(){
        


	});




</script>

</html>