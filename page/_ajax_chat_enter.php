<?
$_GET['CID'] = $_SESSION['S_CID'];

include "include_save_header.php";


$query = "insert into gf_chatting_entrance set ";
$query .= "fk_channel = '{$rowChannel['pk_channel']}',";
$query .= "fk_member = '{$rowMember['member_id']}',";
$query .= "채팅참가일시 = NOW()";

db_query($query);