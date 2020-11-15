<?php
require_once "../app.php";

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// ajax가 get으로 날린 값 저장
$idValue = $_GET["id"];

// get()는 SELECT 하는 기능을 가지며, 인자로 테이블명, 레코드 수, 컬럼명을 입력받음
// 아래의 코드를 sql으로 변환하면 다음과 같음 => SELECT count(id) FROM member WHERE id = "$idValue"

$db->where ("id" , $idValue);
$db->get("member");
$count = $db->count;

// 입력과 일치하는 레코드 수 반환
$result['result_data_count'] = $count;
$result['error'] = false;

// json 형식으로 인코딩
echo json_encode($result);
