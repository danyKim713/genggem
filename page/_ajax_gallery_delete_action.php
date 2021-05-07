<?
include "include_save_header.php";

$query = "delete from gf_gallery where ";
$query .= "pk_gallery = '{$pk_gallery}'";

db_query($query);

echo "SUCCESS";