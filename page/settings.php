<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">

<body>
	<header class="header top_fixed">
    <a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
    <h2 class="header-title text-center">알림설정</h2>
  </header>
	<section class="wrap-set py-0 pb-6">
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<!-- <div class="con-language clearfix mt-3 mr-3">
					<select class="form-control float-right" onChange="go_change_language_dic(this);">
						<option value="" selected>Language</option>
						<option value="en" <?=$_COOKIE['dic_lang']=="en"?"selected":""?>>English</option>
						<option value="cn" <?=$_COOKIE['dic_lang']=="cn"?"selected":""?>>中文简体</option>
						<option value="ko" <?=$_COOKIE['dic_lang']=="ko"?"selected":""?>>한국어</option>
					</select>
				</div> -->

				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
				<ul>
					<li>
						<h3 class="tlt-menu">알림설정</h3>
						<div class="border-box2 p-3">
							<div class="checkbox check-primary">
								<h4 class="lbl-set">이벤트&#40;푸시&#41; 알림</h4>
								<label class="form-switch float-right">
									<input type="checkbox" /><i></i>
								</label>
							</div>
							<p class="mt-2 mb-0 color-7 fw-200 fs--1">푸시알림을 설정 하시면 다양한 소식과 뉴스를 받으실 수 있습니다.</p>
						</div>
					</li>
					<!-- <li>
						<h3 class="tlt-menu">언어설정</h3>
						<div class="border-box2 p-3">
							<div class="checkbox check-primary">
								<h4 class="lbl-set">한국어</h4>
								<input type="checkbox" name="event_alert" class="invisible" id="event_alert" value="Y" href="javascript:void(0)" checked="">
								<label for="event_alert" class="mb-0 fs-0"><span class="icon ic-verified mr-2 fs-05"></span></label>
							</div>
						</div>
						<div class="border-box2 p-3">
							<div class="checkbox check-primary">
								<h4 class="lbl-set">English</h4>
								<input type="checkbox" name="event_alert" class="invisible" id="event_alert2" value="Y" href="javascript:void(0)">
								<label for="event_alert2" class="mb-0 fs-0"><span class="icon ic-verified mr-2 fs-05"></span></label>
							</div>
						</div>
						<div class="border-box2 p-3">
							<div class="checkbox check-primary">
								<h4 class="lbl-set">简体中文</h4>
								<input type="checkbox" name="event_alert" class="invisible" id="event_alert3" value="Y" href="javascript:void(0)">
								<label for="event_alert3" class="mb-0 fs-0"><span class="icon ic-verified mr-2 fs-05"></span></label>
							</div>
						</div>
					</li> -->
					<li>
						<h3 class="tlt-menu">앱버전</h3>
						<div class="border-box2 p-3">
							<h4 class="lbl-set">버전 &#40;<span>1.0.0</span>&#41;</h4>
							<p class="mb-0 mt-1 fs-005 color-primary float-right">최신버전</p>
						</div>
					</li>
				</ul>
				</div>
			</div>
		</div>
	</section>
	
</body>

</html>