<?
include "include_save_header.php";

$query = "update gf_moim set 운영진_member_id = '{$member_id}' where pk_moim = '{$pk_moim}'";
db_query($query);

echo "SUCCESS";