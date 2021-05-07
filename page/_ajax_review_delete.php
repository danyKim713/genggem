<?
include "include_save_header.php";

$query = "delete from tbl_store_review where review_id = '{$review_id}'";
db_query($query);

echo "SUCCESS";