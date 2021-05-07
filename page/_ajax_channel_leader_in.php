<?
include "include_save_header.php";

$query = "update gf_channel_member set 운영진여부 = 'Y' where fk_channel = (select pk_channel from gf_channel where CID =  '{$_SESSION['S_CID']}') and fk_member = '{$member_id}'";

db_query($query);

echo "SUCCESS";