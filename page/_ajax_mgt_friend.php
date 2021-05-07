<?
include "include_save_header.php";

if($gubun == "submit_friend"){

	$query = "delete from gf_friends ";
	$query .= " where ";
	$query .= "(origin_member_id = '{$origin_member_id}' and ";
	$query .= "friend_member_id = '{$friend_member_id}') or ";
	$query .= "(friend_member_id = '{$origin_member_id}' and ";
	$query .= "origin_member_id = '{$friend_member_id}')";

	db_query($query);

	$query = "insert into gf_friends set ";
	$query .= "origin_member_id = '{$origin_member_id}',";
	$query .= "friend_member_id = '{$friend_member_id}',";
	$query .= "진행상태 = '친구신청중',";
	$query .= "등록일시 = NOW()";

	$rowM = get_member_row($origin_member_id);
	push_act("페이지",$origin_member_id, $friend_member_id, "내 페이지에 ".$rowM['name']."님이 친구 신청하였습니다.", "page_friends.php");


}else if($gubun == "delete_submit_friend"){
	$query = "update gf_friends set ";
	$query .= "진행상태 = '요청삭제' ";
	$query .= " where ";
	$query .= "(origin_member_id = '{$origin_member_id}' and ";
	$query .= "friend_member_id = '{$friend_member_id}') or ";
	$query .= "(friend_member_id = '{$origin_member_id}' and ";
	$query .= "origin_member_id = '{$friend_member_id}')";
}else if($gubun == "admit_submit_friend"){
	$query = "update gf_friends set ";
	$query .= "진행상태 = '친구수락' ";
	$query .= " where ";
	$query .= "(origin_member_id = '{$origin_member_id}' and ";
	$query .= "friend_member_id = '{$friend_member_id}') or ";
	$query .= "(friend_member_id = '{$origin_member_id}' and ";
	$query .= "origin_member_id = '{$friend_member_id}')";
}else if($gubun == "un_friend"){
	$query = "update gf_friends set ";
	$query .= "진행상태 = '친구삭제' ";
	$query .= " where ";
	$query .= "(origin_member_id = '{$origin_member_id}' and ";
	$query .= "friend_member_id = '{$friend_member_id}') or ";
	$query .= "(friend_member_id = '{$origin_member_id}' and ";
	$query .= "origin_member_id = '{$friend_member_id}')";
}else if($gubun == "cancel_friend"){
	$query = "update gf_friends set ";
	$query .= "진행상태 = '친구삭제' ";
	$query .= " where ";
	$query .= "(origin_member_id = '{$origin_member_id}' and ";
	$query .= "friend_member_id = '{$friend_member_id}') or ";
	$query .= "(friend_member_id = '{$origin_member_id}' and ";
	$query .= "origin_member_id = '{$friend_member_id}')";
}

db_query($query);

echo "SUCCESS";