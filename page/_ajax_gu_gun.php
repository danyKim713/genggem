<?php
$NO_LOGIN = "Y";
require_once "include_save_header.php";

extract($_POST);
/**
			시도: 시도
**/
if($시도 == "세종특별자치시"){
	$query = "select distinct 지점3 from gf_weather_area where 지점3!='$시도' and 지점2='$시도' and 지점3!='' order by pk_weather_area";
}else{
	$query = "select distinct 지점2 from gf_weather_area where 지점2!='$시도' and 지점1='$시도' order by pk_weather_area";
}


$result2 = db_query($query);
?>
	<option value="">구/군을 선택해주세요.</option>
<?
while($row2 = db_fetch($result2)){
	if($시도 == "세종특별자치시"){
	?>
	<option value="<?=$row2['지점3']?>"><?=$row2['지점3']?></option>	
	<?
	}else{
	?>
	<option value="<?=$row2['지점2']?>"><?=$row2['지점2']?></option>	
	<?
	}

}