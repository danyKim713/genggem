	var mySocket    = null;
	var serverUrl   = 'wss://genggem.com:8114/';  //  wss: is ws: but using SSL.
	var oWebSocket  = window.WebSocket || window.MozWebSocket;
	if (oWebSocket) {
		mySocket = new oWebSocket (serverUrl);
		if (mySocket) {
			console.log (mySocket);
			mySocket.onopen     = onSocketOpen;
			mySocket.onclose    = onSocketClose;
			mySocket.onmessage  = onSocketMessage;
			mySocket.onerror    = onSocketError;

//			setTimeout (closeSocket, 5000);  //  Be polite and free socket when done.
		}
	}

	function onSocketOpen (evt) {
		go_reg_채팅내용('입장');
		
		console.log ("Socket is now open.");
		//mySocket.send ("Hello from my first live web socket!");
	}

	function onSocketClose (evt) {
		console.log ("Socket is now closed.");
	}

	function onSocketMessage (evt) {
		console.log ("Recieved from socket: ", evt.data);

		//채팅 오면 이리로 표시...
		read_chatting_data();

	}

	function onSocketError (evt) {
		console.log ("Error with/from socket!:");
		//console.log (evt);
	}

	function closeSocket () {
		if (mySocket.readyState !== mySocket.CLOSED) {
			//console.log ("Closing socket from our end (timer).");
			mySocket.close ();
		}else{
			//console.log ("Socket was already closed (timer).");
		}
	}

	$(window).on("beforeunload", function(){
		//go_reg_채팅내용("퇴장");
	});