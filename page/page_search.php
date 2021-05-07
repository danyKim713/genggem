<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<script>
	$(function(){
		$(window).scroll(function(){
			var scrollHeight = $(window).scrollTop() + $(window).height();
			var documentHeight = $(document).height();

			if(scrollHeight + 50 > documentHeight){
				go_list_page_list();
			}
		});
	});

	var pageNo = 1;

	$(function(){
		go_list_page_list();
	});

	function go_list_page_list(){
		
		$.ajax({
			type: 'POST',
			url: "_ajax_page_list_list.php",
			data: {
				pageNo: pageNo
			},
			async: false,
			success: function(data){
				//console.log(data);
				$("#page-list").append(data);
				pageNo++;
			}
		});
	}	

	$(function(){
		$("#회원검색").keyup(function(e){
			go_search_member();
		});
	});

	function go_search_member(){
		var keyword = $("#회원검색").val();

		$.ajax({
			type: 'POST',
			url: "_ajax_page_search_list.php",
			data: {
				keyword: keyword
			},
			async: false,
			success: function(data){
				$("#search-list").html(data);
			}
		});

	}
</script>


<link rel="stylesheet" href="assets/css/main.css">
<body class="mb-5">
	<? include "./inc_Top.php"; ?>

	<section>
		<div class="container mt-5">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-8 col-xl-8 px-0">
					<!--검색-->
					<article class="mb-2">
						<div class="p-3 position-r">
							<div class="w-75">
								<input class="form-control" id="회원검색" name="회원검색" type="text" placeholder="회원을 검색해주세요." />
								<button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-3 mb-2" type="button" onClick="go_search_member();">검색</button>
							</div>
						</div>
					</article>
					<!--//검색-->

					<!-- 검색결과 -->
					<article class="p-3 mb-2" id="search-list">
						
					</article>
					<!--//-->

					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">페이지 목록</h3>
						<div class="list list-default mt-3">
							<ul id="page-list">

							</ul>
						</div>
					</article>
					
					
				</div>
			</div>
		</div>
	</section>
	<? include "./inc_Bottom_page.php"; ?>
</body>
<script>
	$('.slider-banner').slick({
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 3000
	});
	$('.nav_category li[data-name="gnb-page"]').addClass('active');
	$('.nav_bottom li[data-name="pagesearch"]').addClass('active');
</script>
</html>