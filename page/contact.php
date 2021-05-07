<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[contact_title];
?>
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


	<!-- ##### Blog Area Start ##### -->
	<form name="frm" id="frm" method="post" action="contact_action.php">
    <section class="alazea-blog-area mt-30 mb-5">
        <div class="container">

			<div class="row align-items-center justify-content-center">
				<div class="col-10 col-md-10">
					<div class="tabs">
						<div class="nav-bar nav-bar-center">
							<div class="nav-bar-item active"><a href="contact.php" title="문의하기">1:1 문의하기</a></div>
							<div class="nav-bar-item"><a href="contact_view.php" title="문의내역">문의내역</a></div>
						</div>
					</div>
					<div class="p-3">
						<div class="form-group">
							<label for="">이름</label>
							<input class="form-control" name="name" id="name" type="text" placeholder="이름을 입력해 주세요.">
						</div>
						<div class="form-group">
							<label for="">Email</label>
							<input class="form-control" name="email" id="email" type="text" placeholder="이메일을 입력해 주세요.">
						</div>
						<div class="form-group">
							<label for="">문의제목</label>
							<input class="form-control" name="subject" id="subject" type="text" placeholder="문의 제목을 입력해 주세요.">
						</div>
						<div class="form-group">
							<label for="">문의내용</label>
							<textarea class="form-control" name="message" id="message" rows="8" placeholder=""></textarea>
						</div>
						<div class="mt-3 mx-2 fs--1">
							<div class="checkbox check-square">
								<input id="chk1" name="agree" type="checkbox" class="invisible" data-alert="약관에 동의하시기 바랍니다.">
								<label for="chk1" class="color-5 fs-005 mb-0 fw-400"><i class="biko-check color-5 mr-2"></i>개인정보취급방침</label>
								<a href="javascript:void(0)" title="이용약관보기" data-id="md-charge-agree" data-toggle="biko-modal" class="float-right color-7 link-underline"><?=$dic['Agree_view']?></a>
							</div>
						</div>
						
						<div class="mt-4 text-center mb-5">
							<p class="mb-4 fw-300 fs-005 color-6">문의를 남겨주시면 관리자 확인 후 답변 드립니다.</p>
							<button class="btn-block btn btn-primary fs-0" type="submit">접수</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	</form>
	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_main.php"; ?>

	<div class="remodal hidden" id="md-charge-agree">
		<div class="remodal-contents py-4 px-3 text-left">
			<h2 class="fs-005">카페핸즈 개인정보보호정책</h2>
			<? include "_terms3".($_COOKIE['dic_lang']=="ko"?"":"_en").".php";?>
		</div>
		<div class="remodal-footer text-center">
			<button class="btn color-5" onclick="hideModal()"><?=$dic['Charge_close']?></button>
		</div>
	</div>
</body>

<script>
	$('.nav_bottom li[data-name="help"]').addClass('active');
</script>
</html>