<!-- Search by Terms -->
<? 
	$query = "SELECT * FROM tbl_watch_category WHERE use_flg='AD005001' ORDER BY seq ";
	$resultCategory = db_query($query); 

?>

				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='watch_category.php' class="form-inline mb-2">
						<select name="selSearchCat" id="selSearchCat" class="custom-select">
							<option value="">영상분류</option>					
<?
	while ($rowCategory = mysqli_fetch_array($resultCategory)) {

?>

							<option <?=($strSearchCat == $rowCategory["cat_id"]) ? "selected" : ""; ?> value="<?=$rowCategory["cat_id"]?>" title='<?=$rowCategory["cat_nm"]?>'><?=$rowCategory["cat_nm"]?></a></option>
<?
	}
?>
							<?
							//for ($i=1; $i<=count($cat_nm); $i++){
							//$m = $i<10?"0".$i:$i;
							?>
<!--							<? /*<option value="watch_search.php?txtRecordNo=<?=$cat_nm[$i-1]?>" title='<?=$cat_nm[$i-1]?>'><?=$cat_nm[$i-1]?></a></option> */?>-->
							<?//}?>
						</select>
						<input class="form-control mr-2" id="txtSearchText" name="txtSearchText" type="text" placeholder="영상을 검색해 보세요." value="<?=$strSearchText?>" style="width:170px;" />
						<button class="btn btn-info3" id="btnSearch"><i class="fas fa-search"></i> 검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->	
<script>
	$(document).ready(function(){

		$('#selSearchCat').on("change",function(){
			$('#frmSearch').attr('action', 'watch_category.php');
			$('#txtSearchText').val('');
			$('#frmSearch').submit();
        });

		$('#btnSearch').on("click",function(){
			$('#frmSearch').attr('action', 'watch_search.php');
			$('#frmSearch').submit();
        });
	
	});
</script>