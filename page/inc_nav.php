<!-- ##### Header Area Start ##### -->
    <header class="header-area hidden-xs">

        <!-- ***** Top Header Area ***** -->
        <div class="top-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="top-header-content d-flex align-items-center justify-content-between">
                            <!-- Top Header Content -->
                            <div class="top-header-meta">
								<a class="link-aside" href="page_notice.php" data-toggle="tooltip" data-placement="bottom" title="(<?=$미확인알림수?>)개의 미확인 알림이 있습니다."><span class="badge <?=$미확인알림수!="0"?"badge-danger":""?> position-ab"><?=$미확인알림수?></span><i class="fas fa-bell"></i><span> 미확인알림</span></a>
                                <a href='contact.php' data-toggle="tooltip" data-placement="bottom"><i class="fa fa-comment" aria-hidden="true"></i><span>고객문의</span></a> 
                            </div>

                            <!-- Top Header Content -->
                            <div class="top-header-meta d-flex">
                                <?/*!-- Language Dropdown 
                                <div class="language-dropdown">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mr-30" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Language</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?=$_COOKIE['dic_lang']=="ko"?"selected":""?>">한국어</a>
                                            <a class="dropdown-item" href="<?=$_COOKIE['dic_lang']=="en"?"selected":""?>">Eng</a>
											<a class="dropdown-item" href="<?=$_COOKIE['dic_lang']=="cn"?"selected":""?>">中文简体</a>
                                        </div>
                                    </div>
                                </div>--*/?>
                                <!-- Login -->
								<? if ($rowMember['email']){ ?>
                                <div class="login">
                                    <a href="aside.php"><i class="fa fa-user" aria-hidden="true"></i> <span>내정보</span></a>
                                </div>
                                <div class="cart">
                                    <a href="logout.php"><i class="fa fa-unlock" aria-hidden="true"></i> <span>로그아웃</span></a>
                                </div>
								<? } else { ?>
								<div class="login">
                                    <a href="join.php"><i class="fa fa-user" aria-hidden="true"></i> <span>회원가입</span></a>
                                </div>
                                <div class="cart">
                                    <a href="login.php"><i class="fa fa-lock" aria-hidden="true"></i> <span>로그인</span></a>
                                </div>
								<? } ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ***** Navbar Area ***** -->
        <div class="alazea-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="alazeaNav">

                        <!-- Nav Brand -->
                        <a href="main.php" class="nav-brand"><img src="./assets/img/core-img/logo.png" alt=""></a>

                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Navbar Start -->
                            <div class="classynav" id="nav_category">
                                <ul>
                                    <li data-name="gnb-page">
										<a href="page_list.php"><i class="fa fa-star"></i> 페이지</a>
										<ul class="dropdown">
                                            <li><a href="page_list.php">페이지홈</a></li>
                                            <li><a href="page_me.php">내페이지</a></li>
                                            <li><a href="page_search.php">페이지검색</a></li>
                                            <li><a href="page_friends.php">친구</a></li>
											<li><a href="page_board.php">글보기</a></li>
                                        </ul>
									</li>
                                    <li data-name="gnb-lesson">
										<a href="class.php"><i class="fas fa-book-open"></i> 레슨/클래스</a>
										<ul class="dropdown">
									<? 
										$query = "SELECT * FROM tbl_lesson_category WHERE depth= 1 AND use_flg='AD005001' ORDER BY seq ";
										$resultNavCat = db_query($query); 

										while ($rowNavCat = mysqli_fetch_array($resultNavCat)) {
														echo "<li><a href=\"class_contents.php?txtBCat={$rowNavCat["cat_id"]}\">{$rowNavCat["cat_nm"]}</a></li>";
										} 
									?>
<!--
                                            <li><a href="class_contents.php">공예/문화센터</a></li>
                                            <li><a href="class_contents.php">뷰티/미용/건강</a></li>
                                            <li><a href="class_contents.php">스포츠</a></li>
											<li><a href="class_contents.php">과외/언어</a></li>
											<li><a href="class_contents.php">컴퓨터/디자인</a></li>
-->
											<li><a href="class_zzim.php">찜레슨</a></li>
											<li><a href="class_review.php">레슨후기</a></li>
											<li><a href="class_my.php">마이레슨</a></li>
                                        </ul>
									</li>
									<li data-name="gnb-coach">
										<a href="artist_list.php"><i class="fas fa-user"></i> 코치/쌤</a>
										<ul class="dropdown">
                                            <li><a href="artist_list.php">코치/쌤</a></li>
                                            <li><a href="artist_zzim.php">찜코치/쌤</a></li>
                                            <li><a href="class_artist_apply.php">코치/쌤 등록</a></li>
                                        </ul>
									</li>
									<li><a href="cafe_list.php"><i class="fa fa-comments"></i> 클럽/모임</a>
										<ul class="dropdown">
                                            <li><a href="cafe_list.php">모임목록</a></li>
											<li><a href="cafe_view.php">주제별모임</a></li>
                                            <li><a href="cafe_made.php">모임만들기</a></li>
                                            <li><a href="cafe_my.php">가입모임</a></li>
											<li><a href="cafe_set.php">모임설정</a></li>
                                        </ul>
									</li>
                                    <li><a href="watch_list.php"><i class="fa fa-video"></i> 영상</a>
                                        <ul class="dropdown">
                                            <li><a href="watch_list.php">영상홈</a></li>
                                            <li><a href="watch_best.php">인기영상</a></li>
                                            <li><a href="watch_subscript.php">구독채널</a></li>
											<li><a href="watch_like.php">찜영상</a></li>
                                            <li><a href="watch_upload.php">영상등록</a></li>
											<li><a href="watch_my.php">내영상관리</a></li>
											<li><a href="watch_set.php">영상설정</a></li>
                                        </ul>
                                    </li>                                    
                                    <li><a href="store_list.php"><i class="fa fa-share-alt"></i> 스토어</a>
										<ul class="dropdown">
                                            <li><a href="store_list.php">스토어홈</a></li>
                                            <li><a href="store_bookmark.php">즐겨찾기</a></li>
                                            <li><a href="store_review_list.php">이용후기</a></li>
                                            <li><a href="store_add.php">스토어등록</a></li>
											<li><a href="store_set.php">스토어관리</a></li>
                                        </ul>
									</li>
									<!-- <li><a href="notice.php"><i class="fas fa-comment-alt"></i> 고객센터</a>
										<ul class="dropdown">
                                            <li><a href="notice.php">뉴스&이벤트</a></li>
                                            <li><a href="faq.php">FAQ</a></li>
											<li><a href="contact.php">1:1문의</a></li>
											<li><a href="mywallet.php">내지갑</a></li>
                                        </ul>
									</li> -->
									<li><a href="/shop"  style="height:38px; width:90px; background-color:rgba(0, 0, 0, 0.3); border:2px solid #ffc107; border-radius:20px; padding:0 20px 0;"><i class="fas fa-cart-plus"></i> 쇼핑</a></li>
                                </ul>

                                <!-- Search Icon -->
                                <div id="searchIcon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>-->

                            </div>
                            <!-- Navbar End -->
                        </div>
                    </nav>

                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->


	<nav id="nav_category" class="nav_category top_fixed mobile-po">
		<div class="main_category">
			<div class="text-left">
				<a href="aside.php" title="메뉴 보기"><span class="icon ic-menu"></span></a>
			</div>
			<div>
				<h1 class="mb-0 fs-05 color-primary"><a href="/"><img src="assets/images/t_logo.png" width="110" class="mr-1 align-bottom"/></a></h1>
			</div>
			<div class="text-right li-aside">
				<a class="link-aside" href="page_notice.php" title="알림"><span class="badge <?=$미확인알림수!="0"?"badge-danger":""?> position-ab"><?=$미확인알림수?></span><i class="fas fa-bell"></i></a>
			</div>
		</div>

		<div class="nav-menu bg-gradient-primary">
			<ul>
				<li data-name="gnb-page">
					<a href="page_list.php" title="페이지">페이지</a>
				</li>
				<li data-name="gnb-lesson">
					<a href="class.php" title="레슨/클래스">레슨/클래스</a>
				</li>
				<li data-name="gnb-coach">
					<a href="artist_list.php" title="코치/쌤">코치/쌤</a>
				</li>
				<li data-name="gnb-club">
					<a href="cafe_list.php" title="모임">클럽/모임</a>
				</li>
				<li data-name="gnb-watch">
					<a href="watch_list.php" title="영상">영상</a>
				</li>
				<?/*<li data-name="gnb-game">
					<a href='javascript:void(0)' title='놀이터' onClick="alert('서비스 준비중입니다')">놀이터</a>
				</li>*/?>
				<li data-name="gnb-store">
					<a href="store_list.php" title="쇼핑">스토어</a>
				</li>
				<li data-name="gnb-shopping">
					<a href="/shop" title="쇼핑">쇼핑</a>
				</li>
			</ul>
		</div>

	</nav>

	<nav id="nav_category" class="nav_category top_fixed mobile-ho">
		<div class="main_category">
			<div class="text-left">
				<a href="aside.php" title="메뉴 보기"><span class="icon ic-menu"></span></a>
			</div>
			<div>
				<h1 class="mb-0 fs-05 color-primary"><a href="/"><img src="assets/images/t_logo.png" width="110" class="mr-1 align-bottom"/></a></h1>
			</div>
			<div class="text-right li-aside">
				<a class="link-aside" href="page_notice.php" title="알림"><span class="badge <?=$미확인알림수!="0"?"badge-danger":""?> position-ab"><?=$미확인알림수?></span><i class="fas fa-bell"></i></a>
			</div>
		</div>

		<div class="nav-menu bg-gradient-primary">
			<ul>
				<li data-name="gnb-page">
					<a href="page_list.php" title="페이지">페이지</a>
				</li>
				<li data-name="gnb-lesson">
					<a href="class.php" title="레슨/클래스">레슨/클래스</a>
				</li>
				<li data-name="gnb-coach">
					<a href="artist_list.php" title="코치/쌤">코치/쌤</a>
				</li>
				<li data-name="gnb-club">
					<a href="cafe_list.php" title="모임">모임</a>
				</li>
				<li data-name="gnb-watch">
					<a href="watch_list.php" title="영상">영상</a>
				</li>
				<li data-name="gnb-game">
					<a href='javascript:void(0)' title='게임' onClick="alert('서비스 준비중입니다')">게임</a>
				</li>
				<li data-name="gnb-store">
					<!-- <a href='javascript:void(0)' title='쇼핑/중고' onClick="alert('서비스 준비중입니다')">  --><a href="store_list.php" title="쇼핑/중고">스토어</a>
				</li>
				<li data-name="gnb-shopping">
					<a href="/shop" title="쇼핑">쇼핑</a>
				</li>
				<?/*<li data-name="gnb-cloud">
					<a href="block.php" title="BLOCK">BLOCK</a>
				</li>*/?>
			</ul>
		</div>

	</nav>



<script>
	function common_show_qr(){

		<? if( $detect->isAndroidOS() ) {?>

		window.AndroidApp.show_qr();

		<?}else if( $detect->isiOS() ){?>

		window.webkit.messageHandlers.show_qr.postMessage(null);

		<?}?>

	}	

	function set_qr(val){
		top.location.href = "gpay.php?UID="+val;
	}	

</script>
<!--floating
<div class="btn-float text-center">
  <a href="javascript:common_show_qr();">
    <img src="assets/images/qr1.png" />
    <p class="mb-0 color-10">SCAN QR</p>
  </a>
</div>
<!--//floating-->
