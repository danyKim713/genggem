function debug(s){
	console.log(s);
}

Number.prototype.number_format = function(round_decimal) {
    return this.toFixed(round_decimal).replace(/(\d)(?=(\d{3})+$)/g, "$1,");
};


function 자리수시세가격포맷팅(n,a){
//	return Number(n).toFixed(6).replace(/(\d)(?=(\d{3})+$)/g, "$1,");
	return Math.floor(n).number_format(0) + 소수점아래자리수만구하기(n,a);
//	return Number(n).number_format(6);
}

function 시세가격포맷팅(n){
//	return Number(n).toFixed(6).replace(/(\d)(?=(\d{3})+$)/g, "$1,");
	return Math.floor(n).number_format(0) + 소수점아래자리수만구하기(n,4);
//	return Number(n).number_format(6);
}

function 수수료포맷팅(n){
//	return Number(n).toFixed(6).replace(/(\d)(?=(\d{3})+$)/g, "$1,");
	return Math.floor(n).number_format(0) + 소수점아래자리수만구하기(n,3);
//	return Number(n).number_format(6);
}


function pad(n, width, z) {
  z = z || '0';
  n = n + '';
  return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
}

function 소수점아래자리수만구하기(num, d){
	var t = Number(num).toFixed(d).split(".");
	var i = 0;
	if(t[1]==undefined){
		return "";
	}
	return "."+t[1];
}

function 소수점아래자리수하기(num){
	var t = num.split(".");
	var i = 0;
	if(t[1]==undefined){
		return 0;
	}
	while(t[1][i]){
		i++;
	}
	return i;
}

function copyText(id) {
  /* Get the text field */
  var copyText = document.getElementById(id);

  /* Select the text field */
  copyText.select();

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the Wallet Address");
}


function go_change_language_dic(obj){
	setCookie('dic_lang',obj.value,90);
	location.reload(true);
}

function setCookie(cookie_name, value, days) {
  var exdate = new Date();
  exdate.setDate(exdate.getDate() + days);
  // 설정 일수만큼 현재시간에 만료값으로 지정

  var cookie_value = escape(value) + ((days == null) ? '' : ';    expires=' + exdate.toUTCString());
  document.cookie = cookie_name + '=' + cookie_value;
}

function getCookie(cookie_name) {
  var x, y;
  var val = document.cookie.split(';');

  for (var i = 0; i < val.length; i++) {
    x = val[i].substr(0, val[i].indexOf('='));
    y = val[i].substr(val[i].indexOf('=') + 1);
    x = x.replace(/^\s+|\s+$/g, ''); // 앞과 뒤의 공백 제거하기
    if (x == cookie_name) {
      return unescape(y); // unescape로 디코딩 후 값 리턴
    }
  }
}


function deleteAllCookies() {

	document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });

	if(window.AndroidApp != undefined){
		window.AndroidApp.removeAllCookie();
	}
}

function deleteCookie(name){
  setCookie(name,"",-1);
}

// 숫자 타입에서 쓸 수 있도록 format() 함수 추가
Number.prototype.format = function(){
    if(this==0) return 0;
 
    var reg = /(^[+-]?\d+)(\d{3})/;
    var n = (this + '');
 
    while (reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');
 
    return n;
};
 
// 문자열 타입에서 쓸 수 있도록 format() 함수 추가
String.prototype.format = function(){
    var num = parseFloat(this);
    if( isNaN(num) ) return "0";
 
    return num.format();
};

function copyToClipboard(element) {
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
}