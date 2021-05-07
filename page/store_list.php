<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";

?>
<? include "./inc_Head.php";  ?>
<link rel="stylesheet" href="assets/css/sub.css">
<script>
/*
	$(function(){
			$("#store-category li a").click(function(e){
				var category = $(this).attr("title");
				location.href = "franchise_list.php?category="+category;
			});
		});

*/

	$(function(){
		$.post("_ajax_cate_list.php", {
          country_code: '82'
        }, function(data) {
          $("#store_cate_id").html(data);
<?		  if($category){?>
			$("#store_cate_id option").each(function(){
				if($(this).text() == '<?=$category?>'){
					$("#store_cate_id").val($(this).val());
				}
			});
			go_list();
<?}?>
        });
	});

	var country_code;

      function go_change_area1(obj) {
        var area1 = obj.value;

        $.post("_ajax_area2_list.php", {
          store_area1_id: area1,
			country_code : country_code 
        }, function(data) {
          $("#store_area2_id").html(data);

		  go_list();

        });
      }
/*
	function go_change_국가(){
		country_code = $("#국가코드 option:selected").val();

        $.post("_ajax_area1_list.php", {
          country_code: country_code
        }, function(data) {
          $("#store_area1_id").html(data);

		  go_list();
        });

        $.post("_ajax_cate_list.php", {
          country_code: country_code
        }, function(data) {
          $("#store_cate_id").html(data);

		  go_list();
        });

		if(country_code != "82"){
			$("#btn-zip").hide();
		}else{
			$("#btn-zip").show();
		}


		
	}
*/
		$(function(){
			go_list();
		});

		function go_list(){


            navigator.geolocation.getCurrentPosition(function(pos) {
                var latitude = pos.coords.latitude;
                var longitude = pos.coords.longitude;
//                alert("현재 위치는 : " + latitude + ", "+ longitude);

                $("#lat").val(latitude);
                $("#lng").val(longitude);



                var params = $("#frm_page").serialize();

                jQuery.ajax({
                    url: '_ajax_franchise_list.php',
                    type: 'POST',
                    data:params,
                    contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                    dataType: 'html',
                    success: function (result) {
                        if (result){
                            //console.log(result);
                            // 데이타 성공일때 이벤트 작성ㅁ
                            $("#div_franchise_list").html(result);

                            go_paging();
                        }
                    }
                });

            });
		}

		function go_paging(){
			jQuery.ajax({
				url: '_paging_franchise.php',
				type: 'POST',
				data:{num: $("#num").val(), pageNo: $("#pagingPageNo").val()},
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
				dataType: 'html',
				success: function (result) {
					if (result){
						// 데이타 성공일때 이벤트 작성
						$("#div_pagination").html(result);
					}
				}
			});
		}


/*
	function get_pos(){
		get_lat();
		get_lng();
	}

	function get_lat(){
<? if( $detect->isAndroidOS() ) {?>
		window.AndroidApp.get_lat();
<?}else if( $detect->isiOS() ){?>
		window.webkit.messageHandlers.get_lat.postMessage(null);
<?}?>
	}

	function set_lat(val){
		$("#lat").val(val);
		go_list();
	}

	function get_lng(){
<? if( $detect->isAndroidOS() ) {?>
		window.AndroidApp.get_lng();
<?}else if( $detect->isiOS() ){?>
		window.webkit.messageHandlers.get_lng.postMessage(null);
<?}?>
	}

	function set_lng(val){
		$("#lng").val(val);
		go_list();
	}
*/

	$(document).ready(function(){

        $(document).on('change', '#selCat', function(event) {
			$('#frmSearch').submit();
         });

        $(document).on('change', '#store_area1_id', function(event) {
			$('#frmSearch').submit();
         });


	});

</script>


<?
$_TITLE = $dic[Franchise_title];
?>

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<!-- ##### img Area Start ##### -->
	<div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg9.jpg);">
            <h2>Store</h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_store_navi.php"; ?>

	<!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-3">
        <div class="container">
			


			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading">
					<h2>Store</h2>
					<!-- <a href="./class_list.php"><button class="btn btn-outline-info btn-sm radius-2 ml-auto mt-1"> <i class="fas fa-map-marker-alt"></i> 내주변 스토어 보기</button></a> -->
				</div>

				<!-- Search by Terms -->
				<? include "./inc_store_search.php"; ?>
				<!-- Search by Terms -->				
			</div>

			<div class="category-area">
				<div class="row">
					<? include "./inc_store_category.php"; ?>
				</div>
			</div>

            <div class="row">				
				<div class="col-12 col-md-12">
					
					<!-- best class // 정열 가로 3개 3줄 총 9개 // 아티스트 추천 설정 상품 랜덤 노출 -->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#ff0066"></font> 요즘 뜨는 스토어</h2>
							<p>카페핸즈 회원님들이 좋아하는 스토어입니다.</p>
						</div>
					</div>

					<div class="row">
						
						<?php

						$query = "select * from tbl_store where best_yn = 'Y' and state = '가맹점 승인' order by rand()";
						$query  = " select A.*, B.store_cate_name, C.store_area1_name ";
                        $query .= " from tbl_store A, tbl_store_cate B, tbl_store_area1 C "; 
                        $query .= " where best_yn = 'Y' ";
                        $query .= " and state = '가맹점 승인' ";
                        $query .= " and A.store_cate_id = B.store_cate_id ";
                        $query .= " and A.store_area1_id = C.store_area1_id ";
                        $query .= " order by rand()";

						$rStore = db_query($query);
						while($rowStore = db_fetch($rStore)){
						$rowImage = db_select("select * from tbl_store_image where store_id='".$rowStore['store_id']."'");

						?>
						<!-- Single Product Area -->
						<div class="col-12 col-sm-6 col-lg-3">
							<div class="single-product-area mb-50 wow fadeInUp" data-wow-delay="100ms">
								<div class="post-thumb">
									 <a href="store.php?store_id=<?=$rowStore['store_id']?>"><img src="<?=phpThumb("/_UPLOAD/".$rowImage['filename'],500,365,"2","assets/images/img_store.jpg")?>" class="radius-5" /></a>
								</div>

								<!-- Product Info -->
								<a href="store.php?store_id=<?=$rowStore['store_id']?>">
								<div class="product-info mt-15">
									<p class="fs--1"><i class="fas fa-book-open"></i> <?=$rowStore["store_cate_name"]?> &nbsp; &nbsp; <i class="fas fa-map-marker-alt"></i> <?=$rowStore["store_area1_name"]?> </p>
									<p class="ellipsis color-3 fs-05"><?=$rowStore["store_name"]?></p>
									
									<h6 class="ellipsis-2 color-6 fs-005 lh-4"><?=$rowStore["store_desc"]?></h6>
									<p class="fs--1 color-6 mt-2 mb-2">
									<i class="fas fa-calendar-check opacity-50"></i> <!-- <?=number_format($row['distance'])?> km &nbsp; | &nbsp;  --><?=$rowStore["store_addr"]?></p>
								</div></a>
							</div>
						</div>

						<?
							}
						?>

					</div>
					<!-- // best class -->
					
					<!-- new class // 등록순 // 무한 스크롤 -->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#0066ff">New</font> 스토어</h2>
							<p>새로 등록된 스토어입니다.</p>
						</div>
					</div>

					<form name="frm_page" id="frm_page" method="get">
					<input type="hidden" name="pageNo" id="pageNo" value="<?=$pageNo?>"/>
					<input type="hidden" name="lat" id="lat" value="37.5653203"/>
					<input type="hidden" name="lng" id="lng" value="126.9745883"/>
					<div class="row" id="div_franchise_list">
						<!-- <div id="div_franchise_list"> -->
						 <?php
							for($i=4; $i<=8; $i++)	{ 	?>
							<?php } ?>
						<!-- </div>		 -->	
					</div>
					</form>
					<!-- // new class -->

                </div>
            </div>
        </div>
    </section>

    <!-- ##### Area End ##### -->



	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_store.php"; ?>
</body>
<script>
	$('.nav_category li[data-name="gnb-store"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>