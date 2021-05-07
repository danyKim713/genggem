<? include "./inc_program.php"; ?>
<?
$query = "update tbl_member set app_id = '' where member_id = '{$rowMember['member_id']}' ";
db_query($query);
?>

<script src="/js/dev.js"></script>
<script>
	deleteAllCookies();
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 

<script>
	alert('<?=$dic[logged_out_successfully]?>');
	top.location.href = "index.php";
</script>