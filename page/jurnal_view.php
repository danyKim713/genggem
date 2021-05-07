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
							<li class="col p-0 active"><a href="jurnal.php" title="정보">선수/대회</a></li>
							<li class="col p-0"><a href="jurnal_event.php" title="게시판">골프이벤트</a></li>
							<li class="col p-0"><a href="jurnal_in.php" title="갤러리">골프산업</a></li>
							<li class="col p-0"><a href="jurnal_news.php" title="채팅">골프뉴스</a></li>
						</ul>
					</div>
					<!--tab-->
					<!--게시글-->
					<article class="p-3 mb-2 position-r mt-5">
						<!-- 작성자 정보-->
						<div class="d-flex align-items-end mb-3">
							<div class="page-write lh-3">
								<h3 class="fs-005 mb-0">[뷴류: 선수/대회]</h3>
								<span class="post">세계 1위 고진영, 미국골프기자협회 선정 '올해의 선수' 뽑혀
								등록: 2020-01-10</span>
								<div class="mt-2"><a href="찜하기" class="btn btn-outline-primary btn-sm btn-capsule"><i class="fas fa-star fs--1 opacity-50"></i> 찜하기</a></div>
							</div>
						</div>
						<!-- //작성자 정보-->
						<!--작성글 및 태그-->
						<div class="page-write">
							<p class="post"><?=$row['내용']?>주영로 기자

고진영. (사진=AFPBBNews)
[이데일리 스타in 주영로 기자] 여자 골프 세계랭킹 1위 고진영(25)이 미국골프기자협회(GWAA)가 선정한 2019 여자 올해의 선수상을 받는다.

GWAA는 8일(한국시간) 회원 비밀 투표에서 고진영이 넬리 코다(미국)를 제치고 가장 많을 표를 받았다고 밝혔다.


고진영은 2019년 ANA 인스퍼레이션과 에비앙 챔피언십 등 두 차례 메이저대회 우승 포함 미국여자프로골프(LPGA) 투어에서 4승을 올리며 올해의 선수와 상금왕, 베어트로피(최저타수상) 등을 모두 휩쓸었고, 7월 말부터 계속해서 세계랭킹 1위에 올라 있다.

남자부에서는 브룩스 켑카(미국)가 로리 매킬로이(북아일랜드)를 제치고 올해의 선수상을 받았다. 마스터스에 조조 챔피언십에서 우승한 타이거 우즈(미국)는 3위에 그쳤다.</p>
							<div class="fs-005 mt-1 color-6">
								<span class="mr-2">#<?=$rowT['태그내용']?></span>
							</div>
						</div>
						<!--//작성글 및 태그-->

						<!--버튼-->
						<div class="page-box text-center">
							<div class="row m-0">
								<div class="col p-0 ">
									<div class="checkbox">
										<input id="chk1" name="chk_good" type="checkbox" class="invisible good_<?=$row['pk_page_article']?>" <?=좋아요카운트($row['pk_page_article'])>0?"checked":""?> onChange="go_like('<?=$row['pk_page_article']?>','like_id_<?=$row['pk_page_article']?>');">
										<label for="chk1" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5" ></i>좋아요 <span class="color-primary" id="like_id_<?=$row['pk_page_article']?>"><?=좋아요카운트($row['pk_page_article'])?></span></label>
									</div>
								</div>
								<!-- <div class="col p-0">
									<a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=number_format($댓글수)?></span></a>
								</div> -->
								<!-- <div class="col p-0">
									<a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>
								</div> -->
							</div>
						</div>
						<!--//버튼-->
					</article>
					<!--//게시글-->
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
	$('.nav_bottom li[data-name="jurnalhome"]').addClass('active');
</script>
</html>