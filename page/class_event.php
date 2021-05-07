<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";  

    // 클래스목록
	$query  = " SELECT A.l_id, A.member_id, A.l_title, A.l_tag, A.l_price, A.쿠폰, A.쿠폰사용여부, A.l_area, A.l_intro, A.사진1,  A.클래스시작일, A.클래스기본지역, B.cat_nm, C.lesson_title, D.할인금액, D.사용여부   \n";
    $query .= " FROM   tbl_lesson A, tbl_lesson_category B, tbl_lesson_setup C, tbl_coupon D, tbl_coach E   \n";
    $query .= " WHERE  A.sale_flg = 'GS730YSA'   \n";    //  판매중인 클래스만 
//    $query .= " AND    A.show_flg = 'AD001001'   \n";    // 노출중인것만  
    $query .= " AND    A.쿠폰사용여부 = 'AD005001'   \n";    //  클래스의 쿠폰사용여부가 사용인 것만
    $query .= " AND    D.사용여부 = 'AD005001'   \n";    //  쿠폰의 사용여부가 사용인 것만
    $query .= " AND    E.use_flg = 'AD005001'   \n";    // 코치(사용중)
    $query .= " AND    A.cat_id = B.cat_id   \n";
    $query .= " AND    A.member_id = C.member_id     \n";
	$query .= " AND    A.쿠폰 =  D.c_id    \n";
    $query .= " AND    A.member_id = E.member_id     \n";
    $query .= " ORDER BY D.할인금액 DESC   \n";

	$resultLesson = db_query($query);    
    $cntLesson = mysqli_num_rows($resultLesson); 

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


    <div class="breadcrumb-area">
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>Open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>


	<!-- ##### Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">
			<div class="category-area2 mt-3">
				<!-- category Area -->
				<div class="row">
					<? include "./inc_class_category.php"; ?>
				</div>
			</div>

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading mt-3">
					<h2>쿠폰/이벤트 클래스</h2>
				</div>			
			</div>

			<div class="row">
<?
	if ($cntLesson > 0) {
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
                <!-- Single Product Area -->
                <div class="col-12 col-sm-6 col-lg-3">
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
                            
							<p class="mt-2"><small>정상가</small> <strike><?=number_format($rowLesson["l_price"])?></strike>원 (<?=number_format($rowLesson["할인금액"])?>원 할인 <i class="fa fa-arrow-down"></i>)
							</p>
							<h6 class="mt-2"><small>쿠폰적용가격</small> <strong><font color="#cc0066"><?=number_format($rowLesson["l_price"] - $rowLesson["할인금액"])?></font></strong>원</h6>
							<p style="font-size:12px; line-height:20px; color:#000;" class="mt-2 mb-2">
							<i class="fas fa-calendar-check opacity-50"></i> <?=$rowLesson["클래스시작일"]?> &nbsp; | &nbsp; <i class="fas fa-map-marker-alt opacity-50"></i> <?=$rowLesson["클래스기본지역"]?></p></a>
							<a href="class_payment.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-2"><li class="fas fa-check"></li> 강좌신청</a>
							<a href="class_detail.php?txtRecordNo=<?=$rowLesson["l_id"]?>"  class="btn-o2 mt-2 mr-2"><li class="fas fa-search"></li> 상세보기</a>
							<a href="javascript:void()"  class="btn-o2 <?=($rowZZim["cnt"] > 0) ? "btn-warning" : "";?> mt-2 mr-2 btnZZim" data-val="<?=$rowLesson["l_id"]?>"><li class="fas icon_heart_alt lblZZim"> </li> <span class="lblZZimCnt"><?=$strTotalZZim?></span></a>
                        </div></a>
                    </div>
                </div>
<?
		}
	} else {
?>
                <div class="col-12 col-sm-6 col-lg-3">
					쿠폰 이벤트 클래스가 없습니다.
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