<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<li data-name="home">
			<a href="store_list.php" title="">
			<i class="biko-home"></i><p>스토어홈</p></a>
		</li>
		<li data-name="storebookmark">
			<a href="store_bookmark.php" title="">
			<i class="fas fa-star"></i><p>즐겨찾기</p></a>
		</li>
		<li data-name="storemyview">
			<a href="store_review_my.php" title="">
			<i class="fas fa-user-edit"></i><p>내이용후기</p></a>
		</li>
		<li data-name="storeadd">
			<a href="store_add.php" title="">
			<i class="fas fa-plus-circle"></i><p>스토어등록</p></a>
		</li>
		<li data-name="storeset">
			<a href="store_set.php" title="">
			<i class="fas fa-cogs"></i><p>스토어관리</p></a>
		</li>
	</ul>
</nav>

<script src="/js/dev.js"></script>


<? if(false){// in_array($REMOTE_ADDR,  $dev_ips)){?>
 	<iframe name="_fra" width="500" height="500" align="right" frameborder="0"  scrolling="auto"></iframe>
<? }else{?>
	<iframe name="_fra" width="0" height="0" align="right" frameborder="0"  scrolling="auto" ></iframe>
<? }?>