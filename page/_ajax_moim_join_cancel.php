<?
include "include_save_header.php";

$query = "delete from gf_moim_member where fk_moim = '$pk_moim' and fk_member = '{$rowMember['member_id']}'";

db_query($query);

echo "SUCCESS";