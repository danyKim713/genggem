<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css?20191011">
<?
$_TITLE = 알림;
?>
<body class="mb-6">
	<? include "./inc_Top.php"; ?>
	<section>
		<div class="container header-top page-notice">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-8 col-lg-6 col-xl-6 px-0">
					<!--알림 검색-->
					<!-- <article class="mb-2">
						<div class="p-3 position-r">
							<div class="w-75">
								<input class="form-control" id="페이지검색" name="페이지검색" type="search" placeholder="알림을 검색해주세요." />
								<button class="btn-right position-ab btn btn-outline-secondary btn-sm mr-3 mb-1" type="button">검색</button>
							</div>
						</div>
					</article> -->
					<!--//알림 검색-->
					<article class="py-3 mb-2">

<?
$query = "select count(*) as cnt from gf_push_history where rcv_member_id = '{$rowMember['member_id']}' and 알림읽음여부 = 'N'";
$rowC = db_select($query);
$미확인알림수 = number_format($rowC['cnt']);
?>

						<!--읽지않은 알림 개수 표시-->
						<h3 class="main-tlt display-inline ml-3">미확인 알림 <span class="color-primary"><?=$미확인알림수?></span></h3>
						<div class="list list-default mt-3">
							<ul>

<?
$query = "select * from gf_push_history where rcv_member_id = '{$rowMember['member_id']}' order by pk_push_history DESC LIMIT 0,50";
$result = db_query($query);

while($row = db_fetch($result)){

	$rowM = get_member_row($row['sender_member_id']);
?>

								<!--읽지않은 알림-->
								<li <?=$row['알림읽음여부']=="N"?'class="unread"':''?>>
									<a href="<?=$row['링크']?>" title="">
										<div>
											<img src="<?=phpThumb("/_UPLOAD/".($rowM['페이지배경사진']?$rowM['페이지배경사진']:$rowM['페이지프로필사진']),70,70,"2","assets/images/user_img.jpg")?>" width="70" height="70" class="rounded-circle">
										</div>
										<div class="con-page">
											<p class="color-6 fs-005 mb-0">[<?=$row['구분']?>] <?=$row['메시지']?></p>
											<span class="color-6 fs--1 mt-1 d-block"><?=date("Y.m.d",strtotime($row['푸쉬일시']))?></span>
										</div>
									</a>
								</li>
<?
//읽음여부 처리
$query = "update gf_push_history set 알림읽음여부 = 'Y' where pk_push_history = '{$row['pk_push_history']}' ";
db_query($query);
?>


<?}?>

								
							</ul>
						</div>
					</article>
					
				</div>
			</div>
		</div>
	</section>
</body>

<? include "./inc_Bottom_main.php"; ?>

<script>
	$('.nav_bottom li[data-name="notice"]').addClass('active');
</script>


</html>