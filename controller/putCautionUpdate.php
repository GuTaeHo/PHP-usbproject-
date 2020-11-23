<?php
require_once "../app.php";

/**
 * 본 파일은 boardView.php 의 신고 버튼이 눌리면 호출 되며,
 * comment 테이블의 caution(경고)을 증가 (UPDATE 문) 역할 및
 * 일정 횟수가 넘어가면 댓글을 삭제(DELETE 문)하는 기능을 함
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// 넘겨받은 게시글 번호 및 댓글 기본키, 경고 수 저장
$boardCode = $_POST['boardCode'];
$commentCode = $_POST['commentCode'];
$caution = $_POST['caution'];

// 경고 + 1
$caution = $caution + 1;

// 경고가 5회 미만일 때
if ($caution < 5 ) {

    // db에 UPDATE할 객체를 생성
    $data = array("caution" => $caution);

    // 댓글 고유번호가 $commentCode 이고, 게시글 번호가 $boardCode 인 레코드를
    $db->where('c_code', $commentCode);
    $db->where('b_code', $boardCode);
    // comment 테이블에 UPDATE
    $dbResult = $db->update('comment', $data);

    // 위의 코드를 sql로 변환하면 다음과 같음
    // UPDATE TABLE SET caution = $caution WHERE c_code = $commentCode AND b_code = $boardCode;

// 경고가 5회 이상일 때
} else {
    $db->where('c_code', $commentCode);
    $db->where('b_code', $boardCode);

    $db->delete('comment');
    // 위의 코드를 sql로 변환하면 다음과 같음
    // DELETE FROM comment WHERE c_code = $commentCode AND b_code = $boardCode;
}

$result['result_data'] = $dbResult;
$result['error'] = false;

echo json_encode($result);
