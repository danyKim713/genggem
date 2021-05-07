<!DOCTYPE HTML>
<html lang="en">
<? 
$NO_LOGIN = "Y";
include "./inc_program.php"; 
?>
<? include "./inc_Head.php"; ?>

<script>
	function show_map(id){
		$("#"+id).toggle();
	}
</script>

<script type="text/javascript">
function popct(url, w, h) {
popw = (screen.width - w) / 2;
poph = (screen.height - h) / 2;
popft = 'height=' + h + ',width=' + w + ',top=' + poph + ',left=' + popw;
window.open(url, '', popft);
}

	function go_delete_meeting(pVal){
        if (confirm("모임을 취소하시겠습니까?")) {
            $.ajax({
                url: "_ajax_channel_moim_delete_action.php",
                type: 'post',
                data: {
                    txtRecordNo: pVal,
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    if (Data == "SUCCESS") {
                        alert('모임 취소가 처리되었습니다.');
                        location.reload();
                    } else {
                        alert("오류가 발생했습니다. 관리자에게 문의하세요.");
                    }
                } 
            });
        }
	}
</script>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg8.jpg);">
            <h2>CAFE <font size="5px">in</font>...<br>
			<font size="4px" color="">Open Community</font></h2>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

	<section id="m_nav2">
			<? 
			$nowMenu  = "카페홈";
			include "inc_tab_menu_channel.php"; 
			?>
	</section>

	<!-- ##### Blog Content Area Start ##### -->
    <section class="blog-content-area section-padding-0-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Blog Posts Area -->
                <div class="col-12 col-md-8">
                    <div class="blog-posts-area">

                        <!-- Post Details Area -->
                        <div class="single-post-details-area">
                            <div class="post-content">
                                <h4 class="post-title"><?if($rowMember['member_id'] == $rowChannel['member_id']){?>
								<i class="fas fa-crown color-warning mr-1"></i>
								<?}?><?=$rowChannel['채널이름']?></h4>
								<p>https://cafehands.com/page/cafe.php?CID=<?=$rowChannel['CID']?> <button type="button" class="btn btn-primary btn-xs" onClick="copyToAddress('#channel-address');"><i class="far fa-clone"></i> 카페 URL복사</button>
								<span id="channel-address" style="display: none;"><?=isSecure()?"https":"http"?>://<?=$_SERVER['HTTP_HOST']?>/page/cafe.php?CID=<?=$rowChannel['CID']?></span></p>
                                <div class="post-thumbnail mb-30">
                                    <img src="<?=phpThumb("/_UPLOAD/".$rowChannel['채널배경사진'], 697, 400, "2","assets/images/ex_img8.jpg")?>" />
                                </div>

								<p class="justify-content-between align-items-center">
								<? if($rowChannel['member_id'] == $rowMember['member_id']){?>
								<button type="button" class="btn btn-info btn-sm mb-2" onClick="location.href='cafe_moim_set.php?CID=<?=$rowChannel['CID']?>'"><i class="fas fa-cog"></i> 카페설정</button>
								<?}?>

								<?
								$query = "select count(*) as cnt from gf_channel_interested where fk_member = '{$rowMember['member_id']}' and fk_channel = '{$rowChannel['pk_channel']}'";
								$rowI = db_select($query);
								if($rowI['cnt'] == 0){
								?>
								<!--  관심카페 등록하기전-->
								<button type="button" class="btn btn-info2 btn-sm mb-2" onClick="javascript:go_interested_channel();"><i class="fa fa-heart"></i> 관심카페추가</button>
								<!-- //끝 -->
								<?}else{?>
								<!-- 관심카페로 등록한때 -->
								<button type="button" class="btn btn-info2 btn-sm mb-2" onClick="javascript:go_un_interested_channel();"><i class="fa fa-heart"></i> 관심카페해제</button>
								<!-- //끝-->
								<?}?>

								<?
								$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}' and 강퇴여부 = 'N'";
								$rowM = db_select($query);

								if(!$rowM['pk_channel_member']  && $rowMember['member_id'] != $rowChannel['member_id']){
								?>
								<button type="button" class="btn btn-info4 btn-sm mb-2" onClick="javascript:go_channel_채널가입('<?=$rowChannel['pk_channel']?>');"><i class="fa fa-search-plus"></i> 카페가입하기</button>
								<?}else if($rowMember['member_id'] != $rowChannel['member_id']){?>
								<button type="button" class="btn btn-info4 btn-sm mb-2" onClick="javascript:go_channel_채널탈퇴('<?=$rowChannel['pk_channel']?>');"><i class="fa fa-search-minus"></i> 카페탈퇴하기</button>
								<?}?>

								<? if($rowChannel['member_id'] != $rowMember['member_id']){?>
								<button type="button" class="btn btn-info3 btn-sm mb-2" onClick="javascript:go_alert_channel();"><i class="fa fa-check-square-o"></i> 카페신고하기</button></p>
								<?}?>

                                <blockquote>
                                    <div class="page-write">
										<p class="post fw-500 mt-3"><?=$rowChannel['채널설명']?></p>
									</div>
                                </blockquote>
                            </div>
                        </div>

                        <!-- Post Tags & Share -->
                        <div class="post-tags-share d-flex justify-content-between align-items-center">
                            <!-- Tags -->
                            <ol class="popular-tags d-flex align-items-center flex-wrap">
                                <li><span>카페 태그 :</span></li>
                                <li class="fs-05"><a href="#"><?=채널태그($rowChannel['채널태그'])?></a></li>
                            </ol>
                            <!-- Share 
                            <div class="post-share">
                                <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            </div>-->
                        </div>


						<!-- ##### 모임 ##### -->
                        <div class="single-widget-area">
                            <!-- Author Widget -->
                            <div class="author-widget">
                                <!--클럽속 모임-->
								<article class="mb-2">
									<div class="list list-schedule">
										<ul>
											<!--일정을때-->
											<?
											//$query = "select * from gf_channel_member where fk_member = '{$rowMember['member_id']}'";
											$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
											$rowM = db_select($query);


											?>

											<? if($rowChannel['member_id'] == $rowMember['member_id'] || $rowM['운영진여부'] == "Y"){?>
											<!-- 모임개설 권한은 운영진, 클럽장만 가능 // 버튼 노출은 운영진, 클럽장에게만 노출-->
											<li>
												<div class="py-3 text-center">
												<p class="fs-005 color-6">현재 카페 모임이 없습니다.</p>
												<a href="cafe_meet.php?CID=<?=$rowChannel['CID']?>" title="모임개설" onClick="popct(this.href, '500', '700');return false"  class="btn btn-info2 btn-sm radius-5"><i class="fas fa-plus fs--1 opacity-50"></i> 모임개설</a>
												</div>
											</li>
											<!--//모임개설 버튼노출-->
											<?}?>					


											<!-- 일정 있을때 --><?
											$query = "
												
												select * from gf_moim where fk_channel = '{$rowChannel['pk_channel']}' and member_id = '{$rowMember['member_id']}' and 모임날짜 >= '".date("Y-m-d")."'

												UNION

												select * from gf_moim where fk_channel = '{$rowChannel['pk_channel']}' and 모임날짜 >= '".date("Y-m-d")."'
											";
											$result = db_query($query);

											$idx = 0;
											while($row = db_fetch($result)){

												$idx++;

												$모임일시 = $row['모임날짜']." ".$row['모임시간'].":00";

												if(date("Ymd")!=date("Ymd", strtotime($모임일시))){
													$날짜 = date("n/j", strtotime($모임일시));
												}else{
													$날짜 = "오늘";
												}	

												$시간차 = time() - strtotime($모임일시);

												if($시간차 < 60*60*24*3 && $row['pk_moim']>0){
													$new = "new";
												}else{
													$new = "";
												}

												if(date("A", strtotime($모임일시))=="AM"){$시간="오전 ".date("H:i", strtotime($모임일시));}
												if(date("A", strtotime($모임일시))=="PM"){$시간="오후 ".date("H:i", strtotime($모임일시));}

												$모임장 = get_member_row($row['운영진_member_id']);

												$참여인원수 = db_count("gf_moim_member", " fk_moim='{$row['pk_moim']}'", "*");

												$본인참여여부 = db_count("gf_moim_member", " fk_moim='{$row['pk_moim']}' and fk_member = '{$rowMember['member_id']}'", "*") > 0;

											?>

											<?
											$rowS['store_addr'] = $row['모임장소'];
											$rowS['store_name'] = $row['모임제목'];	
											$id = "daum_map_".$idx;
											?>
											<li>
												<div class="d-flex">
													<div class="col-3 lh-3 text-center">
														<!-- 모임날짜가 오늘일때는 날짜 대신 '오늘'로 표현-->
														<p class="color-6 fs--1 mb-0"><?=get_요일($모임일시)?></p>
														<strong class="fs-1 color-1"><?=$날짜?></strong>
														<p class="color-6 fs--1 mb-0"><?=$시간?></p>
														<!--//오늘일때-->
													</div>
													<div class="col-9 border-left">
														<dl>
															<dt class="fw-400 color-5 fs--1"><i class="fas fa-medal fs--1 color-purple"></i> <?=$row['닉네임']?> <span class="bar"></span><?=$row['모임제목']?> <span class="bar"></span>인원 <strong class="color-purple"><?=$참여인원수?></strong>/<?=$row['모임정원']?>명</dt>
															<dd class="color-1 fw-600 fs-0 ellipsis my-1"><?=$row['모임설명']?></dd>
															<dd class="color-6 fs--1"><i class="fas fa-map opacity-50"></i><?=$row['모임장소']?></dd>
															<dd class="color-6 fs--1"><i class="fas fa-map-marker-alt opacity-50"></i><?=$row['시도']?>/<?=$row['구군']?> <a href="javascript:show_map('<?=$id?>');" class="link-underline">&#91;지도보기
															&#93;</a>
															</dd>
															<dd class="color-6 fs--1"><i class="fas fa-wallet opacity-50"></i><?=$row['모임참가비용']?></dd>

															<div id="<?=$id?>" style="border:1px solid;width:99%;height:250px;margin:5px 0;">
															</div>
															<?
															include "_kakao_map_meet.php";
															?>

														</dl>
														<?
														$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
														$rowM = db_select($query);

														if($rowM['pk_channel_member'] || $rowChannel['member_id'] == $rowMember['member_id']){
														?>

														<? if($본인참여여부 == false){?>
														<button type="button" class="btn btn-info2 btn-sm btn-capsule mr-1 mb-1" onClick="join_moim('<?=$row['pk_moim']?>');"><i class="fas fa-users opacity-50 mr-1"></i> 모임참여</button>

														<?}else{?>
														<button type="button" class="btn btn-info2 btn-sm btn-capsule mr-1 mb-1" onClick="join_cancel_moim('<?=$row['pk_moim']?>');"><i class="fas fa-times opacity-60 mr-1"></i> 모임참여 취소</button>
														<?}?>

														<a href="cafe_participation.php?pk_moim=<?=$row['pk_moim']?>" onClick="popct(this.href, '500', '700');return false" class="btn btn-gray btn-sm btn-capsule mr-1 mb-1"><i class="fas fa-users opacity-60 mr-1"></i>참여자명단</a>
														<?}?>

														<? if($rowChannel['member_id'] == $rowMember['member_id'] || $rowM['운영진여부'] == "Y"){?>
														<!-- 모임개설 권한은 운영진, 클럽장만 가능 // 버튼 노출은 운영진, 클럽장에게만 노출-->
														<a href="javascript:go_delete_meeting(<?=$row["pk_moim"]?>);" title="모임취소" class="btn btn-info3 btn-sm radius-5 mr-1 mb-1"><i class="fas fa-times fs--1 opacity-60 mr-1"></i> 모임취소</a>
														<!--//모임개설 버튼노출-->
														<?}?>
													</div>
												</div>
											</li>

											<?}?>

											<!--//일정있을때-->
										</ul>
									</div>
								</article>
							<!--//클럽속 모임-->
                            </div>
                        </div>
						<!--// 모임끝 -->

                    </div>
                </div>


                <!-- Blog Sidebar Area -->
                <div class="col-12 col-sm-9 col-md-4">
                    <div class="post-sidebar-area">

						<article class="single-widget-area" style="border:1px solid #ebebeb; padding:20px;">
							<h3 class="main-tlt display-inline">카페멤버 <span class="color-primary"><?=$채널참여인원수?></span></h3>

							<!--클럽장에게만-->
							<? if($rowChannel['member_id'] == $rowMember['member_id']){?>							
							<a href="cafe_member.php?CID=<?=$CID?>" onClick="popct(this.href, '500', '700');return false" class="float-right color-6 fs-005">카페멤버관리 <span class="icon ic-right-arrow fs--1"></span> </a>							
							<?}?>
							<!--//클럽장에게만-->

							<?
							$query = "select count(*) as cnt from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}' and 강퇴여부 = 'N'";
							$rowMC = db_select($query);

							if($rowMC['cnt']==0 && ($rowMember['member_id'] != $rowChannel['member_id'])){
							?>
							<div class="m-3 text-center">
								<a href="javascript:go_channel_채널가입('<?=$rowChannel['pk_channel']?>');" class="btn btn-info2 fs-005 color-6"><i class="fa fa-star"></i> 카페가입하기</a>
							</div>
							<?}?>

							<div class="list list-default mt-3">
								<ul>
								<?= 채널회원리스트($rowChannel['member_id'], true, $rowChannel)?>

								<?
								$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and 강퇴여부 = 'N'";

								$resultCM = db_query($query);

								while($rowCM = db_fetch($resultCM)){
								?>

								<?= 채널회원리스트($rowCM['fk_member'], $rowCM['운영진여부'], $rowChannel)?>

								<?}?>

								</ul>
							</div>
						</article>
						<!--//멤버 리스트-->
                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Blog Content Area End ##### -->


<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_cafe.php"; ?>
</body>

<script>
	$('.nav_category li[data-name="gnb-channel"]').addClass('active');
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>
</html>