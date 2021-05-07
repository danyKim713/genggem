<?
include "../_PROGRAM_inc/function.inc";

$query = "select * from tbl_store_cate  where country_code = '$country_code' and use_yn='Y' order by order_no";
$result = db_query($query);

$html = '<option value="">Business Category</option>';
while($row = db_fetch($result)){
	$html .= '<option value="'.$row['store_cate_id'].'">'.$row['store_cate_name'].'</option>';
}
echo $html;