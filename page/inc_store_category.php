<!-- 제휴점 주제별 찾기 -->
					<?/*<div class="col-12 col-sm-12 col-lg-12 text-center">
						<div class="single-footer-widget">
							<div class="social-info">
								<?/*
									if ($strSearchCat == "") {
										//$strCatNM = "전체";
										$style = " style='background: #ececec;'";
									}

								?>
								<a href='./class_list.php?txtSearchCat=' title='전체' <?=$style?>>
									<img src="./assets/img/core-img/icon_total.png"> 전체
								</a>
								<? 
									$query = "SELECT * FROM tbl_store_cate WHERE use_yn='Y' ORDER BY seq ";
									$resultCategory = db_query($query); 

									while ($row = mysqli_fetch_array($resultCategory)) {
										$strImg = "";
										// 이미지 
										if (is_file($_SERVER[DOCUMENT_ROOT]."/ImgData/LessonCatImg/".$row['cat_img'])) { 
											$strImg = "<img src=\"/ImgData/LessonCatImg/{$row["cat_img"]}\" width=\"20\"  alt=\"{$row["store_cate_name"]}\">";
										}
								?>
								<a href='./class_list.php?txtSearchCat=<?=$row['cat_id']?>' title='<?=$row["store_cate_name"]?>'>
									<?=$strImg?> <?=$row["store_cate_name"]?>
								</a>
								<? } ?>
							</div>
						</div>
					</div>*/?>
					<!-- // category Widget -->

				<div class="col-12 col-sm-12 col-lg-12 text-center">
						<div class="single-footer-widget">
							<div class="social-info">
								<a href='store_search.php?selCat=26' title=''>
									<img src="assets/images/icon/pn01.png" width="25" alt="문화/아트"> 문화/아트
								</a>
								<a href='store_search.php?selCat=35' title=''>
									<img src="assets/images/icon/pn02.png" width="25" alt="공예/공방"> 공예/공방
								</a>
								<a href='store_search.php?selCat=25' title=''>
									<img src="assets/images/icon/pn03.png" width="25" alt="미술/음악"> 미술/음악
								</a>
								<a href='store_search.php?selCat=5' title=''>
									<img src="assets/images/icon/pn04.png" width="25" alt="패션/뷰티"> 패션/뷰티
								</a>
								<a href='store_search.php?selCat=30' title=''>
									<img src="assets/images/icon/pn05.png" width="25" alt="플라워"> 플라워
								</a>
								<a href='store_search.php?selCat=16' title=''>
									<img src="assets/images/icon/pn06.png" width="25" alt="사진/영상"> 사진/영상
								</a>
								<a href='store_search.php?selCat=42' title=''>
									<img src="assets/images/icon/pn08.png" width="25" alt="요리/음료"> 요리/음료
								</a>
								<a href='store_search.php?selCat=53' title=''>
									<img src="assets/images/icon/pn07.png" width="25" alt="패션/라이프"> 라이프
								</a>
							</div>
						</div>
					</div>
					<!-- // category Widget -->

