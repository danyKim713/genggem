<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/main.css">
<body class="mb-6">
	<? include "./inc_nav.php"; ?>
	<section>
		<div class="container header-top">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 px-0">
					<!--tab-->
					<div id="tab-menu" class="clearfix">
						<ul class="d-flex align-items-center justify-content-center text-center">
							<li class="col p-0"><a href="jurnal.php?cat=golfen" title="정보">선수/대회</a></li>
							<li class="col p-0"><a href="jurnal.php?cat=golfevent" title="게시판">골프이벤트</a></li>
							<li class="col p-0"><a href="jurnal.php?cat=golfind" title="갤러리">골프산업</a></li>
							<li class="col p-0"><a href="jurnal.php?cat=golfnews" title="채팅">골프뉴스</a></li>
						</ul>
					</div>
					<!--tab-->

					<!--저널 검색-->
					<article class="mb-2 mt-5">
						<div class="p-3 position-r">
							<div class="w-75">
								<input class="form-control" id="페이지검색" name="페이지검색" type="search" placeholder="저널을 검색해 보세요." />
								<a href="jurnal_list.php"><button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-3 mb-1" type="button">검색</button></a>
							</div>
						</div>
					</article>
					<!--//저널 검색-->
	
					
					<!--HOT 뉴스-->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">HOT NEWS</h3>
						<div class="list-video list-even mt-3">
							<ul class="d-flex flex-wrap">

<?
if(!$cat){
	$cat = "golfen";
}

require_once "_inc_db_conn_freeneo.com";

$query = "select * from watch_keyword_result A, watch_keyword_target B where A.keyword_target_id = B.keyword_target_id and A.company_cd = '{$cat}' order by A.result_id DESC LIMIT 0,4";
$result = mysqli_query($conn,$query);

for ($i=0; $i<mysqli_num_rows($result); $i++){
	$row = mysqli_fetch_array($result);


	$page_content = file_get_contents($row['content_url']);

	//echo $page_content;
		
	$dom_obj = new DOMDocument();
	$dom_obj->loadHTML($page_content);

	$meta_val = "";

	foreach($dom_obj->getElementsByTagName('meta') as $meta) {
		if($meta->getAttribute('property')=='og:image'){ 
			$meta_val = $meta->getAttribute('content');
		}
	}

?>

								<li>
									<a href="<?=$row['content_url']?>" title="">
										<div>
											<img src="/_PROGRAM_phpThumb/phpThumb.php?src=<?=$meta_val?>&w=168&h=120&zc=2" width="168"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> <?=$row['source_name']?></h4>
											<p class="color-5 ellipsis-2"><?=$row['title']?></p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i><?=rand(500,2000)?>회</span>
										</div>
									</a>
								</li>

<?}?>

								<!-- <li>
									<a href="/" title="">
										<div>
											<img src="assets/images/jr_2.jpg"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> PGA RSM클래식</h4>
											<p class="color-5 ellipsis-2">이것 하나면 드라이버가 똑바로 멀리 | 명품스윙 에이미 조...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>20,115회</span>
										</div>
									</a>
								</li>
								<li>
									<a href="/" title="">
										<div>
											<img src="assets/images/jr_3.jpg"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> KPGA 챌린티투어</h4>
											<p class="color-5 ellipsis-2">'Road to the Korean toru(로드 투 더 코리안투어)라는 부재로...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>351회</span>
										</div>
									</a>
								</li>
								<li>
									<a href="/" title="">
										<div>
											<img src="assets/images/jr_4.jpg"/>
										</div>
										<div class="con-info">
											<h4 class="fs-005 ellipsis"><i class="fas fa-blog align-text-top fs--1 color-warning mt-1"></i> Korean golfers miss out at 35th Donghae Open</h4>
											<p class="color-5 ellipsis-2">[YONHAP]Jbe' Kruger of South Africa picked up his first...</p>
											<span class="color-6 fs--1"><i class="fas fa-eye opacity-50 mr-1"></i>2,129회</span>
										</div>
									</a>
								</li> -->
							</ul>
						</div>
					</article>					
					<!--//-->

					<!-- 새로운 뉴스 // 20개 리스팅 -->
					<article class="p-3 mb-2">
						<h3 class="main-tlt display-inline">Golfen 저널 새소식</h3>
						<div class="list-tour tour-wide mt-3">
							<ul>

<?
require_once "_inc_db_conn_freeneo.com";

$query = "select * from watch_keyword_result A, watch_keyword_target B where A.keyword_target_id = B.keyword_target_id and A.company_cd = '{$cat}' order by A.result_id DESC LIMIT 4,20";
$result = mysqli_query($conn,$query);

for ($i=0; $i<mysqli_num_rows($result); $i++){
	$row = mysqli_fetch_array($result);
?>

								<li>
								<a href='<?=$row['content_url']?>' title='뉴스보기' class="d-flex align-items-center">
									<div class="con-info">
										<h4 class="tlt"><?=$rowCoach["lesson_title"]?><?=$row['title']?></h4>
											<dl class="txt-info d-flex">
												<dd><span class="color-6 fs--1"><i class="fas fa-sticky-note opacity-50 mr-1"></i><?=$row['source_name']?></span></dd>
											</dl>
									</div>
								</a>
								</li>
<?}?>
							</ul>
						</div>
					</article>
					<!-- //레슨코치 -->


					<?// include "./inc_Bottom_jurnal.php"; ?>
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	$('.slider-banner').slick({
		dots: false,
		arrows: false,
		autoplay: true,
		autoplaySpeed: 3000
	});
	$('.nav_category li[data-name="gnb-journal"]').addClass('active');
	$('.nav_bottom li[data-name="jurnalhome"]').addClass('active');
</script>
</html>