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
					<p class="my-4 fs-05 text-center mb-3">영상등록신청이 완료되었습니다.<br>관리자 승인 후 <br>영상이 게재됩니다.</p>
					<div class="form-group">
						<label class="fs-01 mt-3">아래에 해당되는 경우, 영상등록이 되지않거나 플랫폼 이용에 제한이 있을 수 있습니다.</label>
						<div class="mt-2">
							<ul class="ul-notice">
								<li>'설정'에서 크리에이터 정보를 입력하지 않은 경우.</li>
								<li>미풍양속에 저해되는 영상을 등록하였을 경우.</li>
								<li>저작권법에 의해 이용에 제한이 있는 영상을 게재한 경우</li>
								<li>기타, 원활한 사이트 주제나 목적 맞지 않는 경우</li>
							</ul>
						</div>
					</div>

					<div class="mt-5">
						<a href="watch_list.php" class="btn-block btn btn-primary fs-0 mb-3">영상 홈</a>
						<a href="watch_my.php" class="btn-block btn btn-info fs-0">내영상관리</a>
					</div>
				</div>
				<? include "./inc_Bottom_vod.php"; ?>
			</div>
		</div>
	</section>
</body>
<script>
	$('.nav_bottom li[data-name="watchupload"]').addClass('active');
</script>
</html>