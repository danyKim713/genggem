<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<li data-name="home">
			<a href="page_list.php" title="">
			<i class="biko-home"></i><p>페이지홈</p></a>
		</li>
		<li data-name="page">
			<a href="page_me.php" title="">
			<i class="fas fa-address-book"></i><p>내페이지</p></a>
		</li>
		<li data-name="pagesearch">
			<a href="page_search.php" title="">
			<i class="fas fa-search"></i><p>페이지검색</p></a>
		</li>
		<li data-name="friend">
			<a href="page_friends.php" title="">
			<i class="fas fa-users"></i><p>친구</p></a>
		</li>
		<li data-name="board">
			<a href="page_board.php" title="">
			<i class="biko-service"></i><p>글보기</p></a>
		</li>
	</ul>
</nav>

<? if(false){// in_array($REMOTE_ADDR,  $dev_ips)){?>
 	<iframe name="_fra" width="500" height="500" align="right" frameborder="0"  scrolling="auto"></iframe>
<? }else{?>
	<iframe name="_fra" width="0" height="0" align="right" frameborder="0"  scrolling="auto" ></iframe>
<? }?>