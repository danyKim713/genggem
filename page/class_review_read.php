<?
include "./inc_program.php";

$strRecordNo = $_GET["txtRecordNo"];

// 리뷰
$query  = " SELECT A.lr_id, A.l_id, A.star_score, A.review, A.isrt_user, DATE_FORMAT(A.isrt_dt, '%Y.%m.%d %H:%i') AS isrt_dt,    \n";
$query .= "        B.l_title, B.cat_id, D.cat_nm, E.lesson_title, F.name, F.페이지배경사진, F.페이지프로필사진, G.co_id     \n";
$query .= " FROM   tbl_lesson_review A, tbl_lesson B, tbl_lesson_category D, tbl_lesson_setup E, tbl_member F, tbl_coach G   \n";
$query .= " WHERE  A.lr_id     = {$strRecordNo}  \n";
$query .= " AND    A.l_id      = B.l_id   \n";  
$query .= " AND    B.cat_id    = D.cat_id   \n";
$query .= " AND    B.member_id = E.member_id   \n";  
$query .= " AND    A.isrt_user = F.member_id   \n";  
$query .= " AND    B.member_id = G.member_id   \n";  
$rowReview = db_select($query);   

echo $query;
// 리뷰이미지
$query  = " SELECT lri_id, lr_id, l_id, img, isrt_user, isrt_dt    \n";
$query .= " FROM    tbl_lesson_review_img    \n";
$query .= " WHERE  lr_id = {$rowReview["lr_id"]}   \n";  
$query .= " ORDER BY lri_id    \n";  

$resultReviewImg = db_query($query);  


// 리뷰글 좋아요 수량 가져오기
$query  = " SELECT COUNT(lra_id) AS cnt   \n";
$query .= " FROM   tbl_lesson_review_appraisal  \n";
$query .= " WHERE  lr_id='{$strRecordNo}'   \n"; 
$rowAppraisal = db_select($query); 

// 리뷰글 좋아요 가져오기(로긴한 유저의 좋아요 선택여부)
$query  = " SELECT COUNT(lra_id) AS cnt   \n";
$query .= " FROM   tbl_lesson_review_appraisal  \n";
$query .= " WHERE  lr_id='{$strRecordNo}'   \n"; 
$query .= " AND    member_id = {$rowMember["member_id"]}   \n";
$rowMyAppraisal = db_select($query); 

$strCheck = "";
if ($rowMyAppraisal["cnt"] > 0) {
    $strCheck = "checked";
}


// 리뷰댓글 가져오기
$query  = " SELECT A.lrc_id, A.lr_id, A.depth, A.comment, A.ref_1, A.ref_2, A.good_cnt, A.isrt_user, A.isrt_dt, B.UID, B.페이지배경사진, B.페이지프로필사진, B.닉네임,  \n";
$query .= "        TIMESTAMPDIFF(SECOND, A.isrt_dt, NOW()) AS diffSecond,   \n";
$query .= "        TIMESTAMPDIFF(MINUTE, A.isrt_dt, NOW()) AS diffMinute,   \n";
$query .= "        TIMESTAMPDIFF(HOUR, A.isrt_dt, NOW()) AS diffHour,   \n";
$query .= "        TIMESTAMPDIFF(DAY, A.isrt_dt, NOW()) AS diffDay,   \n";
$query .= "        TIMESTAMPDIFF(WEEK, A.isrt_dt, NOW()) AS diffWeek,   \n";
$query .= "        TIMESTAMPDIFF(MONTH, A.isrt_dt, NOW()) AS diffMonth,   \n";
$query .= "        TIMESTAMPDIFF(YEAR, A.isrt_dt, NOW()) AS diffYear   \n";
$query .= " FROM   tbl_lesson_review_comment A, tbl_member B  \n";
$query .= " WHERE  A.lr_id='{$strRecordNo}'   \n"; 
$query .= " AND    A.depth = 1  \n";   // 댓글인 경우만
$query .= " AND    A.isrt_user = B.member_id  \n"; 
$query .= " ORDER BY A.lrc_id DESC  \n";  

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
    <h2 class="header-title text-center">레슨후기 글읽기</h2>
</header>
<section class="wrap-page py-0">
    <div class="container-fluid header-top-sub">
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-10 col-lg-6 col-xl-4 p-0">
                <!--게시글-->
                <article class="p-3 mb-2 position-r">
<?
    // 리뷰작성자와 로긴한 유저가 같으면 수정 삭제 가능
    if ($rowReview["isrt_user"] == $rowMember["member_id"]) {
?>
                    <div class="dropdown position-ab btn-right-top">
                        <button class="btn btn-transparent color-6 p-3 dropdown-toggle fs-0"  type="button"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-h"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="class_review_modify.php?txtRecordNo=<?=$strRecordNo?>" title="글 수정">글 수정</a>
                            <a class="dropdown-item" href="javascript:void(0)" title="글 수정" id="btnRemove">글 삭제</a>
                        </div>
                    </div>
<?
    }
?>
                    <!-- 작성자 정보-->
                    <div class="d-flex align-items-end mb-3">
                        <div class="page-profile">
                            <img src="<?=phpThumb("/_UPLOAD/".($rowReview['페이지배경사진']?$rowReview['페이지배경사진']:$rowReview['페이지프로필사진']),0,0,0,"assets/images/user_img.jpg")?>" width="40" height="40" class="rounded-circle">
                        </div>
                        <div class="col page-write lh-3">
                            <h3 class="fs-005 mb-0"><?=$rowReview['name']?></h3>
                            <span class="date fs--1"><?=$rowReview['isrt_dt']?></span>
                        </div>
                    </div>
                    <!-- //작성자 정보-->
                    <!-- 레슨/코치 정보 -->
                    <div class="list-tour tour-wide mt-2 mb-3">
                        <ul>
                            <li>
                                <div class="con-info">
                                    <h4 class="tlt mt-1 ml-1"><?=$rowReview["lesson_title"]?></span> <button class="btn-right btn btn-outline-secondary btn-sm ml-1" type="button" onClick="location.href='class_view.php?txtRecordNo=<?=$rowReview["co_id"]?>'"><i class="fas fa-image"></i> 레슨보기</button></h4>
                                    <dl class="txt-info d-flex ml-2">
                                        <span><i class="fas fa-edit opacity-50"></i> <?=$rowReview["l_title"]?><br>
                                        <i class="fas fa-medal opacity-50"></i> <?=$rowReview["cat_nm"]?></span>
                                    </dl>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--// 레슨/코치 정보 끝-->

                     <!--작성글 및 태그-->
                    <div class="page-write">
                        <p class="post"><?=str_replace("\n", "<br>", $rowReview["review"])?></p>
                    </div>
                    <!--//작성글 및 태그-->
                    <!--사진-->
                    <div class="list-card my-3">
                        <ul class="card-columns">
<?
        $kk = 1; 
        while ($rowReviewImg = mysqli_fetch_array($resultReviewImg)) {
?>
                            <li class="card border-none">
                                <img class="card-img img-fluid" src="/ImgData/LessonReview/<?=$rowReviewImg["img"]?>" alt="" />
                            </li>
<?
            $kk++;
        }
            
        for ($pp=$kk; $pp<=3; $pp++) {
?>

                            <li class="card border-none">
                            </li>
<?
        }
?>
                        </ul>
                    </div>
                    <!--//사진-->
                    <!--버튼-->
                    <div class="page-box text-center">
                        <div class="row m-0">
                            <div class="col p-0 ">
                                <div class="checkbox">
                                    <input id="chkGood" name="chkGood" type="checkbox" <?=$strCheck?> class="invisible" value="<?=$strRecordNo?>">
                                    <label id="lblGood" for="chkGood"" class="color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span class="color-primary"><?=number_format($rowAppraisal["cnt"])?></span></label>
                                </div>
                            </div>
                            <div class="col p-0">
                                <a href="javascript:void(0)"><i class="far fa-comment-dots fs-005 pr-1"></i>댓글 <span class="color-primary"><?=number_format($nCommentCnt)?></span></a>
                            </div>
                            <!-- <div class="col p-0">
                            <a href="javascript:void(0)"><i class="fas fa-external-link-alt fs-005 pr-1"></i>공유하기</a>
                            </div> -->
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

        // 리뷰댓글 좋아요 수량 가져오기
        $query  = " SELECT COUNT(lrca_id) AS cnt    \n"; 
        $query .= " FROM   tbl_lesson_review_comment_appraisal  \n";
        $query .= " WHERE  lrc_id = '{$rowComment['lrc_id']}'   \n"; 

        $rowCommentAppraisal = db_select($query); 

        // 리뷰댓글 : 현재 회원의 좋아요 선택여부 가져오기
        $query  = " SELECT COUNT(lrca_id) AS cnt    \n"; 
        $query .= " FROM   tbl_lesson_review_comment_appraisal  \n";
        $query .= " WHERE  lrc_id = '{$rowComment['lrc_id']}'   \n"; 
        $query .= " AND    member_id = '{$rowMember['member_id']}'   \n"; 

        $rowCommentMyAppraisal = db_select($query); 

    
//        $strCommentClass = "";
        $strCommentCheck = "";
        if ($rowCommentMyAppraisal["cnt"] > 0) {
//            $strCommentClass = "color-primary";
            $strCommentCheck = "checked";
        }
?>
                            <li>
                                <div class="d-flex align-items-start position-r">
                                    <div class="page-profile">
                                        <img src="assets/images/user_img.jpg" width="40" height="40" class="rounded-circle">
                                    </div>
                                    <div class="page-write col lh-3 pr-0">
                                        <h5 class="fs-005 mb-0"><?=$rowComment['닉네임']?></h5>
                                        <p class="post fs-005 fw-300 mb-2"><?=$rowComment['comment']?>
                                        </p>
                                        <div class="d-flex lh-2">
                                            <div class="checkbox check-primary">
                                                <input type="hidden" name="txtCommentID" class="txtCommentID" value="<?=$rowComment['lrc_id']?>">
												<input id="chkCommentGood<?=$i?>" name="chkCommentGood" type="checkbox" <?=$strCommentCheck?> class="invisible chkCommentGood">
                                                <label for="chkCommentGood<?=$i++?>" class="lblCommentGood color-5 mb-0 fw-400"><i class="far fa-thumbs-up fs-005 pr-1 color-5"></i>좋아요 <span><?=number_format($rowCommentAppraisal["cnt"])?></span></label>
                                            </div>
                                        </div>
                                        <div class="con-reply">
                                            <div class="d-flex mt-3">
                                                <textarea class="form-control" placeholder="답글 내용을 입력해주세요" rows="2"></textarea>
                                                <button type="button" class="btn btn-outline-secondary col-3 px-3">확인</button>
                                            </div>
                                        </div>
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
                <!--//댓글-->
                <!--댓글입력창-->
                <div class="con-comment-input col-sm-10 col-lg-6 col-xl-4 p-0">
                    <div class="d-flex">
                        <textarea class="form-control" id="txtComment" placeholder="댓글 내용을 입력해주세요" rows="2"></textarea>
                        <button type="button" id="btnCommentReg" class="btn btn-primary col-3 px-3">확인</button>
                    </div>
                </div>
                <!--//댓글입력창-->
            </div>
        </div>
    </div>
<textarea id="aa"></textarea>
</section>
</body>
<script>
	$(document).ready(function(){
		$('.btn-reply').on("click",function(){
			$(this).parent('div').next().toggleClass("active");
			console.log('text');
		});

        // 리뷰 좋아요 클릭시
        $(document).on('click', '#chkGood', function(event) {
            var nCnt = parseInt($('#lblGood > span').text());
            $.ajax({
                url: './class_review_action.php',
                type: 'post',
                data: {
                    txtAction: "REVIEWGOOD",
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


        // 댓글 좋아요 클릭시
        $(document).on('click', '.chkCommentGood', function(event) {
            var idx = $('.chkCommentGood').index(this);
            var nCnt = parseInt($('.lblCommentGood > span').eq(idx).text());

            $.ajax({
                url: './class_review_read_action.php',
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


        // 댓글 확인 클릭시
        $(document).on('click', '#btnCommentReg', function(event) {
            if ($.trim($('#txtComment').val()) == "") {
                alert("댓글을 입력하세요.");
                $('#txtComment').focus()
                return;
            }

            $.ajax({
                url: './class_review_read_action.php',
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
                        $('#txtComment').val('')
                        $('.ULC').prepend(arrData[1]);  // 해당 댓글을 처음에 삽입
                    } else {
                        alert(arrData[0]);
                    }

                } 
            });
        });

        // 리뷰 삭제 클릭시
        $(document).on('click', '#btnRemove', function(event) {
			if (confirm("현재 리뷰를 삭제하시겠습니까? \n (삭제하시면 댓글들도 삭제됩니다.)")) {

				$.ajax({
					url: './class_review_action.php',
					type: 'post',
					data: {
						txtAction: "REVIEWDEL",
						txtRecordNo: <?=$strRecordNo?>,
					},
					datatype: 'text',
					success: function(Data) {
						Data = $.trim(Data);
						if (Data == "SUCCESS") {
							alert("리뷰가 삭제되었습니다.");
							$(location).attr('href', 'class_review.php');
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