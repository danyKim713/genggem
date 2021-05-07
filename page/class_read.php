<? 
    include "./inc_program.php"; 

    $strRecordNo = $_GET["txtRecordNo"];
    
    // 문의글 가져오기
    $query  = " SELECT A.lq_id, A.coach_id, A.member_id, A.member_uid, A.q_memo, A.q_img, A.isrt_dt,  B.페이지배경사진, B.페이지프로필사진, B.닉네임, C.co_id   \n";
    $query .= " FROM   tbl_lesson_question A, tbl_member B, tbl_coach C  \n";
    $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
    $query .= " AND    A.member_id = B.member_id   \n";
    $query .= " AND    A.member_id = C.member_id   \n";

    $rowQuestion = db_select($query); 

    // 문의글 좋아요 수량 가져오기
    $query  = " SELECT COUNT(lqa_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_question_appraisal  \n";
    $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
    $query .= " AND    coach_id = {$rowQuestion["coach_id"]}   \n";
    $rowAppraisal = db_select($query); 

    // 문의글 좋아요 가져오기(로긴한 유저의 좋아요 선택여부)
    $query  = " SELECT COUNT(lqa_id) AS cnt   \n";
    $query .= " FROM   tbl_lesson_question_appraisal  \n";
    $query .= " WHERE  lq_id='{$strRecordNo}'   \n"; 
    $query .= " AND    member_id = {$rowMember["member_id"]}   \n";
    $query .= " AND    coach_id = {$rowQuestion["coach_id"]}   \n";
    $rowMyAppraisal = db_select($query); 

//    $strClass = "";
    $strCheck = "";
    if ($rowMyAppraisal["cnt"] > 0) {
//        $strClass = "color-primary";
        $strCheck = "checked";
    }

    // 문의댓글 가져오기
    $query  = " SELECT A.lqc_id, A.lq_id, A.depth, A.comment, A.ref_1, A.ref_2, A.good_cnt, A.coach_id, A.isrt_user, A.isrt_dt, B.UID, B.페이지배경사진, B.페이지프로필사진, B.닉네임,  \n";
    $query .= "        TIMESTAMPDIFF(SECOND, A.isrt_dt, NOW()) AS diffSecond,   \n";
    $query .= "        TIMESTAMPDIFF(MINUTE, A.isrt_dt, NOW()) AS diffMinute,   \n";
    $query .= "        TIMESTAMPDIFF(HOUR, A.isrt_dt, NOW()) AS diffHour,   \n";
    $query .= "        TIMESTAMPDIFF(DAY, A.isrt_dt, NOW()) AS diffDay,   \n";
    $query .= "        TIMESTAMPDIFF(WEEK, A.isrt_dt, NOW()) AS diffWeek,   \n";
    $query .= "        TIMESTAMPDIFF(MONTH, A.isrt_dt, NOW()) AS diffMonth,   \n";
    $query .= "        TIMESTAMPDIFF(YEAR, A.isrt_dt, NOW()) AS diffYear   \n";
    $query .= " FROM   tbl_lesson_question_comment A, tbl_member B  \n";
    $query .= " WHERE  A.lq_id='{$strRecordNo}'   \n"; 
    $query .= " AND    A.depth = 1  \n";   // 댓글인 경우만
    $query .= " AND    A.isrt_user = B.member_id  \n"; 
    $query .= " ORDER BY A.lqc_id DESC  \n";  

    $resultComment = db_query($query); 
    $nCommentCnt = mysqli_num_rows($resultComment); 
?>
<!DOCTYPE HTML>
<html lang="en">

<? include "./inc_Head.php"; ?>
<body>

<!-- 내 페이지 모든 글과 친구들의 모든 게시글들을 보여 줍니다. 무한 스클롤 -->
<header class="header top_fixed">
	<a href="javascript:history.back();" title="뒤로가기" class="link-back"><span class="icon ic-left-arrow"></span></a>
	<h2 class="header-title text-center">레슨 문의</h2>
</header>
	<section class="wrap-page py-0">
		<div class="container-fluid header-top-sub">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-10 col-lg-6 col-xl-4 p-0">
					<!--게시글-->
					<article class="p-3 mb-2 position-r">
						<div class="dropdown position-ab btn-right-top">
							<button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
							<div class="dropdown-menu">
								<a class="dropdown-item" href="javascript:void(0)" id="btnModify" title="글 수정">글 수정</a>
								<a class="dropdown-item" href="javascript:void(0)" id="btnRemove" title="글 수정">글 삭제</a>
							</div>
						</div>
						<!-- 작성자 정보-->
						<div class="d-flex align-items-end mb-3">
							<div class="page-profile">
								<img src="<?=phpThumb("/_UPLOAD/".($rowQuestion['페이지배경사진']?$rowQuestion['페이지배경사진']:$rowQuestion['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
							</div>
							<div class="col page-write lh-3">
								<h3 class="fs-005 mb-0"><?=$rowQuestion["닉네임"]?></h3>
								<span class="date fs--1"><?=str_replace("-", ".", $rowQuestion["isrt_dt"])?></span>
							</div>
						</div>
						<!-- //작성자 정보-->
						<!--작성글 및 태그-->
						<div class="page-write">
							<p class="post"><?=$rowQuestion["q_memo"]?></p>
							<div class="fs-005 mt-1 color-6">
							</div>
						</div>
						<!--//작성글 및 태그-->
						<!--버튼-->
						<div class="page-box text-center">
							<div class="row m-0">
								<div class="col p-0 ">
									<div class="checkbox">
										<input id="chkGood" name="chkGood" type="checkbox" <?=$strCheck?> class="invisible" value="<?=$strRecordNo?>">
										<label id="lblGood" for="chkGood" class="color-5 mb-0  fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary"><?=number_format($rowAppraisal["cnt"])?></span></label>
									</div>
								</div>
								<div class="col p-0">
									<a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=number_format($nCommentCnt)?></span></a>
								</div>
							</div>
						</div>
						<!--//버튼-->
					</article>
					<!--//게시글-->

					<!--댓글-->
					<article class="p-3 mb-1">
						<h2 class="main-tlt display-inline">댓글 <span class="color-primary"><?=number_format($nCommentCnt)?></span></h2>
						<div class="list-comment mt-3">
							<ul class="ULC">
<? 
    $i = 0;
    while ($rowComment = mysqli_fetch_array($resultComment)) {

        $strDiff = "";
        $strDiff = $rowComment["diffYear"]."년전";
        if ($rowComment["diffYear"] < 1) {
            $strDiff = $rowComment["diffMonth"]."달전";
            if ($rowComment["diffMonth"] < 1) {
                $strDiff = $rowComment["diffWeek"]."주전";
                if ($rowComment["diffWeek"] < 1) {
                    $strDiff = $rowComment["diffDay"]."일전";
                    if ($rowComment["diffDay"] < 1) {
                        $strDiff = $rowComment["diffHour"]."시간전";
                        if ($rowComment["diffHour"] < 1) {
                            $strDiff = $rowComment["diffMinute"]."분전";
                            if ($rowComment["diffMinute"] < 1) {
                                $strDiff = $rowComment["diffSecond"]."초전";
                            }
                        }

                    }
                }
            }
        }

        // 문의댓글 좋아요 수량 가져오기
        $query  = " SELECT COUNT(lqca_id) AS cnt    \n"; 
        $query .= " FROM   tbl_lesson_question_comment_appraisal  \n";
        $query .= " WHERE  lqc_id = '{$rowComment['lqc_id']}'   \n"; 

        $rowCommentAppraisal = db_select($query); 

        // 문의댓글 : 현재 회원의 좋아요 선택여부 가져오기
        $query  = " SELECT COUNT(lqca_id) AS cnt    \n"; 
        $query .= " FROM   tbl_lesson_question_comment_appraisal  \n";
        $query .= " WHERE  lqc_id = '{$rowComment['lqc_id']}'   \n"; 

        $rowCommentMyAppraisal = db_select($query); 

    
//        $strCommentClass = "";
        $strCommentCheck = "";
        if ($rowCommentMyAppraisal["cnt"] > 0) {
//            $strCommentClass = "color-primary";
            $strCommentCheck = "checked";
        }

        // 문의답글 가져오기
        $query  = " SELECT A.lqc_id, A.lq_id, A.depth, A.comment, A.ref_1, A.ref_2, A.good_cnt, A.coach_id, A.isrt_user, A.isrt_dt, B.페이지배경사진, B.페이지프로필사진, B.닉네임, \n";
        $query .= "        TIMESTAMPDIFF(SECOND, A.isrt_dt, NOW()) AS diffSecond,   \n";
        $query .= "        TIMESTAMPDIFF(MINUTE, A.isrt_dt, NOW()) AS diffMinute,   \n";
        $query .= "        TIMESTAMPDIFF(HOUR, A.isrt_dt, NOW()) AS diffHour,   \n";
        $query .= "        TIMESTAMPDIFF(DAY, A.isrt_dt, NOW()) AS diffDay,   \n";
        $query .= "        TIMESTAMPDIFF(WEEK, A.isrt_dt, NOW()) AS diffWeek,   \n";
        $query .= "        TIMESTAMPDIFF(MONTH, A.isrt_dt, NOW()) AS diffMonth,   \n";
        $query .= "        TIMESTAMPDIFF(YEAR, A.isrt_dt, NOW()) AS diffYear   \n";
        $query .= " FROM   tbl_lesson_question_comment A, tbl_member B  \n";
        $query .= " WHERE  A.lq_id = '{$strRecordNo}'   \n"; 
        $query .= " AND    A.ref_1 = '{$rowComment["lqc_id"]}'   \n"; 
        $query .= " AND    A.depth = 2  \n";       // 덧글인 경우만
        $query .= " AND    A.isrt_user = B.member_id  \n";       
        $query .= " ORDER BY A.lqc_id DESC  \n";   

        $resultReply = db_query($query); 
?>
								<li>
									<div class="d-flex align-items-start position-r">
										<div class="page-profile">
											<img src="<?=phpThumb("/_UPLOAD/".($rowComment['페이지배경사진']?$rowComment['페이지배경사진']:$rowComment['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
										</div>
										<div class="page-write col lh-3 pr-0">

											<h5 class="fs-005 mb-0"><?=$rowComment['닉네임']?></h5>
											<p class="post fs-005 fw-300 mb-2"><?=$rowComment['comment']?>
											</p>
											<div class="d-flex lh-2">
												<div class="checkbox check-primary">
													<input id="chkCommentGood<?=$i?>" name="chkCommentGood" type="checkbox" <?=$strCommentCheck?> class="invisible chkCommentGood">
													<label for="chkCommentGood<?=$i++?>" class="lblCommentGood color-5 mb-0  fw-400"><i class="far  fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary"><?=number_format($rowCommentAppraisal["cnt"])?></span></label>
												</div>
												<span class="px-1">·</span>
												<button type="button" class="btn-reply btn btn-transparent color-primary p-0">답글달기</button>
											</div>
											<!--답글입력창-->
											<div class="con-reply">
												<div class="d-flex mt-3">
                                                    <input type="hidden" name="txtCommentID" class="txtCommentID" value="<?=$rowComment['lqc_id']?>">
													<textarea class="form-control txtReply" name="txtReply" placeholder="답글 내용을 입력해주세요" rows="2"></textarea>
													<button type="button" class="btn btn-outline-secondary col-3 px-3 btnReply">확인</button>
												</div>
											</div>
											<!--//답글입력창-->
										
											<!--답글-->
											<div class="list-reply">
												<ul class="ULREPLY">
<?
        while ($rowReply = mysqli_fetch_array($resultReply)) {

?>
													<li>
														<div class="d-flex align-items-start position-r">
															<div class="page-profile">
																<img src="<?=phpThumb("/_UPLOAD/".($rowReply['페이지배경사진']?$rowReply['페이지배경사진']:$rowReply['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="30" height="30" class="rounded-circle">
															</div>
															<div class="col lh-3 pr-0">
																<h5 class="fs-005 mb-1"><?=$rowReply['닉네임']?></h5>
																<p class="fs-005 fw-300"><?=$rowReply['comment']?></p>
															</div>
														</div>
													</li>
<?
        }
?>
												</ul>
											</div>


											<!--//답글-->
										</div>
										<p class="date position-ab mb-0 fs--1"><?=$strDiff?></p>
									</div>
								</li>
<?
    }
?>
							</ul>
						</div>
					</article>
					<div class="con-comment-input col-sm-10 col-lg-6 col-xl-4 p-0">
						<div class="d-flex">
							<textarea id="txtComment" name="txtComment" class="form-control" placeholder="댓글 내용을 입력해주세요" rows="2"></textarea>
							<button type="button" id="btnCommentReg" class="btn btn-primary col-3 px-3">확인</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>
<script>
	$(document).ready(function(){
//		$('.btn-reply').on("click",function(){
        $(document).on('click', '.btn-reply', function(event) {
			$(this).parent('div').next().toggleClass("active");
			console.log('text');
		});

        // 문의 좋아요 클릭시
        $(document).on('click', '#chkGood', function(event) {
            var nCnt = parseInt($('#lblGood > span').text());
            $.ajax({
                url: './class_read_action.php',
                type: 'post',
                data: {
                    txtAction: "QUESTIONGOOD",
                    txtRecordNo: "<?=$strRecordNo?>",
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    if (Data == "SUCCESSD") {
                        $('#chkGood').attr("checked", false);
                        $('#lblGood > span').text(nCnt - 1);
                    } else if (Data == "SUCCESSI") {
                        $('#chkGood').attr("checked", true);
                        $('#lblGood > span').text(nCnt + 1);
                    } 
                } 
            });
        });

        // 댓글 확인 클릭시
        $(document).on('click', '#btnCommentReg', function(event) {
            if ($.trim($('#txtComment').val()) == "") {
                alert("댓글을 입력하세요.");
                $('#txtComment').focus()
                return;
            }

            $.ajax({
                url: './class_read_action.php',
                type: 'post',
                data: {
                    txtAction: "COMMENTREG",
                    txtRecordNo: "<?=$strRecordNo?>",
                    txtComment: $('#txtComment').val(),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    arrData = Data.split("@");

                    if (arrData[0] == "SUCCESS") {
                        $('.ULC').prepend(arrData[1]);  // 해당 댓글을 처음에 삽입

                    } else {
                        alert(arrData[0]);
                    }

                } 
            });
        });

        // 댓글 확인 클릭시
        $(document).on('click', '.btnReply', function(event) {
            var idx = $('.btnReply').index(this);
            
            if ($.trim($('.txtReply').eq(idx).val()) == "") {
                alert("댓글을 입력하세요.");
                $('.txtReply').eq(idx).focus()
                return;
            }

            $.ajax({
                url: './class_read_action.php',
                type: 'post',
                data: {
                    txtAction: "REPLYREG",
                    txtRecordNo: "<?=$strRecordNo?>",
                    txtCommentID: $('.txtCommentID').eq(idx).val(),
                    txtReply: $('.txtReply').eq(idx).val(),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    arrData = Data.split("@");

                    if (arrData[0] == "SUCCESS") {
                        $('.ULREPLY').eq(idx).prepend(arrData[1]);  // 해당 댓글을 처음에 삽입
                        $('.txtReply').eq(idx).val('');
                        $('.con-reply').eq(idx).toggleClass("active");
                    } else {
                        alert(arrData[0]);
                    }

                } 
            });
        });


        // 댓글 좋아요 클릭시
        $(document).on('click', '.chkCommentGood', function(event) {
            var idx = $('.chkCommentGood').index(this);
            var nCnt = parseInt($('.lblCommentGood > span').eq(idx).text());

            $.ajax({
                url: './class_read_action.php',
                type: 'post',
                data: {
                    txtAction: "COMMENTGOOD",
                    txtRecordNo: "<?=$strRecordNo?>",
                    txtCommentID: $('.txtCommentID').eq(idx).val(),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    if (Data == "SUCCESSD") {
                        $('.chkCommentGood').eq(idx).attr("checked", false);
                        $('.lblCommentGood > span').eq(idx).text(nCnt - 1);
                    } else if (Data == "SUCCESSI") {
                        $('.chkCommentGood').eq(idx).attr("checked", true);
                        $('.lblCommentGood > span').eq(idx).text(nCnt + 1);
                    } 
                } 
            });
        });


        // 문의글 삭제 클릭시
        $(document).on('click', '.btnDelete', function(event) {
            var idx = $('.btnDelete').index(this);

			if (confirm("문의글을 삭제하시겠습니까?")) {

				$.ajax({
					url: './class_read_action.php',
					type: 'post',
					data: {
						txtAction: "QUESTIONDEL",
						txtRecordNo: <?=$strRecordNo?>,
					},
					datatype: 'text',
					success: function(Data) {
						Data = $.trim(Data);
						if (Data == "SUCCESS") {
							alert("문의글이 삭제되었습니다.");
							$(location).attr('href', 'class_view.php?txtRecordNo=<?=$rowQuestion["co_id"]?>');
						} else {
							alert(Data);
						}
					} 
				});

			}
        });
	});
</script>
</html>

