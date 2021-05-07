<?php

$대화내용 = "곧 2차 코인세일을 기대해주세요. 골프 앱의 선두주자! 골펜은 더욱 더 발전할 것입니다. 골/펜! 오늘은 ".date("Y년 n월 j일")."입니다.";

$목소리배열 = array("WOMAN_DIALOG_BRIGHT","MAN_DIALOG_BRIGHT");
//$목소리배열 = array("WOMAN_READ_CALM","MAN_READ_CALM","WOMAN_DIALOG_BRIGHT","MAN_DIALOG_BRIGHT");

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://kakaoi-newtone-openapi.kakao.com/v1/synthesize");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, '<speak><voice name="'.$목소리배열[rand(0,3)].'" rate="fast" volume="loud">'.$대화내용.'</voice></speak>');
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/xml", "Authorization: KakaoAK 7f3243cc001c4aa53d3cdc168fe2981a"));
$result = curl_exec($ch);
curl_close($ch);

header('Content-Type: audio/mpeg');
header('Cache-Control: no-cache');
header('Content-length: '.strlen($result));
echo $result;