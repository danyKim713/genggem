<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">


<body>
<? include "./inc_Top.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-3">

					<!--내 관심 주제-->
					<div class="form-group">
					 <label>내 관심 주제</label>
					 	<span class="fs--1 float-right fw-400 color-primary mt-1"><i class="fas fa-check-square opacity-50"></i> 중복설정가능</span>
						<div class="list-category background-white">
							<ul class="row text-center">

								<li class='col-3 radiobox'>
									<input id="type<?=$m?>" type="checkbox" name="채널관심주제[]" class="invisible" <?=strpos($rowMember['채널관심주제'], $채널카테고리)>-1 ? "checked" : ""?> value="<?=$채널카테고리?>"/>
									<label for="type<?=$m?>">											
										<img src="assets/images/icon/CH<?=$m?>.png" width="60" alt="레슨">
										<span class="d-block py-1"><?=$채널카테고리?></span>
									</label>
								</li>
								
							</ul>
						</div>
					</div>
					<!--//내 관심 주제-->
					
					<!--알림 설정-->
					<div class="form-group">
					  <label>뉴스 알림 설정</label>
						<ul class="list list-border background-white">
							<li class="p-3 d-flex align-items-center justify-content-between">
								<h4 class="fs-005 mb-0">관심뉴스 알림 사용</h4>
								<div>
									<label class="form-switch" for="chkChat">
										<input type="checkbox" id="chkChat" name="" <?=$rowMember[''] == "Y"?"checked":""?> value="Y"/><i></i>
									</label>
								</div>
							</li>
						</ul>
					</div>
					<!--//알림 설정-->
					<div class="mt-4">
						<a href="javascript:go_channel_save_setting();" class="btn-block btn btn-primary fs-0">저장</a>
					</div>
				</form>
			<? include "./inc_Bottom_jurnal.php"; ?>
			</div>
		</div>
	</div>
</section>
</body>
<script>
	$('.nav_category li[data-name="gnb-journal"]').addClass('active');
	$('.nav_bottom li[data-name="jurnalset"]').addClass('active');
</script>
</html>