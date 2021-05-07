<?php 
include "./inc_program.php";


$query = "select * from tbl_member where email in ('dgkim@freeneo.com','decomix@naver.com')";
$result = db_query($query);

while($row = db_fetch($result)){
	send_push_message($row['app_id'], "[Golfen알림]", "푸쉬테스트입니다.", "http://golfen.co.kr/page/main.php");
}