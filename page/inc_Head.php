<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>젠껨-GenGGEm</title>
  
	<? include_once "inc_Head_meta.php"; ?>
  
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
	<link href="//code.jquery.com/ui/1.12.1/themes/le-frog/jquery-ui.css" rel="stylesheet">

	<script src="/js/dev.js"></script>
	<? include $_SERVER["DOCUMENT_ROOT"]."/js/dev.common.js.php"; ?>

	<!--  bootstrap-->
	<link href="/page/assets/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="/page/assets/lib/bootstrap/dist/css/bootstrap-grid.min.css" rel="stylesheet">
	<link href="/page/assets/lib/bootstrap/dist/css/bootstrap-reboot.min.css" rel="stylesheet">
	<script src="assets/lib/tether-1.3.3/dist/js/tether.min.js"></script>
	<!-- <script src="/page/assets/lib/boodtstrap/dist/js/bootstrap.min.js" Defer></script> -->
	<!--  style-->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/page/assets/css/style.css">
	<link rel="stylesheet" href="/page/assets/css/custom.css?20191021">
	<link rel="stylesheet" href="/page/assets/css/dgkim.css?20191021">
	<!--  icon-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link href="/page/assets/font/pay-icon/style.css" rel="stylesheet">
	<link href="/page/assets/font/biko-icon/style.css" rel="stylesheet">
	<!--  js-->
	<script src="/page/assets/js/core.js"></script>
	<script src="/page/assets/js/main.js"></script>
	<script src="/page/assets/js/dev.js"></script>
	
	<!-- <script src="/page/assets/lib/modal/modal.js"></script>
	<link href="/page/assets/lib/modal/modal.css" rel="stylesheet" />
	
	<script src="/page/assets/lib/echo/socket.io.js"></script>
	<script src="/page/assets/lib/echo/echo.iife.js"></script>

	<!--  plugin-->
	<script src="/page/assets/lib/slick/js/slick.min.js"></script>
	<link href="/page/assets/lib/slick/css/slick.css" rel="stylesheet">
	<link href="/page/assets/lib/slick/css/slick-theme.css" rel="stylesheet">
	<link href="/page/assets/lib/slick/css/slick-theme.css" rel="stylesheet">

	<link href="/page/assets/lib/lightbox2/dist/css/lightbox.min.css" rel="stylesheet">
	<script src="/page/assets/lib/lightbox2/dist/js/lightbox.min.js"></script>

	<script src="/assets/lib/rater-master/rater.min.js"></script> 

	<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postdcode.v2.js"></script>

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">

	<!-- 2020-11-30 추가 -->
	<link rel="apple-touch-icon" href="apple-touch-icon.png">
	<!-- <link rel="stylesheet" href="css/bootstrap.min.css"> 
	<!-- <link rel="stylesheet" href="css/fontAwesome.css"> 
	<link rel="stylesheet" href="/page/assets/css/hero-slider.css">
	<link rel="stylesheet" href="/page/assets/css/owl-carousel.css">-->
	<link rel="stylesheet" href="/page/assets/css/templatemo-main.css">	
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<script src="/page/assets/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
	<!-- // -->

	<link rel="icon" href="./assets/img/core-img/favicon.png">

	<script>
/* 달력(datepicker) */
jQuery(function($) {
    $.datepicker.regional['ko'] = {
        closeText : '닫기',
        prevText : '이전달',
        nextText : '다음달',
        currentText : '오늘',
        monthNames : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort : ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames : ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort : ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin : ['일', '월', '화', '수', '목', '금', '토'],
        weekHeader : 'Wk',
        dateFormat : 'yy-mm-dd',
        firstDay : 0,
        isRTL : false,
        showMonthAfterYear : true,
        yearSuffix : '년'
    };
    $.datepicker.setDefaults($.datepicker.regional['ko']);
	
    $(".datepicker").datepicker({ 
     changeMonth: true, //월변경가능
     changeYear: true, //년변경가능
     yearRange:'2010:+10', // 연도 셀렉트 박스 범위(현재와 같으면 1988~현재년)
     showMonthAfterYear: true, //년 뒤에 월 표시
     buttonImageOnly: true, //이미지표시  
     buttonText: '날짜', 
     autoSize: false, //오토리사이즈(body등 상위태그의 설정에 따른다)

  });
});			
	</script>

<script data-ad-client="ca-pub-6435515015000343" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
</head>

<?/**
<!-- 1. include required files -->
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/loadingio/ldLoader@v1.0.0/dist/ldld.min.css"/>
<script src="https://cdn.jsdelivr.net/gh/loadingio/ldLoader@v1.0.0/dist/ldld.min.js"></script>
**/?>

<script>
	$(function(){
		$(".loading").hide();
	});
</script>

<style type="text/css">
	.loading {
		position: absolute;
		z-index: 9999;
		top: 50%;
		text-align: center;
		width: 100%;
		height: 100%;
	}
	.loading img {
		width: 80px;
		height: 80px;
	}
</style>
<div class="loading">
	<img src="./assets/images/Spin-1s-200px.gif">
</div>

<div class="overlay"></div>