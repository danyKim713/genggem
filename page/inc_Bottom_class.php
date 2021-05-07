<?

    $query  = " SELECT COUNT(*) AS cnt  \n";
    $query .= " FROM   tbl_coach   \n";
    $query .= " WHERE  member_id='".$ck_login_member_pk."'   \n";    
    $query .= " AND    use_flg = 'AD005002'   \n";    // 코치(사용중지)

    $rowCoach = db_select($query);    

?>
<nav class="nav_bottom bottom_fixed">
	<ul class="main_category d-flex align-items-baseline">
		<div class="mr-1">
			<a href="javascript:history.back();" title="뒤로가기" class="link-back"><font size="5px"><span class="icon ic-left-arrow"></span></font></a>
		</div>
		<li data-name="classlist">
			<a href="class_contents.php" title="">
			<i class="fas fa-list"></i><p>클래스홈</p></a>
		</li>
		<li data-name="review">
			<a href="class_review.php" title="">
			<i class="fa fa-comment-alt"></i><p>후기보기</p></a>
		</li>
		<li data-name="myclass">
			<a href="class_my.php" title="">
			<i class="fas fa-desktop"></i><p>마이클래스</p></a>
		</li>
		<!-- 아티스트 사용여부 제한 -->
		<li data-name="artistapply">
<? if ($rowCoach["cnt"] > 0) { ?>
			<a href="javascript:alert('회원님은 아티스트 사용제한이 되어 있습니다. 관리자에게 문의 하세요.')" title="">
<? } else { ?>
			<a href="class_artist_apply.php" title="">
<? } ?>
			<i class="fas fa-user"></i><p>아티스트등록</p></a>
		</li>
		<!-- 아티스트 사용여부 제한 -->
		<li data-name="lessonset">
<? if ($rowCoach["cnt"] > 0) { ?>
			<a href="javascript:alert('회원님은 아티스트 사용제한이 되어 있습니다. 관리자에게 문의 하세요.')" title="">
<? } else { ?>
			<a href="class_set.php" title="">
<? } ?>
			<i class="fas fa-cog"></i><p>클래스관리</p></a>
		</li>
	</ul>
</nav>

<script src="/js/dev.js"></script>


