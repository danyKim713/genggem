<!DOCTYPE HTML>
<html lang="en">
<?
	include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

<script>
	var pageNo = 1;

	$(function(){
		go_list_review();
	});

	function go_list_review(){
		$.ajax({
			type: 'POST',
			url: "_ajax_list_review.php",
			data: {
				pageNo: pageNo
			},
			async: false,
			success: function(data){
				//console.log(data);
				pageNo++;
				$("#review-list").append(data);				
			}
		});
	}		

    $(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_review();
			}
		});
	});

</script>

<script type="text/javascript">
function popct(url, w, h) {
popw = (screen.width - w) / 2;
poph = (screen.height - h) / 2;
popft = 'height=' + h + ',width=' + w + ',top=' + poph + ',left=' + popw;
window.open(url, '', popft);
}
</script>

<body class="mb-5">

<? include "./inc_nav.php"; ?>
	<div class="breadcrumb-area">
        <!-- Top background Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg9.jpg);">
            <h2>Store - Review</h2>
        </div>
    </div>

	<? include "./inc_store_navi.php"; ?>

    <!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-3 mb-100">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading">
					<h2><font color="#ff0066"></font> 스토어 후기</h2>
					<p>여러분의 소중한 후기 감사합니다.</p>
				</div>
			</div>
			<div id="review-list"></div>                
        </div>
    </section>
    <!-- ##### Blog Area End ##### -->


	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_store.php"; ?>
</body>

<script>
	$('.nav_category li[data-name="gnb-partner"]').addClass('active');
	$('.nav_bottom li[data-name="partnerreview"]').addClass('active');
</script>
</html>