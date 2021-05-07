<?
$NO_LOGIN = "Y";
include "include_save_header.php";
?>
<nav aria-label="Page navigation" class="row mt-4 align-items-center justify-content-center">

<ul class="pagination justify-content-center mt-3">

<?
$pageScale = 5;

$lastPage = $num/$pageScale + ($num%$pageScale==0?0:1);

$stepScale = 5;
$stepStart = (intval(($pageNo-1)/$stepScale))*$stepScale+1;
$stepEnd = $stepStart + $stepScale;
if(($stepStart-$stepScale)>0){
?>

  <li class="page-item"><a class="page-link" href="javascript:goto_page('<?=$stepStart-$stepScale?>')"><i class="fas fa-chevron-left"></i></a></li>
<?} ?>

  <?
for ($i=$stepStart; ($i<=$lastPage && $i<$stepEnd); $i++){
	if($pageNo==$i){
?>
  <li class="page-item active"><a class="page-link" href="javascript:void(0)"><?=$i?></a></li>
<?}else{?>
  <li class="page-item"><a class="page-link" href="javascript:goto_page(<?=$i?>)"><?=$i?></a></li>
<?}?>
<?}?>
<?if($stepEnd<=$lastPage){?> 
  <li class="page-item"><a class="page-link" href="javascript:goto_page('<?=$stepEnd?>')"><i class="fas fa-chevron-right"></i></a></li>
<?}?>

</ul>

</nav>

<script>
	function goto_page(pageNo){
		$("#pageNo").val(pageNo);
		go_list();
	}
</script>