<?
    $NO_LOGIN = "Y";
	include "./inc_program.php"; 
    $strBCat  = $_GET["txtBCat"];        
    $strSearchCat  = $_GET["txtSearchCat"];        
	$strSearchArea = $_GET["selSearchArea"];
	$strSearchText = $_GET["txtSearchText"];
    $strSearchPop  = $_GET["txtSearchPop"];        	
    $strSearchRecomm  = $_GET["txtSearchRecomm"];        	
    $nPageNo     = $_GET["txtPageNo"];        	

	$nListCntPerPage = 12;  // 페이지당 목록수


?>
<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_Head.php"; ?>
<link rel="stylesheet" href="assets/css/sub.css">


<body class="mb-5">

<? include "./inc_nav.php"; ?>
<script>
	var nPageNo = 1;


	$(document).ready(function(){
		$(window).scroll(function(){
			var maxHeight = $(document).height();
			var currentHeight = $(window).scrollTop() + $(window).height();

			if(maxHeight <= currentHeight + 220){
				getMoreClass();
			}
		});

		getMoreClass();

        // 찜하기
        $(document).on('click', '.btnZZim', function(event) {
			idx = $('.btnZZim').index(this)
            $.ajax({
                url: './class_detail_action.php',
                type: 'post',
                data: {
                    txtRecordNo: $(this).data("val"),
                },
                datatype: 'text',
                success: function(Data) {
                    Data = $.trim(Data);
                    arrData = Data.split("@");

                    if (arrData[0] == "SUCCESSI") {
                        $('.lblZZimCnt').eq(idx).html(arrData[1]);
						$(".btnZZim").eq(idx).addClass( 'btn-warning' );
                    } else if (arrData[0] == "SUCCESSD") {
                        $('.lblZZimCnt').eq(idx).html(arrData[1]);
						$(".btnZZim").eq(idx).removeClass( 'btn-warning' );
                    } else {
						alert(arrData[1]);
					}

                } 

            });
        });


	});
	

	function getMoreClass() {
			$.ajax({
				url: './class_List_add.php',
				type: 'post',
				data: {
					txtPageNo: nPageNo,
					txtPageListCnt: <?=$nListCntPerPage?>,
					txtBCat: $('#frmSearch [name=txtBCat]').val(),
					txtSearchCat: $('#frmSearch [name=txtSearchCat]').val(),
					selSearchArea: $('#frmSearch [name=selSearchArea]').val(),
					txtSearchText: $('#frmSearch [name=txtSearchText]').val(),
					txtSearchPop: $('#frmSearch [name=txtSearchPop]').val(),
					txtSearchRecomm: $('#frmSearch [name=txtSearchRecomm]').val(),
				},
				async:false,
				datatype: 'text',
				success: function(Data) {
					Data = $.trim(Data);

					$('#divClass').append(Data);

					if (Data != "")	{
						nPageNo++;
					}

				},
				error: function(res) {
					alert('데이터를 불러오지 못했습니다.');
				}  						
			});

	}
</script>
<!-- ##### img Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(./assets/img/bg-img/sub_bg12.jpg);">
            <h2>cafehands open class<br>
			<font size="4px" color="">누구나 함께하는 열린 강좌!</font></h2>
        </div>
    </div>
    <!-- img Area End -->

	<? include "./inc_class.php"; ?>

	<!-- ##### category Area Start ##### -->
    <section class="new-arrivals-products-area">
        <div class="container">
			<div class="category-area2 mt-3">
				<!-- category Area -->
				<div class="row">

					<!-- category Widget -->
					<div class="col-12 col-sm-6 col-lg-12 text-center">
						<div class="single-footer-widget">
							<div class="social-info">
<?
							if ($strSearchCat == "") {
								//$strCatNM = "전체";
								$style = " style='background: #ffdcdc;'";
							}

?>
								<a href='./class_list.php?txtBCat=<?=$strBCat?>&txtSearchCat=' title='전체' <?=$style?>>
									<img src="./assets/img/core-img/icon_total.png" width="25"> 전체
								</a>

<? 
							$arrSearchWord = array();
  						    $query = "SELECT * FROM tbl_lesson_category WHERE parent_cat_id={$strBCat} AND depth=2 AND use_flg='AD005001' ORDER BY seq ";

							//$query = "SELECT * FROM tbl_lesson_category WHERE use_flg='AD005001' ORDER BY seq ";
							$resultCategory = db_query($query); 

							while ($row = mysqli_fetch_array($resultCategory)) {
								$style = "";
								if ($strSearchCat == $row["cat_id"]) {
									//$strCatNM = $row["cat_nm"];
									$style = " style='background: #ffdcdc;'";
									$arrSearchWord[] = $row["cat_nm"];
								}

								$strImg = "";
								// 이미지 
								if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/LessonCatImg/".$row['cat_img'])) { 
									$strImg = "<img src=\"/ImgData/LessonCatImg/{$row["cat_img"]}\" width=\"25\"  alt=\"{$row["cat_nm"]}\">";
								}
?>


								<a href='./class_list.php?txtBCat=<?=$strBCat?>&txtSearchCat=<?=$row['cat_id']?>' title='<?=$row["cat_nm"]?>' <?=$style?>>
									<?=$strImg?> <?=$row["cat_nm"]?>
								</a>
<? 
							} 

    if (trim($strSearchPop) == "Y") {	    
  	    $arrSearchWord[] = "인기";
	}
    if (trim($strSearchRecomm) == "Y") {	    
		$arrSearchWord[] = "추천";
	}
    if (trim($strSearchArea) != "") { 
		$arrSearchWord[] = "{$strSearchArea}";
	}
	if (trim($strSearchText) != "") { 
		$arrSearchWord[] = "{$strSearchText}";
	}
	$strSearchWord = "'" . implode("' / '", $arrSearchWord) . "' 클래스 리스트입니다.";
		
?>
							</div>
						</div>
					</div>
				</div>
			</div>


			<div class="shop-sorting-data d-flex flex-wrap align-items-center justify-content-between">
				<div class="section-heading">
					<h2>Class List</h2>
					<p><?=$strSearchWord?></p>
					<!-- <a href="class_list.php"><button class="btn btn-outline-info btn-sm radius-2 ml-auto mt-1"> <i class="fas fa-map-marker-alt"></i> 내주변 클래스 보기</button></a> -->
				</div>
				<!-- Search by Terms -->
				<div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='class_list.php' class="form-inline">
						<input type="hidden" name="txtBCat" value="<?=$strBCat?>">
						<input type="hidden" name="txtSearchCat" value="<?=$strSearchCat?>">
		                <input type="hidden" name="txtPageNo" id="txtPageNo" value="<?=$nPageNo?>">
		                <input type="hidden" name="txtPageListCnt" id="txtPageListCnt" value="<?=$nListCntPerPage?>">
		                <input type="hidden" name="txtSearchPop" id="txtSearchPop" value="<?=$strSearchPop?>">
		                <input type="hidden" name="txtSearchRecomm" id="txtSearchRecomm" value="<?=$strSearchRecomm?>">

						<select class="custom-select" id="selSearchArea" name="selSearchArea" style="width:100px" onchange="javascript:frmSearch.submit()">
							<option value="">지역별</option>
							<?
								$query = "select distinct 지점1 from gf_weather_area where 지점1=지점2 order by 지점코드 ";
								$resultA = db_query($query);

								while($rowA = db_fetch($resultA)){
							?>
							<option <?=(trim($strSearchArea) == trim($rowA['지점1'])) ? "selected":"";?> value="<?=$rowA['지점1']?>"><?=$rowA['지점1']?></option>
							<?
								}
							?>
						</select>
						<input class="form-control" id="txtSearchText" name="txtSearchText" type="text" placeholder="레슨 검색" value="<?=$strSearchText?>" style="width:110px" />
						<button class="btn btn-danger ml-2" id="btnSearch" style="font-size:14px; height:38px; border-radius:5px;">검색</button>
					</form>							
				</div>
				<!-- Search by Terms -->				
			</div>

			<div class="row" id="divClass">


            </div>

<!--			<div class="text-center mt-2 mb-50"><button class="btn btn-outline-info btn-sm radius-2 ml-auto mt-1" id="btnMore"> 더보기 </div>  -->
		</div>

		
	</section>

	
	

<? include "./inc_Bottom.php"; ?>
<? include "./inc_Bottom_class.php"; ?>
</body>

<script>
	$('.nav_bottom li[data-name="classlist"]').addClass('active');
</script>

</html>