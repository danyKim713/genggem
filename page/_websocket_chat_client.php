<script>
	alert('start!~');
	var connection = new WebSocket('ws://golfen.co.kr:7076');
	connection.onopen = function () {
		alert('hi~');
	  connection.send('Ping'); // Send the message 'Ping' to the server
	};

	// Log errors
	connection.onerror = function (error) {
	  console.log('WebSocket Error ' + error);
	};

	// Log messages from the server
	connection.onmessage = function (e) {
	  console.log('Server: ' + e.data);
	};	
</script>