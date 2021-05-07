<!DOCTYPE HTML>
<html lang="en">
<?php 
include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

<body>
	<header class="header top_fixed">
		<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
		<h2 class="header-title text-center">클럽생성</h2>
	</header>
	<section class="py-0">
			<div class="container-fluid header-top-sub">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-4 p-3">
						<p class="my-4 fs-05 text-center color-primary">클럽 생성을 축하드립니다</p>					
						<div class="my-4">
							<ul class="ul-notice text-center">
								<li>클럽이 정상적으로 생성되었습니다.</li>
								<li>건전한 클럽/모임 활동을 위해 노력해 주세요.</li>
								<li>해지를 원하시면 언제든지 해지가 가능합니다.</li>
							</ul>
						</div>
						
						<!-- <table class="table-info">
							<tbody>
								<tr>
									<th>결제금액</th>
									<td class="fw-600">무료</td>
								</tr>
								<!-- <tr>
									<th>결제수단</th>
									<td>없음</td>
								</tr> 
							</tbody>
						</table> -->

						<div class="mt-4">
							<a href="cafe_my.php" class="btn-block btn btn-dark mb-3 fs-0">가입클럽보기</a>
						</div>
					</div>
					<? include "./inc_Bottom_channel.php"; ?>
				</div>
			</div>
		</section>
</body>

<script>
 $('.nav_bottom li[data-name="channelmade"]').addClass('active');
</script>
</html>