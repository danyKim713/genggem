<?
include "include_save_header.php";

$query = "insert into gf_follower set ";
$query .= "parent_member_id = '{$member_id}',";
$query .= "child_member_id = '{$rowMember['member_id']}',";
$query .= "등록일시 = NOW()";

db_query($query);

push_act("페이지",$rowMember['member_id'], $member_id, $rowMember['name']."님이 나를 팔로잉하였습니다.", "page_friends.php");

echo "SUCCESS";