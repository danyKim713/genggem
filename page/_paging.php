<ul class="pagination justify-content-center">

<?
$lastPage = ($num/$pageScale) + ($num%$pageScale==0?0:1);

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

<script>
	function goto_page(pageNo){
		$("#pageNo").val(pageNo);
		$("#frm_page").submit();
	}
</script>