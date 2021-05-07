<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<li data-name="jurnalhome">
			<a href="jurnal.php" title="">
			<i class="biko-home"></i><p>저널홈</p></a>
		</li>
		<li data-name="jurnallike">
			<a href="jurnal_like.php" title="">
			<i class="fas fa-calendar-plus"></i><p>찜한뉴스</p></a>
		</li>
		<li data-name="jurnalsearch">
			<a href="jurnal_list.php" title="">
			<i class="fas fa-search"></i><p>전체뉴스</p></a>
		</li>
		<li data-name="jurnalset">
			<a href="jurnal_set.php" title="">
			<i class="fas fa-cog"></i><p>설정</p></a>
		</li>
	</ul>
</nav>

<script src="/js/dev.js"></script>


<? if(false){// in_array($REMOTE_ADDR,  $dev_ips)){?>
 	<iframe name="_fra" width="500" height="500" align="right" frameborder="0"  scrolling="auto"></iframe>
<? }else{?>
	<iframe name="_fra" width="0" height="0" align="right" frameborder="0"  scrolling="auto" ></iframe>
<? }?>