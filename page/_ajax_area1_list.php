<?
include "../_PROGRAM_inc/function.inc";

$query = "select * from tbl_store_area1 where country_code = '$country_code' and use_yn='Y' order by order_no";
$result = db_query($query);

$html = '<option value="">지역/도시</option>';
while($row = db_fetch($result)){
	$html .= '<option value="'.$row['store_area1_id'].'">'.$row['store_area1_name'].'</option>';
}
echo $html;