<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";   
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



	<!-- ##### category Area Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2>Coupon List</h2>
				</div>			
			</div>

			<div class="row">

                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
                        <!-- Product Image -->
						<div class="post-thumb">
							 <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"><img src="assets/images/ex_img6.jpg" width="100%" height="365" class="radius-5" /></a>
						</div>

                        <!-- Product Info -->
                        <a href="class_detail.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>">
						<div class="product-info mt-15">
                                <p><font size="2em" color=""><i class="fas fa-book-open"></i> 7월 HOT COUPON</font></p>
								<p class="ellipsis"><font color="#000">오픈 클래스 강좌 1만원 할인 쿠폰</font></p>
                            
							<h6 class="mt-2"><strong><font color="#cc0066">10,000</font></strong>원 할인</h6>
							<p style="font-size:12px; line-height:20px; color:#000;" class="mt-1 mb-2">
							<i class="fas fa-calendar-check opacity-50"></i> 2020-7-15까지 다운로드</p></a>
							<a href="class_payment.php?txtRecordNo=<?=$rowPopLesson["l_id"]?>"  class="btn-o2 mt-2 mr-2"><li class="fas fa-check"></li> 다운받기</a>
                        </div></a>
                    </div>
                </div>


            </div>
		</div>
	</section>


	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_main.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="classlist"]').addClass('active');

	$(document).ready(function(){

	});
</script>

</html>