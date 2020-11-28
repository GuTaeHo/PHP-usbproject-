<?php
require_once "../app.php";

/**
 * deleteMember.php (현 파일)은 회원 관련된 모든 db레코드를 삭제(숨김)
 * 기능을 수행 하며, json형식으로 인코딩한뒤 반환하는 작업을 함.
 */

// 강제적으로 캐시 무효화
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// POST 형식으로 전달된 값을 변수에 저장
$memberID = $_POST["member"];

// SELECT * FROM member WHERE id = $memberID
$db->where('id', $memberID);
$member = $db->get('member');

// id를 통해서 찾은 회원 고유 번호를 통해 comment -> board -> member 순으로 관련된 레코드 삭제(변경)
$memberCode = $member[0]['m_code'];


// type 컬럼의 -2는 관리자가 삭제했다는 의미를 가짐
$commentType = -2;

// -------------------- UPDATE -------------------------

$data = Array (
    'type' => $commentType
);

// UPDATE FROM comment WHERE m_code = $memberCode;
$db->where('m_code', $memberCode);
$db->update('comment', $data);


// UPDATE FROM board WHERE m_code = $memberCode;
$db->where('m_code', $memberCode);
$db->update('board', $data);


// UPDATE FROM member WHERE m_code = $memberCode;
$db->where('m_code', $memberCode);
$db->update('member', $data);


// error가 없음을 배열에 저장
$result['error'] = false;
$result['memberCode']= $member;

// json형식으로 인코딩하여 반환
echo json_encode($result);