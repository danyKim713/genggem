<!-- Preloader 
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="./assets/img/core-img/leaf.png" alt="">
        </div>
    </div>-->

    <!-- ##### Header Area Start ##### -->
    <header class="header-area">

        <!-- ***** Top Header Area ***** -->
        <div class="top-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="top-header-content d-flex align-items-center justify-content-between">
                            <!-- Top Header Content -->
                            <div class="top-header-meta">
								<a class="link-aside" href="page_notice.php" data-toggle="tooltip" data-placement="bottom" title="(<?=$미확인알림수?>)개의 미확인 알림이 있습니다."><span class="badge <?=$미확인알림수!="0"?"badge-danger":""?> position-ab"><?=$미확인알림수?></span><i class="fas fa-bell"></i> &nbsp;미확인알림</a>
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="+1 234 122 122"><i class="fa fa-phone" aria-hidden="true"></i> <span>Call Us: 070 8616 8425</span></a> 
                            </div>

                            <!-- Top Header Content -->
                            <div class="top-header-meta d-flex">
                                <!-- Language Dropdown -->
                                <div class="language-dropdown">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mr-30" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Language</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="<?=$_COOKIE['dic_lang']=="ko"?"selected":""?>">한국어</a>
                                            <a class="dropdown-item" href="<?=$_COOKIE['dic_lang']=="en"?"selected":""?>">Eng</a>
											<a class="dropdown-item" href="<?=$_COOKIE['dic_lang']=="cn"?"selected":""?>">中文简体</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Login -->
                                <div class="login">
                                    <a href="join2.php"><i class="fa fa-user" aria-hidden="true"></i> <span>Sign up</span></a>
                                </div>
                                <!-- Cart -->
                                <div class="cart">
                                    <a href="login.php"><i class="fa fa-lock" aria-hidden="true"></i> <span>Login </span> <!-- <span class="cart-quantity">(1)</span>--></a>
                                </div>
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
                            <div class="classynav">
                                <ul>
                                    <li style="padding-right:10px;"><a href="hanc.php"  style="height:38px; background-color:rgba(0, 0, 0, 0.3); border:2px solid #ff4b4b; border-radius:20px; padding:0 17px 0;"><img src="./assets/img/core-img/hanc_logo.png" alt=""> 한국문화센터 클래스</a>
										<ul class="dropdown">
                                            <li><a href="hanc.php">문화센터소개</a></li>
                                            <li><a href="hanc_lecture.php">강좌안내</a></li>
                                            <li><a href="hanc_apply.php">수강신청</a></li>
                                            <li><a href="hanc_online.php">온라인강좌</a></li>
											<li><a href="hanc_center.php">전국지부안내</a></li>
                                        </ul>
									</li>
                                    <li style="padding-right:10px;"><a href="lesson_contents.php" style="height:38px; background-color:rgba(0, 0, 0, 0.3); border:2px solid #3296c5; border-radius:20px; padding:0 17px 0;"><i class="fas fa-book-open"></i> 오픈 클래스</a>
										<ul class="dropdown">
                                            <li><a href="lesson_contents.php">클래스홈</a></li>
                                            <li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >작가소개</a></li>
                                            <li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >작가등록</a></li>
                                            <li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >찜작가</a></li>
											<li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >찜클래스</a></li>
											<li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >클래스후기</a></li>
											<li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >마이클래스</a></li>
											<li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >클래스설정</a></li>
                                        </ul>
									</li>
									<li style="padding-right:10px;"><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')"  style="height:38px; background-color:rgba(0, 0, 0, 0.3); border:2px solid #ffc107; border-radius:20px; padding:0 17px 0;"><i class="fas fa-cart-plus"></i> 쇼핑</a></li>
									<li><a href="channel.php">CAFE</a>
										<ul class="dropdown">
                                            <li><a href="channel.php">카페홈</a></li>
                                            <li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >카페만들기</a></li>
                                            <li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >카페검색</a></li>
                                            <li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >가입카페</a></li>
											<li><a href='javascript:void(0)' onClick="alert('서비스 준비중입니다')" >카페설정</a></li>
                                        </ul>
									</li>
                                    <li><a href="watch_list.php">VIDEO</a>
                                        <ul class="dropdown">
                                            <li><a href="watch_list.php">비디오홈</a></li>
                                            <li><a href="watch_best.php">인기영상</a></li>
                                            <li><a href="watch_subscript.php">구독영상</a></li>
                                            <li><a href="watch_upload.php">영상등록</a></li>
											<li><a href="watch_my.php">내영상관리</a></li>
											<li><a href="watch_my.php">좋아요영상</a></li>
											<li><a href="watch_set.php">영상설정</a></li>
                                        </ul>
                                    </li>
                                    
                                    <li><a href="franchise.php">STORE</a>
										<ul class="dropdown">
                                            <li><a href="franchise.php">스토어홈</a></li>
                                            <li><a href="franchise_bookmark.php">즐겨찾기</a></li>
                                            <li><a href="franchise_review_list.php">이용후기</a></li>
                                            <li><a href="franchise_add.php">스토어등록</a></li>
											<li><a href="franchise_own.php">스토어관리</a></li>
                                        </ul>
									</li>
									<li><a href="contact.html">WEBZINE</a>
										<ul class="dropdown">
                                            <li><a href="index.html">Magazine</a></li>
                                            <li><a href="notice.php">Notice&Event</a></li>
                                            <li><a href="shop.html">FAQ</a></li>
                                            <li><a href="portfolio.html">Q&A</a></li>
                                        </ul>
									</li>
                                </ul>

                                <!-- Search Icon 
                                <div id="searchIcon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>-->

                            </div>
                            <!-- Navbar End -->
                        </div>
                    </nav>

                    <!-- Search Form -->
                    <div class="search-form">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Type keywords &amp; press enter...">
                            <button type="submit" class="d-none"></button>
                        </form>
                        <!-- Close Icon -->
                        <div class="closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->
<script>
	function common_show_qr(){

		<? if( $detect->isAndroidOS() ) {?>

		window.AndroidApp.show_qr();

		<?}else if( $detect->isiOS() ){?>

		window.webkit.messageHandlers.show_qr.postMessage(null);

		<?}?>

	}	

	function set_qr(val){
		top.location.href = "chcsend.php?UID="+val;
	}	

</script>
<!--floating-->
<div class="btn-float text-center">
  <a href="javascript:common_show_qr();">
    <img src="assets/images/qr1.png" />
    <p class="mb-0 color-10">SCAN QR</p>
  </a>
</div>
<!--//floating-->
