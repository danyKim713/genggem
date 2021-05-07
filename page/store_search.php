<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";

    $query = " SELECT * FROM  tbl_store_cate WHERE store_cate_id = '{$selCat}' ";
    $rowCat = db_select($query);    


    $strCat = ($rowCat["store_cate_name"] != "") ? $rowCat["store_cate_name"] : "전체카테고리";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[Franchise_title];
?>

<body class="mb-5">

<? include "./inc_nav.php"; ?>
<script>

	$(document).ready(function(){

        $(document).on('change', '#selCat', function(event) {
			$('#frmSearch').submit();
         });

        $(document).on('change', '#store_area1_id', function(event) {
			$('#frmSearch').submit();
         });

        go_list();
	});

    function go_list(){


        navigator.geolocation.getCurrentPosition(function(pos) {
            var latitude = pos.coords.latitude;
            var longitude = pos.coords.longitude;
//                alert("현재 위치는 : " + latitude + ", "+ longitude);

            $("#lat").val(latitude);
            $("#lng").val(longitude);



            var params = $("#frmSearch").serialize();

            jQuery.ajax({
                url: '_ajax_store_search_best_list.php',
                type: 'POST',
                data:params,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                dataType: 'html',
                success: function (result) {
                    if (result){
                        //console.log(result);
                        // 데이타 성공일때 이벤트 작성ㅁ
                        $("#store_best_list").html(result);

                        //go_paging();
                    }
                }
            });

            jQuery.ajax({
                url: '_ajax_store_search_list.php',
                type: 'POST',
                data:params,
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                dataType: 'html',
                success: function (result) {
                    if (result){
                        //console.log(result);
                        // 데이타 성공일때 이벤트 작성ㅁ
                        $("#store_list").html(result);

                        //go_paging();
                    }
                }
            });

        });
    }



</script>
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
					<a href="./class_list.php"><button class="btn btn-outline-info btn-sm radius-2 ml-auto mt-1"> <i class="fas fa-map-marker-alt"></i> 내주변 스토어 보기</button></a>
				</div>

				<!-- Search by Terms -->
				<? include "./inc_store_search.php"; ?>
				<!-- Search by Terms -->				
			</div>

			
            <div class="row">				
				<div class="col-12 col-md-12">
					
					<!-- best class // 정열 가로 3개 3줄 총 9개 // 아티스트 추천 설정 상품 랜덤 노출 -->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#ff0066"></font> '<?=$strCat?>' 스토어</h2>
							<p>회원님들이 좋아하는 스토어입니다.</p>
						</div>
					</div>

					<div class="row" id="store_best_list">
						


					</div>
					<!-- // best class -->
					
					<!-- new class // 정열 가로 3개 2줄 총 6개-->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#0066ff">스토어</font> 목록</h2>
							<p>'<?=$strCat?>' 스토어 리스트입니다.</p>
						</div>
					</div>

					<div class="row" id="store_list">
					</div>
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
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>