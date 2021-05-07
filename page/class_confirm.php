<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
		<h2 class="header-title text-center">영상등록</h2>
	</header>
	<section class="wrap-channelmade py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-3">
					<p class="my-4 fs-05 text-center mb-3">레슨등록이 완료되었습니다.<br>일반회원인 경우, 관리자 승인 후 <br>영상이 등록됩니다.</p>
					<div class="form-group">
						<label class="fs-01 mt-3">아래에 해당되는 경우, 영상등록이 반려되거나 플랫폼 이용에 제한이 있을 수 있습니다.</label>
						<div class="mt-2">
							<ul class="ul-notice">
								<li>미풍양속에 저해되는 레슨을 등록하였을 경우.</li>
								<li>저작권법에 의해 이용에 제한이 있는 영상을 게재한 경우</li>
								<li>기타, 원활한 플랫폼 이용에 저해되는 경우</li>
							</ul>
						</div>
					</div>

					<div class="mt-4">
						<a href="class_product.php" class="btn-block btn btn-primary fs-0">영상/레슨 홈</a>
					</div>
				</div>
				<? include "./inc_Bottom_vod.php"; ?>
			</div>
		</div>
	</section>
</body>
</html>