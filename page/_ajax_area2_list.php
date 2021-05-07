<?
include "../_PROGRAM_inc/function.inc";

$query = "select * from tbl_store_area2 where use_yn='Y' and store_area1_id = '$store_area1_id' and country_code  = '$country_code'";
//echo $query;
$result = db_query($query);

$html = '<option value="">시/군/구</option>';
while($row = db_fetch($result)){
	$html .= '<option value="'.$row['store_area2_id'].'">'.$row['store_area2_name'].'</option>';
}
echo $html;