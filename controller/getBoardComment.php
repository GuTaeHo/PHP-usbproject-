<?php
require_once "../app.php";

/**
 * getBoardComment.php (현 파일)은 db로 부터 comment 테이블과 member테이블을 조인하여
 * member 테이블의 닉네임, comment 테이블의 여러 컬럼을 조회하여
 * json형식으로 인코딩한뒤 반환하는 작업을 함.
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// get형식의 boardCode의 값을 변수에 저장
$boardCord = $_GET["boardCode"];

// date를 기준으로 정렬
$db->orderBy("date","desc");
// 게시글 번호가 $boardCord와 일치하는 레코드들을
$db->where("b_code", $boardCord);

// member 테이블의 회원번호와 comment 테이블의 회원번호가 같은 레코드들을 좌 조인
$db->join("member m", "m.m_code=c.m_code","LEFT");

// comment테이블, member테이블의 nickname, c_code, comment, date 컬럼을 조회
$boardComment = $db->get("comment c", null, "m.nickname, c.comment, c.date");

// 위의 코드를 sql으로 변환하면 다음과 같음.
// SELECT m.nickname, c.c_code, c.m_code, c.comment, c.date FROM comment c LEFT JOIN member m ON m.m_code = c.c_code WHERE b_code = $boardCord

// 반환된 레코드를 result 배열에 저장
$result['result_data'] = $boardComment;
$result['error'] = false;


// PHP 5.2 버전 이상부터는 JSON Parser를 기본 내장하고 있음. Rest Api 의 표준 형식.
//    - json_decode : JSON 오브젝트 -> PHP Array 또는 Object 변환
//    - json_encode : PHP Array 또는 Object -> JSON 오브젝트 변환
//
// PHP JSON 관련 Encode 작업 중에는 한글 깨짐에 주의. (주로 JSON_UNESCAPED_UNICODE)로 해결
echo json_encode($result);