<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<li data-name="coludhome">
			<a href="block.php" title="">
				<i class="fas fa-cloud"></i><p>블록 홈</p></a>
		</li>
		<li data-name="ncloudmy">
			<a href="block_my.php" title="">
			<i class="fas fa-user-check"></i><p>나의 GEN</p></a>
		</li>
		<li data-name="nagency">
			<?
			if($rowMember['agency_status'] ==  "N"){
				$link = "block_agency.php";
			}else{
				$link = "block_agency_detail.php";
			}
			?>
			<a href="<?=$link?>" title="">
			<i class="fas fa-address-card"></i><p>에이전시</p></a>
		</li>
		<li data-name="ndeposit">
			<a href="block_contact.php" title="">
			<i class="fas fa-comments-dollar"></i><p>입금확인</p></a>
		</li>
		<li data-name="wallet">
			<a href="mywallet.php" title="">
			<i class="fas fa-wallet"></i><p>내지갑</p></a>
		</li>
	</ul>
</nav>

<script src="/js/dev.js"></script>


<? if(false){// in_array($REMOTE_ADDR,  $dev_ips)){?>
 	<iframe name="_fra" width="500" height="500" align="right" frameborder="0"  scrolling="auto"></iframe>
<? }else{?>
	<iframe name="_fra" width="0" height="0" align="right" frameborder="0"  scrolling="auto" ></iframe>
<? }?>