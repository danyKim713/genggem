					<!-- category Widget -->
					<div class="col-12 col-sm-12 col-lg-12 text-center">
						<div class="single-footer-widget">
							<div class="social-info">
								<?
									if ($strSearchCat == "") {
										//$strCatNM = "전체";
										$style = " style='background: #ffdcdc;'";
									}

								?>
								<a href='./class_list.php?txtBCat=<?=$strBCat?>&txtSearchCat=' title='전체' <?=$style?>>
									<img src="./assets/images/icon/class_total.png" width="25"> 전체
								</a>
								<? 
									$query = "SELECT * FROM tbl_lesson_category WHERE parent_cat_id={$strBCat} AND depth=2 AND use_flg='AD005001' ORDER BY seq ";


									$resultCategory = db_query($query); 

									while ($row = mysqli_fetch_array($resultCategory)) {
										$strImg = "";
										// 이미지 
										if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/LessonCatImg/".$row['cat_img'])) { 
											$strImg = "<img src=\"/ImgData/LessonCatImg/{$row["cat_img"]}\" width=\"25\"  alt=\"{$row["cat_nm"]}\">";
										}
								?>
								<a href='./class_list.php?txtBCat=<?=$strBCat?>&txtSearchCat=<?=$row['cat_id']?>' title='<?=$row["cat_nm"]?>'>
									<?=$strImg?> <?=$row["cat_nm"]?>
								</a>
								<? } ?>
							</div>
						</div>
					</div>
					<!-- // category Widget -->