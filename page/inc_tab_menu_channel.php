					<div>
						<ul>
							<li class="wow fadeInDown <?=$nowMenu == "카페홈"?"active":""?>">
								<a href="cafe.php?CID=<?=$_GET['CID']?>" title="정보">
									<div><i class="fa fa-spinner" aria-hidden="true"></i></div>
									<p class="txt_tit">카페정보</p>
								</a>
							</li>

							<li class="wow fadeInUp <?=$nowMenu == "게시판"?"active":""?>">
								<a href="cafe_view2.php?CID=<?=$_GET['CID']?>" title="게시판">
									<div><i class="fa fa-edit" aria-hidden="true"></i></div>
									<p class="txt_tit">게시판</p>
								</a>
							</li>

							<li class="wow fadeInDown <?=$nowMenu == "갤러리"?"active":""?>">
								<a href="cafe_view3.php?CID=<?=$_GET['CID']?>" title="갤러리">
									<div><i class="fa fa-camera" aria-hidden="true"></i></div>
									<p class="txt_tit">갤러리</p>
								</a>
							</li>

							<li class="wow fadeInUp  <?=$nowMenu == "채팅"?"active":""?>">
								<a href="cafe_view4.php?CID=<?=$_GET['CID']?>" onClick="popct(this.href, '500', '700');return false" title="채팅">
									<div><i class="fa fa-comments" aria-hidden="true"></i></div>
									<p class="txt_tit">채팅</p>
								</a>
							</li>

							<?/*!-- <div class="wow fadeInDown <?=$nowMenu == "메뉴"?"active":""?>">
								<div class="">
									<p class="btn btn-transparent txt_tit" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="padding-top:15px;"><i class="fas fa-comment" aria-hidden="true"></i> 메뉴</p>
									<div class="dropdown-menu">
										<a class="dropdown-item" href="javascript:copyToAddress('#channel-address');" title="클럽URL공유">클럽URL 공유</a>

										<?
										$query = "select count(*) as cnt from gf_channel_interested where fk_member = '{$rowMember['member_id']}' and fk_channel = '{$rowChannel['pk_channel']}'";
										$rowI = db_select($query);
										if($rowI['cnt'] == 0){
										?>
									
										<!--  관심클럽으로 등록하기전-->
										<a class="dropdown-item" href="javascript:go_interested_channel();" title="관심클럽추가">관심클럽추가</a>
										<!-- //끝 -->

										<?}else{?>
										<!-- 관심클럽으로 등록한 클럽일때 -->
										<a class="dropdown-item" href="javascript:go_un_interested_channel();" title="관심클럽해제">관심클럽해제</a>
										<!-- //끝-->
										<?}?>

										<?
										$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}' and 강퇴여부 = 'N'";
										$rowM = db_select($query);

										if(!$rowM['pk_channel_member']  && $rowMember['member_id'] != $rowChannel['member_id']){?>

										<a class="dropdown-item" href="javascript:go_channel_채널가입('<?=$rowChannel['pk_channel']?>');"  title="클럽가입하기">클럽 가입하기</a>
										<?}else if($rowMember['member_id'] != $rowChannel['member_id']){?>
										<a class="dropdown-item" href="javascript:go_channel_채널탈퇴('<?=$rowChannel['pk_channel']?>');" title="클럽탈퇴하기">클럽 탈퇴하기</a>
										<?}?>
										
										<? if($rowChannel['member_id'] != $rowMember['member_id']){?>
										<a class="dropdown-item" href="javascript:go_alert_channel();" title="클럽신고하기">클럽 신고하기</a>
<?}?>
									</div>
								</div>
							</div> */?>
						</ul>
					</div>