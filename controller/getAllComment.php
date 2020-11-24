<?php
require_once "../app.php";

/**
 * getAllComment.php (현 파일)은 db로 부터 comment 테이블의 모든 컬럼을 검색하여
 * 게시글 번호를 기준으로 정렬한뒤, json형식으로 인코딩한뒤 반환하는 작업을 함.
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// b_code(게시글 번호)를 기준으로 정렬
$db->orderBy('b_code');
// comment 테이블의 모든 컬럼을 들고옴
$AllComments = $db->get('comment');

// 위의 코드를 sql으로 변환하면 다음과 같음 (ORDER BY 절의 Default값은 오름차순임)
// SELECT * FROM comment ORDER BY b_code (asc);

// 검색된 레코드의 수를 변수에 저장
$countAllComments = $db->count;

// 반환된 레코드를 result 배열에 저장
$result['comment_count'] = $countAllComments;
$result['result_data'] = $AllComments;
$result['error'] = false;

echo json_encode($result);