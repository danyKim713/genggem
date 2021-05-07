<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<script>

		$(function(){
			$("#store-category li a").click(function(e){
				var store_cate_id = $(this).attr("title");
				location.href = "franchise_list.php?store_cate_id="+store_cate_id;
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

		function go_change_국가(){
		country_code = $("#국가코드 option:selected").val();

        $.post("_ajax_area1_list.php", {
          country_code: country_code
        }, function(data) {
          $("#store_area1_id").html(data);
        });

        $.post("_ajax_cate_list.php", {
          country_code: country_code
        }, function(data) {
          $("#store_cate_id").html(data);
        });


		
	}

		$(function(){
			go_list();
		});



		function go_list(){

			var params = $("#frm_page").serialize();

			jQuery.ajax({
				url: '_ajax_franchise_bookmark_list.php',
				type: 'POST',
				data:params,
				contentType: 'application/x-www-form-urlencoded; charset=UTF-8', 
				dataType: 'html',
				success: function (result) {
					if (result){
						console.log(result);
						// 데이타 성공일때 이벤트 작성ㅁ
						$("#div_franchise_list").html(result);

						go_paging();
					}
				}
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



</script>


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
			

			<input type="hidden" name="lat" id="lat" value="37.5653203"/>
			<input type="hidden" name="lng" id="lng" value="126.9745883"/>

			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading">
					<h2>Store</h2>
				</div>

				<!-- Search by Terms -->
				<? include "./inc_store_search.php"; ?>
				<!-- Search by Terms -->				
			</div>

            <div class="row">				
				<div class="col-12 col-md-12">					
					
					<!-- new class // 정열 가로 3개 2줄 총 6개-->
					<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
						<div class="section-heading">
							<h2><font color="#0066ff">즐겨찾는</font> 스토어</h2>
							<p>회원님이 즐겨찾는 스토어 목록입니다.</p>
						</div>
					</div>

					<!-- store -->
					<form name="frm_page" id="frm_page" method="get">
						<input type="hidden" name="pageNo" id="pageNo" value="<?=$pageNo?>"/>
						<input type="hidden" name="lat" id="lat" value="37.5653203"/>
						<input type="hidden" name="lng" id="lng" value="126.9745883"/>

						<div id="div_franchise_list" class="mt-3">
						 <?php
							for($i=1; $i<=5; $i++)
								{ 	?>
							<?php } ?>
						</div>

					</form>

                </div>
            </div>
        </div>
    </section>

    <!-- ##### Area End ##### -->




<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_store.php"; ?>

</body>

<script>
	$('.nav_bottom li[data-name="storebookmark"]').addClass('active');
</script>



</html>