                <div class="search_by_terms">
					<form name='frmSearch' id='frmSearch' method='get' action='store_search.php' class="form-inline">

                        <input type="hidden" name="lat" id="lat" value="37.5653203"/>
                        <input type="hidden" name="lng" id="lng" value="126.9745883"/>

						<input type="hidden" name="category" value="<?=$category?>">
						<select class="custom-select" name="selCat" id="selCat" style="width:130px;">
							<option <?=($selCat == "") ? "selected" : "";?> value="">업종선택</option>

							<?foreach($storeCateArray as $k => $v) {?>
							<option <?=($selCat == $k) ? "selected" : "";?> value="<?=$k?>"><?=$v?></option>
							<?}?>
						</select>
						<select class="custom-select" name="store_area1_id" id="store_area1_id"  style="width:150px;">
							<option <?=($store_area1_id == "") ? "selected" : "";?> value="">지역/도시</option>
							<?foreach($area1Array as $k => $v) {?>
							<option <?=($store_area1_id == $k) ? "selected" : "";?> value="<?=$k?>"><?=$v?></option>
							<?}?>
						</select>
						<!-- <select class="custom-select" id="store_area2_id">
							<option value="">세부지역</option>
							<?foreach($area2Array as $k => $v) {?>
							<option value="<?=$k?>"><?=$v?></option>
							<?}?>
						</select> -->
						<input class="form-control" id="txtSearchText" name="txtSearchText" type="text" placeholder="스토어검색" value="<?=$txtSearchText?>" style="width:150px" />
						<button class="btn btn-secondary ml-2" id="btnSearch" style="font-size:14px; height:38px;">검색</button>
					</form>							
				</div>