<?php
require_once "include_save_header.php";


$strRecordNo = $_POST["txtRecordNo"];


$query = "DELETE FROM gf_moim WHERE pk_moim = '{$strRecordNo}'";
$result = db_query($query);

if($result){
	echo "SUCCESS";
}else{
	echo "FAIL";
}