<!DOCTYPE HTML>
<html lang="en">
<?php include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">
<?
$_TITLE = $dic[contact_title_view];
?>
<body>
	<? include "./inc_Top.php"; ?>
		<section class="wrap-contact py-0 pb-6">
								

                      <!-- <div class="panel pl-0 mb-0">
                        <div class="tlt collapsed p-3" data-toggle="collapse" data-target="#question<?=++$idx?>" aria-expanded="false" href="javascript:void(0)">
                          <div class="con-info p-0">
                            <p class="mb-1 fs-005 fw-500">
                                <span><?=$row['subject']?></span>
                            </p> 
                            <p class="mb-0 fs--1 fw-500 color-7">
                                <span><?=date("Y-m-d", strtotime($row['regdate']))?></span>
                                <span><?=date("H:i:s", strtotime($row['regdate']))?></span>
                            </p>
                          </div>
                          <div class="badge badge-pill <?=$row['status']!="답변완료"?"background-4":"badge-primary"?>">
                                <p><?=$dic[$row['status']]?></p>
                          </div>  
                        </div>
                        <div id="question<?=$idx?>" class="answer panel-collapse collapse p-3 background-11" href="javascript:void(0)">
                          <p class="fs-005 fw-200 color-6">
                            <span class="mb-2">Q. <?=$row['subject']?></span>
							<? if($row['answer']){?>
							<span>A.  <?=$row['answer']?></span>
                            <?}?>
                          </p>
                        </div>
                      </div> -->


			
			<div class="container header-top">
				<div class="row align-items-center justify-content-center">
					<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
						<div class="tabs">
							<div class="nav-bar nav-bar-center">
								<div class="nav-bar-item"><a href="contact_cloud.php" title="문의하기">문의하기</a></div>
								<div class="nav-bar-item active"><a href="contact_cloud_view.php" title="문의내역">문의내역</a></div>
							</div>
						</div>
						<?
			$query = "select * from tbl_cloud_qna where member_id='{$rowMember['member_id']}' order by pk_cloud_qna DESC";
			$result = db_query($query);

			$idx = 0;

			while($row = db_fetch($result)){
			?>	
						<div class="con-contact wrap-panel list-history">
							<div class="panel">
								<div class="tlt collapsed" data-toggle="collapse" data-target="#question<?=++$idx?>" role="button" aria-expanded="false" href="javascript:void(0)">
									<div>
										<p class="fs-005"><?=$row['토큰이름']?></p>
										<span class="fs--1 fw-500 color-7"><?=date("Y-m-d", strtotime($row['문의일시']))?></span>
									</div>
									<!--답변완료 badge-success / 답변대기 badge-gray / 보류 badge-danger-->

									<div class="list-badge badge badge-pill <?if($row['처리상태']=="상담완료"){echo "badge-success";}?> <?if($row['처리상태']=="상담진행중"){echo "badge-danger";}?> <?if($row['처리상태']=="신규접수"){echo "badge-gray";}?>"><?=$row['처리상태']?></div>
								</div>
								<div class="collapse" id="question<?=$idx?>" href="javascript:void(0)">
									<div class="background-11 p-3">
										<div class="mb-2 fs-005 color-5">Q. <?=$row['문의내용']?></div>
										<div class="fs-005 mt-3">
										<? if($row['답변']){?>
										<span>A.  <?=$row['답변']?></span>
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
</body>
<script>
	$('.nav_bottom li[data-name="service"]').addClass('active');
</script>
</html>