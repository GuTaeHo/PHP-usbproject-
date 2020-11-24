<?php
require_once "../app.php";

/**
 * getAllMembers.php (현 파일)은 db로 부터 member 테이블의 모든 컬럼을 검색하여
 * json형식으로 인코딩한뒤 반환하는 작업을 함.
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// permission(사용자 권한)을 기준으로 내림차순 정렬
$db->orderBy('permission', "DESC");
// member 테이블의 모든 컬럼을 들고옴
$AllMembers = $db->get('member');

// 위의 코드를 sql으로 변환하면 다음과 같음
// SELECT * FROM member ORDER BY permission DESC;

// 검색된 레코드의 수를 변수에 저장
$countAllMembers = $db->count;

// 반환된 레코드를 result 배열에 저장
$result['member_count'] = $countAllMembers;
$result['result_data'] = $AllMembers;
$result['error'] = false;

echo json_encode($result);