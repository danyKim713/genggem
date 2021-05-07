<!DOCTYPE HTML>
<html lang="en">
<? 
	$NO_LOGIN = "Y";
?>
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
            <h2>Help Desk</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<? include "./inc_help_nav.php"; ?>
<section class="alazea-blog-area mt-30">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading">
					<h2><font color="#ff3399">FAQ</font></h2>
					<p>자주묻는 질문입니다. 문의전 참조하시기 바랍니다.</p>
				</div>			
			</div>

			<div class="col-12 col-md-12 mb-5">
				<div class="con-faq wrap-panel" id="question">
					<div class="panel">
						<div class="tlt collapsed" data-toggle="collapse" href="#qna1" role="button" aria-expanded="false">
							<p class="color-3 fs-005">Q. 비밀번호 변경은 어떻게 하나요?</p>
						</div>
						<div class="collapse" id="qna1">
							<div class="background-11 p-3">
								<p class="fs-005 fw-200 color-6 ml-3">A. 마이페이지 > 비밀번호 설정에서 비밀번호를 변경할 수 있습니다.</p>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="tlt collapsed" data-toggle="collapse" href="#qna2" role="button" aria-expanded="false">
							<p class="color-3 fs-005">Q. 오픈 클래스 판매/등록은 어떤 조건이 필요한가요?</p>
						</div>
						<div class="collapse" id="qna2">
							<div class="background-11 p-3 ml-2">
								<p class="fs-005 fw-200 color-6">A. 마이페이지 > 비밀번호 설정에서 비밀번호를 변경할 수 있습니다.</p>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="tlt collapsed" data-toggle="collapse" href="#qna3" role="button" aria-expanded="false">
							<p class="color-3 fs-005">Q. 카페 이용은 무료인가요?</p>
						</div>
						<div class="collapse" id="qna3">
							<div class="background-11 p-3">
								<p class="fs-005 fw-200 color-6">A. 마이페이지 > 비밀번호 설정</p>
							</div>
						</div>
					</div>
					<div class="panel">
						<div class="tlt collapsed" data-toggle="collapse" href="#qna4" role="button" aria-expanded="false">
							<p class="color-3 fs-005">Q. 스토어가 등록방법?</p>
						</div>
						<div class="collapse" id="qna4">
							<div class="background-11 p-3">
								<p class="fs-005 fw-200 color-6">A. 마이페이지 > 비밀번호 설정</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_main.php"; ?>
</body>
</html>