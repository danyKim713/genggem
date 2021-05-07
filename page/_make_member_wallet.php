<?php
$NO_LOGIN = "Y";
require_once "include_save_header.php";

$query = "select * from tbl_member";
$result = db_query($query);

while($row = db_fetch($result)){

	$GEN지갑주소 = make_uniq_wallet("GN");
	$GEP지갑주소 = make_uniq_wallet("GP");

	$query = "update tbl_member set ";
	$query .= "GEN지갑주소 = '{$GEN지갑주소}',";
	$query .= "GEP지갑주소 = '{$GEP지갑주소}' ";
	$query .= " where member_id = '{$row['member_id']}'";

	echo $query."<br/>";

	db_query($query);

}