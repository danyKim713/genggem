<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<?
$query = "select * from gf_page_article where pk_page_article = '{$_GET['pk_page_article']}'";
$row = db_select($query);

$query = "select * from tbl_member where member_id = '{$row['member_id']}'";
$rowM = db_select($query);

$query = "select * from gf_page_reply where fk_page_article = '{$_GET['pk_page_article']}'";
$resultReplyCNT = db_query($query);
$댓글수 = mysqli_num_rows($resultReplyCNT);

$query = "select * from gf_page_reply where fk_page_article = '{$_GET['pk_page_article']}' and fk_page_reply	 = '0' order by 등록일시 DESC";
$resultReply = db_query($query);
?>



<body>
<? include "./inc_Top.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					<!--tab-->
					<div id="tab-menu" class="clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0"><a href="jurnal.php" title="정보">선수/대회</a></li>
							<li class="col p-0"><a href="jurnal_event.php" title="게시판">골프이벤트</a></li>
							<li class="col p-0"><a href="jurnal_in.php" title="갤러리">골프산업</a></li>
							<li class="col p-0"><a href="jurnal_news.php" title="채팅">골프뉴스</a></li>
						</ul>
					</div>
					<!--tab-->

					<!-- 리스팅 // 무제한 찜한 날짜역순(최근이 위) 리스팅 -->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">Golfen 저널 새소식</h3>
						<div class="list-tour tour-wide mt-3">
							<ul>
								<li>
									<div class="con-info">
										<h4 class="tlt"><?=$rowCoach["lesson_title"]?>[선수/대회] </h4>
										<h4 class="tlt">세계 1위 고진영, 미국골프기자협회 선정 '올해의 선수'...</h4>
											<dl class="txt-info d-flex">
												<dd><span class="color-6 fs--1"><i class="fas fa-sticky-note opacity-50 mr-1"></i>이데일리 스타in 주영로 기자] 여자 골프 세계랭킹 1위 고진영(25)이 미국골프기자협회(GWAA)가 선정한 2019 여자 올해의 선수상을 받는다.</span></dd>
											</dl>
									</div>
									<a href="찜해제" class="btn btn-outline-primary btn-sm btn-capsule ml-2 mb-2"><i class="fas fa-star fs--1 opacity-50"></i> 찜해제</a>
								</li>
								
								<li>
									<div class="con-info">
										<h4 class="tlt"><?=$rowCoach["lesson_title"]?>[선수/대회] </h4>
										<h4 class="tlt">세계 1위 고진영, 미국골프기자협회 선정 '올해의 선수'...</h4>
											<dl class="txt-info d-flex">
												<dd><span class="color-6 fs--1"><i class="fas fa-sticky-note opacity-50 mr-1"></i>이데일리 스타in 주영로 기자] 여자 골프 세계랭킹 1위 고진영(25)이 미국골프기자협회(GWAA)가 선정한 2019 여자 올해의 선수상을 받는다.</span></dd>
											</dl>
									</div>
									<a href="찜해제" class="btn btn-outline-primary btn-sm btn-capsule ml-2 mb-2"><i class="fas fa-star fs--1 opacity-50"></i> 찜해제</a>
								</li>
							</ul>
						</div>
					</article>
					<!-- // -->
					<? include "./inc_Bottom_jurnal.php"; ?>
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	$(document).ready(function(){
		$('.btn-reply').on("click",function(){
			$(this).parent('div').next().toggleClass("active");
			console.log('text');
		});
	});

	$('.nav_category li[data-name="gnb-journal"]').addClass('active');
	$('.nav_bottom li[data-name="jurnallike"]').addClass('active');
</script>
</html>