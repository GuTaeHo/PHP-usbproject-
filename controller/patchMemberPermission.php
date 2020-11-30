<?php
require_once "../app.php";

/**
 * patchMemberPermission.php (현 파일)은 관리자 페이지에서 회원의 Permission(사용자 권한)을
 * 수정(UPDATE)하는 기능을 하며, json형식으로 인코딩한뒤 반환하는 작업을 함.
 */

// 강제적으로 캐시 무효화
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// POST 형식으로 전달된 값을 변수에 저장
$memberCode = $_POST["memberCode"];
$permission = $_POST["permission"];


// -------------------- UPDATE -------------------------

$data = Array (
    'permission' => $permission,
);

// UPDATE FROM member WHERE m_code = $memberCode;
$db->where('m_code', $memberCode);
$db->update('member', $data);

// error가 없음을 배열에 저장
$result['error'] = false;

// json형식으로 인코딩하여 반환
echo json_encode($result);