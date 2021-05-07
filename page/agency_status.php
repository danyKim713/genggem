<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
	<? include "./inc_Head.php"; ?>
		<link rel="stylesheet" href="assets/css/sub.css">
		<?
$_TITLE = $dic[Agency_title];
?>

			<!-- 에이전시 신청 후 조회 화면 : 승인대기 or 승인거부 -->
			<!-- 승인거부된 회원은 사유를 확인 할 수 있으며(관리자모드에 승인거부시 사유 입력함), 수정 후 재신청 가능 -->

			<body>
				<? include "./inc_Top.php"; ?>
					<section class="py-0">
						<div class="container-fluid mt-5">
							<div class="row align-items-center text-center justify-content-center">
								<div class="col-sm-10 col-lg-6 col-xl-4 px-4 mt-6">
									<!-- 신청 후 승인대기 인 경우 -->
									
									<p class="mt-3 fs-005"><?=$rowMember['name']?>님의 신청 내역을 확인 중입니다.
											<br>관리자 승인 후 에이전시로 활동할 수 있습니다</p>
									<a href="main.php" class="btn-block btn btn-lightgray fs-005">메인으로</a>
									<!-- //신청 후 승인대기 인 경우 -->

									<!-- 신청 후 승인거부 인 경우 -->
									<i class="biko-remove fs-2 color-8"></i>
									<p class="mt-2 fs-005">Agency 신청승인이 거부되었습니다.
										<br>아래 사유 수정 후 재신청 접수를 해 주시기 바랍니다.
									</p>
									
									<div class="border-box my-4 p-3 text-left">
										<span class="badge badge-danger">반려사유</span>
										<p class="fs-005 mt-2 mb-0">마이페이지에서 KYC 인증을 해주시기 바람니다.</p>
									</div>
									<a href="agency.php" class="btn-block btn btn-secondary fs-005">재신청하기</a>
									<a href="main.php" class="btn-block btn btn-lightgray fs-005">메인으로</a>
									<!-- //신청 후 승인거부 인 경우 -->
								</div>
							</div>
						</div>
					</section>
					<? include "./inc_Bottom.php"; ?>
			</body>
</html>