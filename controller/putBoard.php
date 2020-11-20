<?php
require_once "../app.php";
// db와의 연동을 위해 app.php (같은 파일을 한번만) 포함

/**
 * 본 파일은 boardWrite.php 의 글쓰기 버튼이 눌리면 넘어오는 값을
 * db의 board테이블에 INSERT하는 기능을 가지며, json형식으로 에러 결과를 반환함
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 형태, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

session_start();

// 제목, 비공개, 댓글허용, 내용
// $author = $_POST["author"];
$title = $_POST["title"];
$type = $_POST["type"];
$comments = $_POST["comments"];
$boardContent = $_POST["boardContent"];

// 로그인 한 유저의 멤버코드 가져옴
$memberCode = $_SESSION["userCode"];

// 비공개가 체크되지 않았다면
if (empty($type)) {
    $type = "display";
}

// 댓글 허용이 체크되지 않았다면
if (empty($comments)) {
    $comments = "deny";
}

$data = Array (
    'title' => $title,
    'm_code' => $memberCode,
    'textbox' => $boardContent,
    'date' => $db->now(),
    'type' => $type,
    'comments' => $comments
);

$queryResult = $db->insert('board', $data);

$result['result_data'] = $queryResult;

$result["error"] = false;

echo json_encode($result);




