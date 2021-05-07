<?
include "./inc_program.php";

    // 코치인지 조회
    $query = "SELECT co_id FROM tbl_coach WHERE member_id='".$ck_login_member_pk."' AND use_flg = 'AD005001' ";
    $resultCoach = db_query($query);
    $cntCoach = mysqli_num_rows($resultCoach); 

    if ($cntCoach <= 0) {  // 코치이면  
        msg_page("강사회원만 이용할 수 있습니다.");
        exit;
    }

    $query  = " SELECT A.l_id, A.member_id, A.member_uid, A.l_title, A.l_tag, A.l_price, A.쿠폰, A.쿠폰사용여부, A.cat_id, A.l_area, A.l_intro, A.클래스기본지역, A.sale_flg, A.show_flg, B.cat_nm  \n";
    $query .= " FROM   tbl_lesson A, tbl_lesson_category B   \n";
    $query .= " WHERE  A.member_id = '".$ck_login_member_pk."'   \n";   
    $query .= " AND    A.cat_id = B.cat_id   \n";   
    $query .= " ORDER BY l_id DESC   \n";

    $resultLesson = db_query($query); 
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

	<? include "./inc_artist.php"; ?>

	<section class="new-arrivals-products-area">
        <div class="container">

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading mt-3">
					<h4>클래스 등록/관리</h4>
				</div>

				<div class="col-sm-12 col-lg-12">

					<!-- 등록클래스 리스트 -->
					<article class="mb-2 mt-2">
						<div class="p-2">
							<h3 class="main-tlt display-inline">등록상품 목록</h3>
							<a href="class_product_upload.php" title="클래스등록" class="float-right color-6 fs-005">
							<button type="button" class="float-right btn btn-outline-primary btn-sm radius-5"><i class="fas fa-calendar-plus opacity-75"></i> 클래스등록</button></a>
						</div>
						<div class="list list-schedule">
							<ul>
								<li>
									<div class="d-flex"></div>
								</li>
<? 
    while ($rowLesson = mysqli_fetch_array($resultLesson)) {
?>
								<li>
									<div class="d-flex">
										<div class="col-6 lh-3">
											<p class="color-1 fw-600 fs-005 ellipsis-2 my-1"><?=$rowLesson["l_title"]?></p>
											<a href="class_product_upload_modify.php?txtRecordNo=<?=$rowLesson["l_id"]?>"><button type="button" class="btn-o2 mr-1"><li class="fas fa-check"> 수정</li></a></button>
										</div>
										<div class="col-6 border-left">
											<dl>
												<dd class="color-3 fs-005"><i class="fas fa-map-marker-alt opacity-50"></i><?=$rowLesson["클래스기본지역"]?> ㅣ <i class="fas fa-book-open opacity-50"></i><?=$rowLesson["cat_nm"]?></dd>
												<dd class="color-3 fs-005"><i class="fas fa-wallet opacity-50"></i><?=number_format($rowLesson["l_price"])?>원</dd>
												<dd class="color-3 fs-005">
<?
			if (trim($rowLesson["쿠폰"]) != "" && trim($rowLesson["쿠폰사용여부"]) == "AD005001") {
?>
												<!-- 쿠폰설정중이면 --><i class="fas fa-tags opacity-50"></i><font color="#ff0033">쿠폰클래스 진행중</font> <span class="bar"></span> 
												<? } else { ?>
												<i class="fas fa-tags opacity-50"></i>쿠폰없음 <span class="bar"></span> 
												<? } ?>
<? if (trim($rowLesson["show_flg"]) == "AD001001") {
?>
												<!-- 대표클래스이면 --><i class="fas fa-thumbs-up opacity-50"></i><font color="#0033cc">대표클래스 설정중</font>
<?
			}
?>
												</dd>
											</dl>
										</div>
									</div>
								</li>
<? 
    }
?>
							</ul>
						</div>
					</article>
					<!-- /// 등록클래스 리스트 -->
				</div>
			</div>
		</div>
	</section>

	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_category li[data-name="gnb-lesson"]').addClass('active');
	$('.nav_bottom li[data-name="lessonset"]').addClass('active');
</script>
</html>





