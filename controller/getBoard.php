<?php
require_once "../app.php";

// MVC 아키텍처의 Controller는 Model이 DB서버로 부터 데이터를 처리하기 쉽도록
// 사용자에게 입력받은 데이터를 가공하는 역할을 함

// p.406 참조 php에서의 header() 함수는 다운로드할 파일의 정보를 클라이언트 브라우저에게 알려주는 기능을 함

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// member 테이블의 m_code(멤버 테이블의 기본키)와 board 테이블의 m_code가 같은 레코드만 출력하기 위한 좌 조인
// LEFT JOIN member m ON m.m_code=b.m_code
$db->join("member m", "m.m_code=b.m_code", "LEFT");
// $db->get(테이블명, 컬럼명) == SELECT m.nickname, b.b_code, b.title, b.date, b.viewcount FROM board b;
$board = $db->get('board b', null, 'm.nickname, b.b_code, b.title, b.date, b.viewcount');

// 위의 코드를 sql으로 변환하면 다음과 같음. get()은 select 문을, join()은 join문에 관련된 기능을 가짐
// SELECT m.nickname, b.b_code, b.title, b.date, b.viewcount FROM board b LEFT JOIN member m ON m.m_code=b.m_code;


// sql 구문을 result 배열에 저장
$result['result_data'] = $board;
$result['error'] = false;


// PHP 5.2 버전 이상부터는 JSON Parser를 기본 내장하고 있음. Rest Api 의 표준 형식.
//    - json_decode : JSON 오브젝트 -> PHP Array 또는 Object 변환
//    - json_encode : PHP Array 또는 Object -> JSON 오브젝트 변환
//
// PHP JSON 관련 Encode 작업 중에는 한글 깨짐에 주의. (주로 JSON_UNESCAPED_UNICODE)로 해결
echo json_encode($result);