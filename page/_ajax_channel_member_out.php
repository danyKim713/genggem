<?
include "include_save_header.php";

$query = "update gf_channel_member set 강퇴여부 = 'Y' where fk_channel = (select pk_channel from gf_channel where CID =  '{$_SESSION['S_CID']}') and fk_member = '{$member_id}'";

db_query($query);

$query = "delete from gf_moim_member where fk_moim = (select pk_moim from gf_moim where fk_channel = (select pk_channel where CID = '{$_SESSION['S_CID']}')) and fk_member = '{$member_id}'";

$query = "select * from gf_channel where CID = '{$_SESSION['S_CID']}'";
$rowCh = db_select($query);

push_act("카페",$rowMember['member_id'], $member_id, $rowCh['채널이름']."에서 강퇴처리되었습니다.", "page_me.php");

echo "SUCCESS";