<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<li data-name="myinfo">
			<a href="aside.php" title="">
			<i class="fas fa-address-book"></i><p>마이페이지</p></a>
		</li>
		<li data-name="notice">
			<a href="notice.php" title="">
			<i class="biko-service"></i><p>공지/이벤트</p></a>
		</li>
		<li data-name="home">
			<a href="main.php" title="">
			<i class="biko-home"></i><p>홈</p></a>
		</li>
		<li data-name="help">
			<a href="contact.php" title="">
			<i class="fas fa-sticky-note"></i><p>문의하기</p></a>
		</li>
		<li data-name="wallet">
			<a href="mywallet.php" title=""><i class="fas fa-wallet"></i><p>G-PAY</p></a>
		</li>
	</ul>
</nav>

<? if(false){// in_array($REMOTE_ADDR,  $dev_ips)){?>
 	<iframe name="_fra" width="500" height="500" align="right" frameborder="0"  scrolling="auto"></iframe>
<? }else{?>
	<iframe name="_fra" width="0" height="0" align="right" frameborder="0"  scrolling="auto" ></iframe>
<? }?>