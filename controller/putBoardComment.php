<?php
// db와의 연동을 위해 app.php (같은 파일을 한번만) 포함
require_once "../app.php";

/**
 * 본 파일은 boardView.php 의 댓글 달기 버튼이 눌리면 넘어오는 값을
 * db의 comment 테이블에 INSERT하는 기능을 가지며, json형식으로 결과를 반환함
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// 게시글 번호, 게시글을 get방식으로 가져옴
$boardCode = $_POST["boardCode"];
$comment = $_POST["comment"];
$userCode = $_POST["sessionPost"];

// 로그인된 사용자의 회원 번호를 세션으로 부터 가져옴
// $userCode = $_SESSION["userCode"];

$data = Array (
    'm_code' => $userCode,
    'b_code' => $boardCode,
    'comment' => $comment,
    // sql구문 select now() 와 같음
    // 현재 날짜 및 시간을 반환함
    // 날짜 형식 ex) 2020-11-19 21:31:39
    'date' => $db->now(),
);

$response = $db->insert('comment', $data);

// 반환된 레코드를 result 배열에 저장
$result['result_data'] = $response;
$result['error'] = false;


// PHP 5.2 버전 이상부터는 JSON Parser를 기본 내장하고 있음. Rest Api 의 표준 형식.
//    - json_decode : JSON 오브젝트 -> PHP Array 또는 Object 변환
//    - json_encode : PHP Array 또는 Object -> JSON 오브젝트 변환
//
// PHP JSON 관련 Encode 작업 중에는 한글 깨짐에 주의. (주로 JSON_UNESCAPED_UNICODE)로 해결
echo json_encode($result);
