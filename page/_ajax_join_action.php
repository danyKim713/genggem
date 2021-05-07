<?php
$NO_LOGIN = "Y";
require_once "include_save_header.php";

extract($_POST);
/**
				if(data == "SUCCESS"){
				}else if(data == "MANDATORY_ERROR"){
				}else if(data == "DUP_EMAIL"){
				}else if(data == "DUP_HP"){
				}else if(data == "DUP_NICKNAME"){
				}else if(data == "WRONG_PASSWD2"){
				}else if(data == "NO_RECO_UID"){
				}else if(data == "NO_CERT_NO"){
				}
**/

if(!$이메일 || !$국가코드 || !$휴대폰번호 || !$이름 || !$닉네임 || !$비밀번호 || !$비밀번호확인){
	echo "MANDATORY_ERROR";
	exit;
}
if($_SESSION['_sms_cert_no'] != $인증번호){
//	echo "NO_CERT_NO";
//	exit;
}

$query = "select * from tbl_member where email = '{$이메일}'";
$rowM = db_select($query);
if($rowM['member_id']){
	echo "DUP_EMAIL";
	exit;
}
if($휴대폰번호 != "1065247280" && $휴대폰번호 != "1084808425" && $휴대폰번호 != "1083362521" && $휴대폰번호 != "1076452521"){
	$query = "select * from tbl_member where concat(country_id,hp)= '".$국가코드.$휴대폰번호."'";
	$rowM = db_select($query);
	if($rowM['member_id']){
		echo "DUP_HP";
		exit;
	}
}

$query = "select * from tbl_member where 닉네임 = '{$닉네임}'";
$rowM = db_select($query);
if($rowM['pk_member']){
	echo "DUP_NICKNAME";
	exit;
}

if($비밀번호 != $비밀번호확인){
	echo "WRONG_PASSWD2";
	exit;
}

$query = "select * from tbl_member where UID = '{$추천인UID}'";
$rowM = db_select($query);
if($추천인UID && !$rowM['member_id']){
	echo "NO_RECO_UID";
	exit;
}

function make_UID(){
	$UID_TMP = rand(11111111,99999999);
	$query = "select * from tbl_member where UID = '{$UID_TMP}'";
	$row = db_select($query);

	if($row['pk_member']>0){
		return make_UID();
	}
	return $UID_TMP;
}

$UID = make_UID();
$GEN지갑주소 = make_uniq_wallet("GN");
$GEP지갑주소 = make_uniq_wallet("GP");

$휴대폰번호 = str_replace("-","",$휴대폰번호);

if(substr($휴대폰번호,0,1)=="0"){
	$휴대폰번호 = substr($휴대폰번호,1);
}

$이메일 = trim($이메일);
$휴대폰번호 = trim($휴대폰번호);
$이름 = trim($이름);
$비밀번호 = trim($비밀번호);


if(!preg_match("/([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/",$이메일)){
   echo "ERROR_EMAIL";
   exit;
}

$query = "insert into tbl_member set ";
$query .= "email='{$이메일}',";
$query .= "country_id='{$국가코드}',";
$query .= "hp='{$휴대폰번호}',";
$query .= "name='{$이름}',";
$query .= "닉네임='{$닉네임}',";
$query .= "passwd=MD5('{$비밀번호}'),";
$query .= "시도='{$시도}',";
$query .= "구군='{$구군}',";
$query .= "birthday='{$생년월일}',";
$query .= "gender='{$성별}',";
$query .= "UID='{$UID}',";
$query .= "GEN지갑주소='{$GEN지갑주소}',";
$query .= "GEP지갑주소='{$GEP지갑주소}',";
$query .= "agency_UID='{$agency_UID}',";
$query .= "first_regdate=NOW(),";
$query .= "regdate=NOW(),";
$query .= "login_yn='Y',";
$query .= "visit_ip='{$_SERVER['REMOTE_ADDR']}'";

$result = db_query($query);

$member_id = mysqli_insert_id($conn);

push_act("Cafehands","0", $member_id, "회원님. 반갑습니다. 내페이지를 꾸며주세요.", "page_set.php");

if($result){
	echo "SUCCESS";
}else{
	echo "FAIL";
}