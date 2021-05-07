<!DOCTYPE HTML>
<html lang="en">
<? include "./inc_program.php"; ?>
<? include "./inc_Head.php"; ?>

<link rel="stylesheet" href="assets/css/sub.css?20191215">

<?
//채널 멤버가 아니면 튕기게 해야 함....
$query = "select * from gf_channel_member where fk_channel = '{$rowChannel['pk_channel']}' and fk_member = '{$rowMember['member_id']}'";
$rowM = db_select($query);

if($rowM['강퇴여부']=="Y"){
	msg_page('이미 강퇴당한 클럽입니다.');
}

if(!$rowM['pk_channel_member'] && $rowMember['member_id'] != $rowChannel['member_id']){
	msg_page('클럽에 가입해야 이용가능한 서비스입니다.');
}


$_SESSION['S_CID'] = $_GET['CID'];

$query = "insert into gf_chatting_entrance set ";
$query .= "fk_channel = '{$rowChannel['pk_channel']}',";
$query .= "fk_member = '{$rowMember['member_id']}',";
$query .= "채팅참가일시 = NOW()";

db_query($query);
?>
<style type="text/css">

#chatting-list { 
	overflow:auto; 
}

#talk-history {
    height: 100%;
    background: #f7f7f7;
    margin: 0 0 0 0;
    overflow:scroll;
    position:relative; /* NEEDED! */
}

</style>
<script>


	
	var 스크롤이동방향 = "down";


	$(function () {
		var lastScrollTop = 0;

		element = document.getElementById("chatting-list");


		window.addEventListener("scroll", function(){ // or window.addEventListener("scroll"....
		   var st = window.pageYOffset || document.documentElement.scrollTop; // Credits: "https://github.com/qeremy/so/blob/master/so.dom.js#L426"
		   if (st > lastScrollTop){
			   // downscroll code
			   //console.log("down!");
			   스크롤이동방향 = "down";
		   } else {
			  // upscroll code
			   //console.log("up...!");
			   스크롤이동방향 = "up";
		   }

		  //console.log(st);

		  lastScrollTop = st <= 0 ? 0 : st; 
		}, false);

	});


	var lastScrollTop;


	$(function(){

		/**
		$(window).scroll(function(e){
			var scrollHeight = $(window).scrollTop() + $(window).height();
//			var documentHeight = $(document).height();

			if(scrollHeight <= 50){
			//	go_list_chatting_list();
			}
		});
		**/
		

		go_list_chatting_list();
		//go_reg_채팅내용('입장');
		

		$("#채팅내용").keypress(function() {
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == '13') {
				go_reg_채팅내용();
			}
		});
		//go_scroll();
	});

	function go_list_chatting_list(){
		$.ajax({
			type: 'POST',
			url: "_ajax_chatting_list.php",
			data: {
			},
			async: false,
			success: function(data){
				//console.log(data);
				$("#chatting-list").append(data);
				go_scroll('fast');
			}
		});
	}	

	function go_scroll(speed){
		if(speed == undefined){
			speed = "slow";
		}
		if(스크롤이동방향 != "up"){
			$('body,html,#chatting-list').animate({scrollTop: element.clientHeight}, speed);
		}
	}

	
	function go_reg_채팅내용(val){

		var 채팅내용;

		if(val == "퇴장"){
			//채팅내용 = "[<?=$rowMember['name']?>]님이 퇴장하셨습니다.";
			//mySocket.send(채팅내용);
		}else if(val == "입장"){
			채팅내용 = "[<?=$rowMember['name']?>]님이 입장하셨습니다.";
			//mySocket.send(채팅내용);
		}else{
			채팅내용 = $.trim($("#채팅내용").val());
		}


		$.ajax({
			type: 'POST',
			url: "_ajax_chatting_write.php",
			data: {
				채팅내용: 채팅내용
			},
			async: false,
			success: function(data){
				if(data == "MANDATORY_ERROR"){
					$("#채팅내용").val('');
					$("#채팅내용").focus();
					//$("#chatting-list").append(data);
				}else if(data == "ENTRANCE_AGAIN"){
					debug('재입장-db에 있는 경우....');
					mySocket.send(채팅내용);
				}else{
					debug("기록하기:"+채팅내용);
					mySocket.send(채팅내용);
					$("#채팅내용").val('');
					$("#채팅내용").focus();
				}
			}
		});	
	}

	var pk_chatting_history;

	function read_chatting_data(){
		var pk_chatting_history = $(".pk_chatting_history:last").val();

		if(pk_chatting_history == undefined){
			pk_chatting_history = 0;
		}

		//debug("pk_chatting_history::::"+pk_chatting_history);

		$.ajax({
			type: 'POST',
			url: "_ajax_chatting_read.php",
			data: {
				pk_chatting_history: pk_chatting_history
			},
			async: false,
			success: function(data){

					//debug(data);
				
				$("#chatting-list").append(data);
				if(data!=""){
					go_scroll();
				}
			}
		});
	}

	function go_enter(){
		$.ajax({
			type: 'POST',
			url: "_ajax_chat_enter.php",
			data: {
			},
			async: false,
			success: function(data){
			}
		});
	}

	function scrollIntoView(node) {
	  var parent = node.parent;
	  var parentCHeight = parent.clientHeight;
	  var parentSHeight = parent.scrollHeight;
	  if (parentSHeight > parentCHeight) {
		var nodeHeight = node.clientHeight;
		var nodeOffset = node.offsetTop;
		var scrollOffset = nodeOffset + (nodeHeight / 2) - (parentCHeight / 2);
		parent.scrollTop = scrollOffset;
	  }
	  if (parent.parent) {
		scrollIntoView(parent);
	  }
	}
</script>

<body>
<header class="header top_fixed">
	<h2 class="header-title text-center"><img src="./assets/img/core-img/logo_b.png"></h2>
</header>

	<section>
		<div class="container">
			<div class="row align-items-center justify-content-center">
				<div class="col-sm-12 col-lg-6 col-xl-4 px-0">

					<!--chat-->
					<div class="tabmenu-top tabmenu-bottom">
						<div class="talk-history py-3 px-2" id="talk-history">
								<?/**
								<!--투데이번개-->
								<div class="talk-btn-today">
									<a href="javascript:void(0)" title="투데이번개" data-id="md-today" data-toggle="golfen-modal">
										<img src="assets/images/icon/lightning.png" alt="투데이번개 아이콘" width="45"/>
									</a>
								</div>
								<!--투데이번개-->
								**/?>


						<div id="chatting-list">
						</div>

					</div>
					<!--//chat-->
					<!--입력창-->
					<div class="con-comment-input col-sm-10 col-lg-6 col-xl-4 p-0 background-white">
						<div class="d-flex" style="background:#fff;">
							<input type="text" name="채팅내용" id="채팅내용" class="w-100 ml-2 py-1" style="background: #fff; height:30px; border:1px solid #fff; margin-top:7px;" placeholder="내용을 입력해주세요"/>
							<button type="button" class="btn btn-dark col-2 p-0 m-2" onClick="go_reg_채팅내용();">전송</button>
						</div>
					</div>
					<!--//입력창-->
					
					
				</div>
			</div>
		</div>
		
	</section>

<!--벙개만들기-->
	<div class="md-today remodal hidden" id="md-today">
		<div class="remodal-contents text-left p-3">
			<div>
				<div class="form-group">
					<i class="fas fa-bolt color-danger"></i>
					<input class="form-control color-danger" id="" name="" type="text" placeholder="벙개 제목을 작성해주세요" />
				</div>
				<div class="form-group">
					<i class="far fa-clock"></i>
					<strong>오늘</strong>
					<input class="form-control" id="" name="" type="text" placeholder="오후 7:00"  />
				</div>
				<div class="form-group">
					<i class="fas fa-map-marker-alt"></i>
					<input class="form-control" id="" name="" type="text" placeholder="강남구" />
				</div>
				<div class="form-group">
					<i class="fas fa-won-sign"></i>
					<input class="form-control" id="" name="" type="text" placeholder="15,000원" />
				</div>
				<div class="form-group">
					<i class="fas fa-child"></i>
					<input class="form-control" id="" name="" type="text" placeholder="참석 정원" />
				</div>
				<div class="form-group d-flex align-items-center justify-content-center mt-4">
					<span>최소</span><input class="form-control col-2 input-sm mx-3 p-2 text-right color-danger" id="" name="" type="number" placeholder="1" /><span>명 참석시 진행합니다.</span>
				</div>
			</div>
		</div>
		<div class="remodal-footer text-center">
			<button class="btn btn-gray fs-0" onclick="hideModal()">취소</button>
			<button class="btn btn-info2 btn-lg fs-0">벙개 만들기</button>
		</div>
	</div>
	<!--벙개만들기-->
</body>

<script>
	$('.nav_category li[data-name="gnb-channel"]').addClass('active');
</script>

<script src="/page/assets/js/chat.js"></script>

</html>