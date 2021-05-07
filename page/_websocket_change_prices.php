<script>
	var socketUrl = "<?=$_EXCHANGE_WS_URI_PAY ?>"; 

    var echoClient;

    function doWebSocket() {
      echoClient = new Echo({
        broadcaster: 'socket.io',
        host: socketUrl,
      });
      listenForPrices();
    }

    function listenForPrices() {
      echoClient.channel('App.Prices')
        .listen('PricesUpdated', (newPrices) => {

			debug(newPrices);

			var con_cur = Object.keys(newPrices.data);
			if(newPrices.data[con_cur[0]].currency == "chc"){
				
				var _change = Number(newPrices.data[con_cur[0]].change).toFixed(2);
				var _coin = newPrices.data[con_cur[0]].coin;
				var _price = Number(newPrices.data[con_cur[0]].price).toFixed(3);

				$("#"+_coin+"_변화율").html(_change + " %");
				if(_change>0){
					$("#"+_coin+"_변화율").addClass("color-twitter");
					$("#"+_coin+"_변화율").removeClass("color-black");
					$("#"+_coin+"_변화율").removeClass("color-info");

					$("#"+_coin+"_코인가격").addClass("color-secondary");
					$("#"+_coin+"_코인가격").removeClass("color-danger");
					$("#"+_coin+"_코인가격").removeClass("color-black");

				}else if(_change==0){
					$("#"+_coin+"_변화율").addClass("color-black");
					$("#"+_coin+"_변화율").removeClass("color-info");
					$("#"+_coin+"_변화율").removeClass("color-twitter");

					$("#"+_coin+"_코인가격").addClass("color-black");
					$("#"+_coin+"_코인가격").removeClass("color-danger");
					$("#"+_coin+"_코인가격").removeClass("color-secondary");

				}else if(_change<0){
					$("#"+_coin+"_변화율").addClass("color-info");
					$("#"+_coin+"_변화율").removeClass("color-twitter");
					$("#"+_coin+"_변화율").removeClass("color-black");

					$("#"+_coin+"_코인가격").addClass("color-danger");
					$("#"+_coin+"_코인가격").removeClass("color-secondary");
					$("#"+_coin+"_코인가격").removeClass("color-black");

				}
				$("#"+_coin+"_코인가격").html(_price);
			}
        });
    }

    window.addEventListener("load", doWebSocket, false);
</script>