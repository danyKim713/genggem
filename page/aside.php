<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
	<? include "./inc_Head.php"; ?>
		<link rel="stylesheet" href="assets/css/sub.css">

		<body>
			<div>
				<article id="asideMenu">
					<div class="bg-gradient-primary p-3">
						<a href="javascript:history.back();" title="닫기" class="link-close float-right">
							<span class="icon ic-cancel color-9"></span>
						</a>
						<div class="user-aside d-flex align-items-center">
							<div class="user-profile">
								<img src="<?=phpThumb("/_UPLOAD/".$rowMember['페이지프로필사진'], 100, 100, 2, "assets/images/user_img.jpg")?>" alt="나의 프로필 사진" />
							</div>
							<div class="col font-2 user-info color-11 lh-3">
								<h2 class="fs-0 color-11 mb-1 fw-400"><?=$rowMember['name']?>(<?=$rowMember['닉네임']?>)님, <small>안녕하세요.</small></h2>
								<p class="fs-005 fw-500 mb-0 d-inline"><font color="#ffffff">ID: <?=$rowMember['email']?><br>
								UID: <?=$rowMember['UID']?></font></p>
								<a href="myinfo_edit.php" title="내정보 수정" class="float-right btn btn-xs btn-warning">내정보 수정</a>
							</div>
						</div>
					</div>
					<div class="con-menu">

						<ul class="menu01">
							<li class="active">
								<a href="javascript:void(0)" title="내정보">내정보</a>
								<div class="menu02">
									<ul>
										<li>
											<a href="myinfo_edit.php" title="알림설정">내정보 수정<span class="icon ic-right-arrow"></span></a>
										</li>
										<li>
											<a href="user_pw.php" title="로그인 비밀번호">로그인 비밀번호 변경<span class="icon ic-right-arrow"></span></a>
										</li>
										<li>
											<a href="settings.php" title="알림설정">푸시알림<span class="icon ic-right-arrow"></span></a>
										</li>
										<!-- <li>
											<a href="javascript:void(0)" title="안전거래 비밀번호">안전거래 비밀번호<span class="icon ic-right-arrow"></span></a>
										</li> -->
									</ul>
								</div>
							</li>
							<li>
								<a href="javascript:void(0)" title="고객지원">고객지원</a>
								<div class="menu02">
									<ul>
										<li>
											<a href="notice.php" title="공지사항">공지 & 이벤트<span class="icon ic-right-arrow"></span></a>
										</li>
										<li>
											<a href="faq.php" title="자주묻는질문">자주묻는질문<span class="icon ic-right-arrow"></span></a>
										</li>
										<li>
											<a href="contact.php" title="1대1 문의">1대1 문의<span class="icon ic-right-arrow"></span></a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="javascript:void(0)" title="마이클래스">마이 레슨</a>
								<div class="menu02">
									<ul>
										<li>
											<a href="class_my.php" title="오픈 클래스">수강레슨<span class="icon ic-right-arrow"></span></a>
										</li>
										<li>
											<a href="class_set.php" title="레슨판매관리">레슨등록/판매관리<span class="icon ic-right-arrow"></span></a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="javascript:void(0)" title="마이 카페/스토어">내모임/스토어</a>
								<div class="menu02">
									<ul>										
										<li>
											<a href="cafe_my.php" title="가입카페">가입한모임<span class="icon ic-right-arrow"></span></a>
										</li>
										<li>
											<a href="store_set.php" title="내스토어관리">내스토어관리<span class="icon ic-right-arrow"></span></a>
										</li>
									</ul>
								</div>
							</li>
							<li>
								<a href="javascript:void(0)" title="쇼핑">쇼핑</a>
								<div class="menu02">
									<ul>
										<li>
											<a href="/shop/mypage/mypage.php" title="진행중인 이벤트">마이쇼핑/주문내역<span class="icon ic-right-arrow"></span></a>
										</li>
									</ul>
								</div>
							</li>
							
						</ul>

						<div class="background-11 text-right p-3">
							<a class="fs-005 link-underline color-7" href="logout.php" title="로그아웃">로그아웃</a>
						</div>
					</div>
				</article>
			</div>
		</body>
</html>