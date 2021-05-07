<?php
$NO_LOGIN = "Y";
require_once "include_save_header.php";

extract($_POST);

$query = "select *, (6371*acos(cos(radians({$lat}))*cos(radians(위도))*cos(radians(경도) -radians({$lng}))+sin(radians({$lat}))*sin(radians(위도)))) AS distance from tbl_jiboo where 사용유무 = 'Y' order by distance ASC";
$result = db_query($query);

for ($i=0; $i<db_num_rows($result); $i++){
	$row = db_fetch($result);

	?>
	<option value="<?=$row['pk_jiboo']?>">[<?=$row['권역명']?>] <?=$row['지부명']?></option>	
	<?
}