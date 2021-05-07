<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

<script>
$(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_review();
			}
		});
	});

	var pageNo = 1;

	$(function(){
		go_list_review();
	});

	function go_list_review(){
		$.ajax({
			type: 'POST',
			url: "_ajax_list_review_my.php",
			data: {
				pageNo: pageNo
			},
			async: false,
			success: function(data){
				//console.log(data);
                if ($.trim(data) == "NO") {

                    $('#noSec').show();
                    $('#yesSec').hide();

                } else {

					pageNo++;

                    $('#noSec').hide();
                    $('#yesSec').show();
				    $("#review-list").append(data);
    				
                }
			}
		});
	}		
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
            <h2>내가 쓴 후기</h2>
        </div>
    </div>

	<? include "./inc_store_navi.php"; ?>

    <!-- 작성한 후기가 없을때 -->
    <section id="noSec" style="display:none">
        <div class="container">
			<div class="mt-100 mb-100 d-flex align-items-center justify-content-center">작성한 후기가 없습니다.</div>                
        </div>
    </section>

	<!-- 작성한 후기가 있을때 -->
	<section class="alazea-blog-area mt-3 mb-100" id="yesSec" style="display:none">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading">
					<h2><font color="#ff0066"></font> 내가 쓴 후기</h2>
					<p>회원님이 작성한 후기입니다.</p>
				</div>
			</div>
			<div id="review-list">
			</div>                
        </div>
    </section>
    <!-- Area End -->


	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_store.php"; ?>
</body>

<script>
	$('.nav_category li[data-name="gnb-partner"]').addClass('active');
	$('.nav_bottom li[data-name="partnerreview"]').addClass('active');
</script>
</html>