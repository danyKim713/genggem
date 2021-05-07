<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<li data-name="home">
			<a href="bookinghome.php" title="">
			<i class="biko-home"></i><p>홈</p></a>
		</li>
		<li data-name="booking">
			<a href="channel_made.php" title="">
			<i class="fas fa-calendar-check"></i><p>부킹</p></a>
		</li>
		<li data-name="tour">
			<a href="channel_list.php" title="">
			<i class="fas fa-plane"></i><p>투어</p></a>
		</li>
		<li data-name="like">
			<a href="channel_my.php" title="">
			<i class="fas fa-thumbs-up"></i><p>좋아요</p></a>
		</li>
		<li data-name="mypage">
			<a href="channel_set.php" title="">
			<i class="fas fa-cog"></i><p>마이페이지</p></a>
		</li>
	</ul>
</nav>

<script src="/js/dev.js"></script>


<? if(false){// in_array($REMOTE_ADDR,  $dev_ips)){?>
 	<iframe name="_fra" width="500" height="500" align="right" frameborder="0"  scrolling="auto"></iframe>
<? }else{?>
	<iframe name="_fra" width="0" height="0" align="right" frameborder="0"  scrolling="auto" ></iframe>
<? }?>