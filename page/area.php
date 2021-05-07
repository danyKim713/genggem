<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<body class="mb-6">
	<? include "./inc_nav.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					<article class="mb-2">
						<ul class="slider slider-banner">
							<li>
								<a href="javascript:void(0)" title="">
									<img src="assets/images/ex_img.jpg" />
								</a>
							</li>
							<li>
								<a href="javascript:void(0)" title="">
									<img src="assets/images/ex_img2.jpg" />
								</a>
							</li>
						</ul>
					</article>
					<? include "./inc_Bottom_channel.php"; ?>
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	$('.slider-banner').slick({
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 3000
	});
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>