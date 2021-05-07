<?php
@session_start();

if($_COOKIE['ck_login_member_pk']!=""){
	header("Location: ./main.php");
}else{
	header("Location: ./main.php");
}