<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<?
$_TITLE = $dic[contact_title_view];
?>
<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg4.jpg);">
            <h2>Help Desk</h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<? include "./inc_help_nav.php"; ?>

<section class="alazea-blog-area mt-30 mb-5">
        <div class="container">

			<div class="row align-items-center justify-content-center">
				<div class="col-10 col-md-10">
						<div class="tabs">
							<div class="nav-bar nav-bar-center">
								<div class="nav-bar-item"><a href="contact.php" title="문의하기">1:1 문의하기</a></div>
								<div class="nav-bar-item active"><a href="contact_view.php" title="문의내역">문의내역</a></div>
							</div>
						</div>
						<?
			$query = "select * from tbl_contact where member_id='{$rowMember['member_id']}' order by pk_contact DESC";
			$result = db_query($query);

			$idx = 0;

			while($row = db_fetch($result)){
			?>	
						<div class="con-contact wrap-panel list-history">
							<div class="panel">
								<div class="tlt collapsed" data-toggle="collapse" data-target="#question<?=++$idx?>" role="button" aria-expanded="false" href="javascript:void(0)">
									<div>
										<p class="fs-005"><?=$row['subject']?></p>
										<span class="fs--1 fw-500 color-7"><?=date("Y-m-d", strtotime($row['regdate']))?></span>
									</div>
									<!--답변완료 badge-success / 답변대기 badge-gray / 보류 badge-danger-->

									<div class="list-badge badge badge-pill <?if($row['status']=="신규"){echo "badge-success";}?> <?if($row['status']=="상담진행중"){echo "badge-danger";}?> <?if($row['status']=="신규접수"){echo "badge-gray";}?>"><?=$row['status']?></div>
								</div>
								<div class="collapse" id="question<?=$idx?>" href="javascript:void(0)">
									<div class="background-11 p-3">
										<div class="mb-2 fs-005 color-5">Q. <?=$row['subject']?></div>
										<div class="fs-005 mt-3">
										<? if($row['answer']){?>
										<span>A.  <?=$row['answer']?></span>
										<?}else{?>
										<span>A.  답변 준비중입니다.</span>
										<?}?></div>
									</div>
								</div>
							</div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
		
		</section>
		<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_main.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="help"]').addClass('active');
</script>
</html>