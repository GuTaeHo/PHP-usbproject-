<?php
require_once "../app.php";

/**
 * getBoardNum.php (현 파일)은 board 테이블의 viewcount를 업데이트함과 동시에,
 * db로 부터 board 테이블과 member 테이블을 조인하여 반환된 레코드를
 * json형식으로 인코딩한뒤 반환하는 작업을 함.
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// get방식으로 글 번호를 가져옴
$boardCode = $_GET["boardCode"];
// get방식으로 조회수 가져옴
$viewCount = $_GET["viewCount"];

// 조회수 1 증가
++$viewCount;

/**
 * --------------------------- UPDATE 문 ---------------------------
 */

// 증가된 조회수 객체에 담음
$data = Array (
    'viewcount' => $viewCount,
);

// board테이블의 글 번호와 일치하는 조회수에 1 증가된 조회수 업데이트
$db->where('b_code', $boardCode);
$db->update('board', $data);

// 위의 코드를 sql문으로 변환하면 다음과 같음
// UPDATE board SET viewcount = $viewCount WHERE b_code = $boardCode

/**
 * --------------------------- SELECT 문 ---------------------------
 */

// member 테이블의 m_code(멤버 테이블의 기본키)와 board 테이블의 m_code가 같은 레코드만 출력하기 위한 좌 조인
// LEFT JOIN member m ON m.m_code=b.m_code
$db->join("member m", "m.m_code=b.m_code", "LEFT");
// 게시글 번호와 같은 레코드를 가져오기 위해 WHERE 절 추가
$db->where("b.b_code", $boardCode);

$board = $db->get('board b', null, 'm.nickname, b.b_code, b.title, b.date, b.viewcount, b.textbox');

// 위의 코드를 sql으로 변환하면 다음과 같음. get()은 select 문을, join()은 join문을, where()는 where문에 관한 기능을 가짐
// SELECT m.nickname, b.b_code, b.title, b.date, b.viewcount, b.textbox FROM board b LEFT JOIN member m ON m.m_code=b.m_code WHERE b.b_code = $boardCode;


// 반환된 레코드를 result 배열에 저장
$result['result_data'] = $board;
// 에러가 없음을 저장
$result['error'] = false;


// PHP 5.2 버전 이상부터는 JSON Parser를 기본 내장하고 있음. Rest Api 의 표준 형식.
//    - json_decode : JSON 오브젝트 -> PHP Array 또는 Object 변환
//    - json_encode : PHP Array 또는 Object -> JSON 오브젝트 변환
//
// PHP JSON 관련 Encode 작업 중에는 한글 깨짐에 주의. (주로 JSON_UNESCAPED_UNICODE)로 해결
echo json_encode($result);