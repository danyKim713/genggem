<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<?
$_TITLE = $dic[contact_title1];
?>
<body>
	<? include "./inc_Top.php"; ?>
	<form name="frm" id="frm" method="post" action="contact_cloud_action.php" target="_fra">
	<section class="wrap-contact py-0">
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<div>
						<ul>
							<li>
								<img src="/assets/images/cloud_guide.gif" alt="가맹점 이용안내 이미지1"/>
							</li>
						</ul>
					</div>
					<div class="tabs">
						<div class="nav-bar nav-bar-center">
							<div class="nav-bar-item active"><a href="contact_cloud.php" title="문의하기">문의하기</a></div>
							<div class="nav-bar-item"><a href="contact_cloud_view.php" title="문의내역">문의내역</a></div>
						</div>
					</div>
					<div class="p-3">
						<div class="form-group">
							<label for="">이름</label>
							<input class="form-control" name="이름" id="name" type="text" placeholder="이름을 입력해 주세요.">
						</div>
						<div class="form-group">
							<label for="">Email</label>
							<input class="form-control" name="이메일" id="email" type="text" placeholder="이메일을 입력해 주세요.">
						</div>
						<div class="form-group">
							<label for="">휴대전화</label>
							<input class="form-control" name="휴대전화" id="mobile" type="text" placeholder="연락가능한 전화번호를 입력해 주세요.">
						</div>
						<div class="form-group">
							<label for="">토큰이름</label>
							<input class="form-control" name="토큰이름" id="subject" type="text" placeholder="토큰명을 입력해 주세요.">
						</div>
						<div class="form-group">
							<label for="">문의내용</label>
							<textarea class="form-control" name="문의내용" id="message" rows="8" placeholder="토큰발행 정보 및 홈페이지 주소 등 상세한 내용을 입력해 주세요."></textarea>
						</div>
						<div class="mt-4 text-center">
							<p class="mb-4 fw-300 fs-005 color-6">상담을 신청하시면 관리자 확인 후 연락 드립니다.</p>
							<button class="btn-block btn btn-primary fs-0" type="submit">접수</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	</form>
	<? include "./inc_Bottom.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>