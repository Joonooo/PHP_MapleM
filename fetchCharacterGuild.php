<?php
// fetchCharacterId.php

$envPath = __DIR__ . '/.env';
$lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($lines as $line) {
    if (strpos(trim($line), '#') === 0) continue; // 주석 무시
    putenv($line);
}

$API_KEY = getenv('API_KEY');

// 클라이언트로부터 받은 파라미터를 변수에 저장
$ocid = filter_input(INPUT_GET, 'ocid', FILTER_SANITIZE_STRING);

// 한글 파라미터 인코딩
$ocid = urlencode($ocid);

// Nexon API 요청 URL 구성
$url = "https://open.api.nexon.com/maplestorym/v1/character/guild?ocid=$ocid";

// cURL 세션 초기화
$ch = curl_init($url);

// cURL 옵션 설정
curl_setopt($ch, CURLOPT_HTTPHEADER, [
	"x-nxopen-api-key: $API_KEY"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // SSL 인증서 검증 활성화
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 호스트명 검증 활성화

// API 요청 실행 및 응답 저장
$response = curl_exec($ch);

// 에러 처리
if (curl_errno($ch)) {
	$error_msg = curl_error($ch);
	echo json_encode(['error' => $error_msg]);
	curl_close($ch);
	exit();
}

// HTTP 응답 코드 처리
$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if ($httpStatusCode != 200) {
	echo json_encode(['error' => "API 요청 실패, HTTP 상태 코드: $httpStatusCode"]);
	curl_close($ch);
	exit();
}

// cURL 세션 종료
curl_close($ch);

// 응답 출력
header('Content-Type: application/json');
echo $response;