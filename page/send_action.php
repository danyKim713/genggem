<?
 include  "include_save_header.php"; ?>
<?

/*error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE); 

*/
  		$UID = trim($_POST['UID']);
		$security_passwd = trim($_POST['security_passwd']);
		$amount = trim($_POST['amount']);
		$member_id = MyPassDecrypt($_COOKIE['ck_login_member_id']);
		$email = $_COOKIE['ck_login_user_email'];

//echo "member_id".$member_id ."<br>";
//		$reurl = ($_POST['reurl']);

		if(!trim($UID) || !trim($security_passwd) || !trim($amount)){
			msg_only("필수 입력사항이 누락되었습니다.");
		}

		$cnt = db_count("tbl_member","UID = '".$UID."'","UID");
		if($cnt == 0) { // 상대편  UID 없는 경우
			msg_only("받을 사람 계정이 존재하지 않는 계정입니다. UID를 확인해보십시오.");
		}

		$mem_cash = MemCash($member_id); 
		//echo "mem_cash".$mem_cash ;
		if ( $mem_cash < $amount ) {
				msg_only("보내실 금액이 부족합니다.");
		}

			$memList = db_select("select * from tbl_member where member_id = '".$member_id."'");
			$passwd = strlen($memList['security_passwd'])<128 ? md5($security_passwd) : SHA_CONFIG($security_passwd,$email);

				//암호체크		
			  if( in_array($REMOTE_ADDR,  $dev_ips) && $security_passwd == '123456') {
					$pcnt = db_count("tbl_member","member_id = '{$member_id}'","member_id");
					
				} else {
					$pcnt = db_count("tbl_member","member_id = '".$member_id."' and security_passwd = '".$passwd."'","security_passwd");
				//	echo "member_id = '".$member_id."' and security_passwd = '".$passwd."'";
				}

		       if($pcnt > 0){  //암호 맞는경우

						$receiver_mem_id= infoMemUID($UID,"member_id");

						if($receiver_mem_id == $member_id){
							msg_top_page("본인에게 전송할 수 없습니다.","index.html");
						}

						if($amount < 0){
							msg_top_page("0보다 작은 값을 보낼 수는 없습니다.","index.html");
						}
		
						$basic = basicInfo();
						 $receive_cash_amount = ($amount * $basic['cash_trans_rate'] /100);	
						 $receive_credit_amount = ($amount * $basic['credit_trans_rate'] /100);	
					
						//전송 테이블에 입력 ////////////////////////////////////////////////
						$query = "insert into tbl_transmit set ";
					
						$rand_id ="T". rand(1111111111,9999999999);
						$uid_duple_cnt =  db_count("tbl_transmit", "transmit_code  ='$rand_id'  ", "transmit_code");
						if ($uid_duple_cnt > 0  ) {
								$rand_id ="T". rand(1111111111,9999999999);
								$uid_duple_cnt =  db_count("tbl_transmit", "transmit_code  ='$rand_id'  ", "transmit_code");
								if ($uid_duple_cnt > 0  ) {
									$rand_id ="T". rand(1111111111,9999999999);
									$uid_duple_cnt =  db_count("tbl_transmit", "transmit_code  ='$rand_id'  ", "transmit_code");
								}
						 }
					
						$query .= "transmit_code=trim('$rand_id'),";
						$query .= "transmit_method=trim('CASH'),";
						
						$query .= "state=trim('정상전송'),";
					
						$query .= "sender_id=trim('$member_id'),";
						$query .= "receiver_id=trim('$receiver_mem_id'),";
						$query .= "amount=trim('$amount'),";
						$query .= "transmit_date=now() ";
		
						echo "<br>".$query.$where. "</br>";
						$result = db_query( $query. $where);

						$transmit_id =  mysqli_insert_id($conn);


						//페이백의 경우에도, 전송 테이블에 입력 ////////////////////////////////////////////////

						$trans_payback_rate = db_result("select trans_payback_rate from tbl_site_config");
						
						$payback_amount =  floor($trans_payback_rate * $amount * (1/100));

						$query = "insert into tbl_transmit set ";
					
						$rand_id ="T". rand(1111111111,9999999999);
						$uid_duple_cnt =  db_count("tbl_transmit", "transmit_code  ='$rand_id'  ", "transmit_code");
						if ($uid_duple_cnt > 0  ) {
								$rand_id ="T". rand(1111111111,9999999999);
								$uid_duple_cnt =  db_count("tbl_transmit", "transmit_code  ='$rand_id'  ", "transmit_code");
								if ($uid_duple_cnt > 0  ) {
									$rand_id ="T". rand(1111111111,9999999999);
									$uid_duple_cnt =  db_count("tbl_transmit", "transmit_code  ='$rand_id'  ", "transmit_code");
								}
						 }
					
						$query .= "transmit_code=trim('$rand_id'),";
						$query .= "transmit_method=trim('TRANS_PAYBACK'),";
						
						$query .= "state=trim('정상전송'),";
					
						$query .= "sender_id='$member_id',"; //ADMIN이 적립해주는 거니까...
						$query .= "receiver_id=trim('$member_id'),";
						$query .= "amount=trim('$payback_amount'),";
						$query .= "transmit_date=now() ,";
						$query .= "ip='".$_SERVER['REMOTE_ADDR']."'";
		
						echo "<br>".$query.$where. "</br>";
						$result_payback = db_query( $query. $where);						
						$transmit_id_payback =  mysqli_insert_id($conn);
					
						if ( $transmit_id >0) { // 전송테이블 입력 성공시
									//보낸사람 cash 테이블에 입력////////////////////////////////////////
									$query = "insert into tbl_cash set ";
			
									$query .= "transmit_id=trim('$transmit_id'),";
									$query .= "member_id=trim('$member_id'),";
									
									$query .= "amount=trim('".-$amount."'),";
									$query .= "type=trim('Send'),";
									$query .= "title=trim('회원간 전송'),";
									$query .= "regdate=now(), ";
									$query .= "ip='".$_SERVER['REMOTE_ADDR']."'";
									echo "<br>".$query.$where. "</br>";
									$result = db_query( $query. $where);
			
									//받는사람 cash 테이블에 입력////////////////////////////////////////
									$query = "insert into tbl_cash set ";
									$query .= "transmit_id=trim('".$transmit_id."'),";
									$query .= "member_id=trim('".$receiver_mem_id."'),";
									
									$query .= "amount=trim('".$receive_cash_amount."'),";
									$query .= "type=trim('Receive'),";
									$query .= "divide_rate=trim('".$basic['cash_trans_rate']."'),";
									$query .= "title=trim('회원간 전송'),";
									$query .= "regdate=now(),";
									$query .= "ip='".$_SERVER['REMOTE_ADDR']."'";
									echo "<br>".$query.$where. "</br>";
									$result = db_query( $query. $where);						
			
			
									//받는사람 creidit 테이블에 입력////////////////////////////////////////
									$query = "insert into tbl_credit set ";
									$query .= "transmit_id=trim('".$transmit_id."'),";
									$query .= "member_id=trim('".$receiver_mem_id."'),";
									
									$query .= "amount=trim('".$receive_credit_amount."'),";
									$query .= "type=trim('Receive'),";
									$query .= "divide_rate=trim('".$basic['credit_trans_rate']."'),";
									$query .= "title=trim('회원간 전송'),";
									$query .= "regdate=now(),";
									$query .= "ip='".$_SERVER['REMOTE_ADDR']."'";
									echo "<br>".$query.$where. "</br>";
									$result = db_query( $query. $where);						


									//보낸사람 credit 테이블에 페이백 금액을 입력(적립) /////////////////
									$query = "insert into tbl_credit set ";
									$query .= "transmit_id = '$transmit_id_payback',";
									$query .= "divide_rate = '$trans_payback_rate',";
									$query .= "trans_credit_id = '',";
									$query .= "credit_trans_multiple = '',";
									$query .= "	member_id = '$member_id',";
									$query .= "	admin_id = '',";
									$query .= "type = 'TransPayback',";
									$query .= "title = '전송페이백부여',";
									$query .= "amount = '$payback_amount',";
									$query .= "regdate = NOW(),";
									$query .= "ip='".$_SERVER['REMOTE_ADDR']."'";
 									echo "<br>".$query.$where. "</br>";
									$result = db_query( $query. $where);		
				
									msg_top_page("성공적으로 전송되었습니다","index.html");

						} else { //전송 실패시 
								$query = "update tbl_transmit set state='전송실패' ";
								msg_only("전송실패하였습니다");

						}
															
				   
				} else {  // 암호 틀린경우
					msg_only("안전거래 비밀번호가 틀립니다.");
				}