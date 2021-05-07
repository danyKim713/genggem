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
      echoClient.channel('App.OrderBook')
        .listen('OrderBookUpdated', (orderBook) => {

//		  debug(orderBook);

<? if(strpos($PHP_SELF, "bkc_change.php")===false){?>
			//var con_cur = Object.keys(orderBook.data);
			if(orderBook.data.currency == "chc" && orderBook.data.coin ==  "tec"){

				debug(orderBook);

				
				시장매수가격 = Number(orderBook.data.orderBook.meta.maxBuy.price);
				시장매수수량 = Number(orderBook.data.orderBook.meta.maxBuy.quantity);

				$("#price").val(시장매수가격);				

				$("#매수가격").html(Number(시장매수가격).toFixed(3));
				$("#매수수량").html(Number(시장매수수량).toFixed(6));

				$("#시장가능수량").val(시장매수수량);

				if(typeof go_change_tec_to_bank_tec_amount === "function"){
					go_change_tec_to_bank_tec_amount();
				}
			}

<?}else{?>

		if(orderBook.data.currency == "bkc" && orderBook.data.coin ==  코인종류){

			debug(orderBook);

			코인가격 = Number(orderBook.data.orderBook.meta.maxBuy.price);

			debug("코인가격:"+코인가격);

			go_change_coin();

		}
	

<?}?>
        });
    }

    window.addEventListener("load", doWebSocket, false);
</script>