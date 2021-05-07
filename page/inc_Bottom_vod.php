<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<div class="text-left" style="padding:0 0 10px 10px;">
			<a href="javascript:history.back();" title="뒤로가기" class="link-back"><font size="6px" color=""><span class="icon ic-left-arrow"></span></font></a>
		</div>
		<li data-name="watchhome">
			<a href="watch_list.php" title="">
			<i class="fa fa-list"></i><p>영상목록</p></a>
		</li>
		<li data-name="watchupload">
			<a href="watch_upload.php" title="">
			<i class="fab fa-youtube"></i><p>영상등록</p></a>
		</li>
		<li data-name="myvideo">
			<a href="watch_my.php" title="">
			<i class="fas fa-list-ul"></i><p>내영상관리</p></a>
		</li>
		<li data-name="watchset">
			<a href="watch_set.php" title="">
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