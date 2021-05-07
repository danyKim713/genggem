<!DOCTYPE HTML>
<html lang="en">
<?
    $NO_LOGIN = "Y";
	include "./inc_program.php";
?>
<? include "./inc_Head.php"; ?>

<?
$strSearchCat = $_GET['selSearchCat'];
$strSearchArea = $_GET['selSearchArea'];
$strSearchText = trim($_GET['txtSearchText']);

$arrSearchWord = array(); 
$where = "";
if($strSearchCat){
	$where .= " and 채널카테고리 = '{$strSearchCat}'";
	$arrSearchWord[] = $strSearchCat; 
}
if($strSearchArea){
	$where .= " and 시도 = '{$strSearchArea}'";
	$arrSearchWord[] = $strSearchArea; 
}

if($strSearchText){
	$where .= " and (채널이름 like '%{$strSearchText}%' OR 채널설명 like '%{$strSearchText}%')";
	$arrSearchWord[] = $strSearchText; 
}


$strSearchWord = implode("' / '", $arrSearchWord);



?>

<script>
	$(function(){
		$("#키워드").keyup(function(e){
			go_list_search();
		});
	});

	function go_list_search(){
		var 키워드 = $("#키워드").val();

		$.ajax({
			type: 'POST',
			url: "_ajax_channel_search.php",
			data: {
				키워드: 키워드
			},
			async: false,
			success: function(data){
				$("#search-result").html(data);
			}
		});
	}
</script>

<body class="mb-5">
<? include "./inc_nav.php"; ?>
<!-- ##### Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg8.jpg);">
            <h2>CAFE <font size="5px">List</font></h2>
        </div>
    </div>
    <!-- ##### Area End ##### -->


	<!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area mt-30">
        <div class="container">
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2>cafe</h2>
					<p><?=(trim($strSearchWord) == "") ? "" : "'{$strSearchWord}'에 대한 검색결과입니다." ?></p>
				</div>

				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='cafe_view.php' class="form-inline mb-2">

						<select name="selSearchCat" class="custom-select" onchange="javascript:frmSearch.submit();">
							<option value="">카페분류</option>
							<?
								for ($i=1; $i<=count($채널카테고리배열); $i++){
								$m = $i<10?"0".$i:$i;
							?>
							<option <?=(trim($strSearchCat) == $채널카테고리배열[$i-1]) ? "selected" : "";?> value="<?=$채널카테고리배열[$i-1]?>" title='<?=$채널카테고리배열[$i-1]?>'><?=$채널카테고리배열[$i-1]?></a></option>
							<?}?>
						</select>
						<select name="selSearchArea" class="custom-select" onchange="javascript:frmSearch.submit();">
							<option value="">지역별</option>
							<?
								for ($i=1; $i<=count($시도배열); $i++){
								$m = $i<10?"0".$i:$i;
							?>
							<option <?=(trim($strSearchArea) == $시도배열[$i-1]) ? "selected" : "";?> value="<?=$시도배열[$i-1]?>" title='<?=$시도배열[$i-1]?>'><?=$시도배열[$i-1]?></a></option>
							<?}?>
						</select>
						<input class="form-control mr-2" id="txtSearchText" name="txtSearchText" type="text" placeholder="카페를 검색해 보세요." style="width:180px" value="<?=$strSearchText?>"/>
						<button class="btn btn-info"><i class="fas fa-comments color-warning"></i> 카페검색</button>

					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>
        </div>
    </section>
    <!-- ##### Blog Area End ##### -->




	<section class="alazea-blog-area">
        <div class="container">
            <div class="row mb-3">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2>Hot Cafe</h2>
                        <p>- 요즘 많은 관심을 받는 인기 카페!! -</p>
                    </div>
                </div>
            </div>

            <!-- 인기 클럽 5개 노출 : 회원수+게시글수+접속수 상위 10개중 5개 랜덤노출-->
			<div class="row justify-content-center">
<?
		$query = "select C.*, (select count(*) as cnt from gf_channel_member M where M.fk_channel = C.pk_channel) as MemberCnt from gf_channel C where C.사용여부 = 'Y' {$where} order by MemberCnt DESC LIMIT 0,4";
		$result = db_query($query);
		$cntHot = mysqli_num_rows($result); 

		if($cntHot > 0) {
			while ($row = mysqli_fetch_array($result)) {
?>	
                <!-- Single CAFE Post Area -->
                <div class="col-12 col-md-6 col-lg-3">
				<?= 채널리스트($row['pk_channel']);?>
				</div>
<?
			}
		} else {
?>
				<div class="py-5 text-center fs-005 color-6">해당 클럽이 없습니다.</div>
<?
		}
?>
            </div>
        </div>
    </section>


	<section class="alazea-blog-area section-padding-70-0">
        <div class="container">						
<?

		$query = "select C.* from gf_channel C where C.사용여부 = 'Y'  {$where}  ";

		$result = db_query($query);
		$cntCat = mysqli_num_rows($result); 
		if($cntCat > 0) {
?>
			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<!-- Shop Page Count -->
				<div class="section-heading">
					<h2><?=$strSearchCat?> 카페</h2>
                        <p>- cafe list -</p>
				</div>

				<!-- Search by Terms --
				<div class="search_by_terms">
					<a href="/page/cafe_view.php?selSearchCat=<?=$strSearchCat?>"><button class="btn btn-info btn-capsule btn-sm"><i class="fas fa-comments"></i> <?=$strSearchCat?>카페 전체보기</button></a>					
				</div>
				<!-- Search by Terms -->				
			</div>
			<div class="row mb-3">
          				
<?
			while ($row = mysqli_fetch_array($result)) {

?>
					<!-- Single CAFE Post Area -->
					
					<div class="col-12 col-md-6 col-lg-3">
					<?= 채널리스트($row['pk_channel']);?>
					</div>
<?
			}
		}
?>

				
			</div>

		</div>
    </section>



	<? include "./inc_Bottom.php"; ?>
	<? include "./inc_Bottom_cafe.php"; ?>
</body>
<script>
	$('.nav_bottom li[data-name="home"]').addClass('active');
</script>

</html>