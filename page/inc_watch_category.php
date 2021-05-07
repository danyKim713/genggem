					<!-- category Widget -->
					<div class="col-12 col-sm-12 col-lg-12 text-center">
						<div class="single-footer-widget">
							<div class="social-info">
								<? 
									$query = "SELECT * FROM tbl_watch_category WHERE use_flg='AD005001' ORDER BY seq ";
									$resultCategory = db_query($query); 

									while ($row = mysqli_fetch_array($resultCategory)) {
										$strImg = "";
										// 이미지 
										if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/WatchCatImg/".$row['cat_img'])) { 
											$strImg = "<img src=\"/ImgData/WatchCatImg/{$row["cat_img"]}\" width=\"30\"  alt=\"{$row["cat_nm"]}\">";
										}
								?>
								<a href='watch_category.php?txtRecordNo=<?=$row["cat_id"]?>' title='<?=$row["cat_nm"]?>'>
									<?=$strImg?> <?=$row["cat_nm"]?>
								</a>
								<? } ?>
							</div>
						</div>
					</div>
					<!-- // category Widget -->