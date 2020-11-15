<?php
require_once "../app.php";

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// MVC 아키텍처의 Model은 DB서버와의 데이터 출력, 입력, 삭제, 수정의 기능을 담당한다.
// putRegist.php는 member 테이블에 가입정보를 입력하는 기능을 담당

$id = $_POST["id"];
$password = $_POST["passwd"];
$nickname = $_POST["nickname"];
$name = $_POST['name'];
$email = $_POST["email"];

// 날짜 형식 ex)  2020-11-14 19:51:49

// 객체를 하나 생성한 뒤, post방식으로 받은 데이터를 객체의 키, 값으로 저장
$data = Array (
    "id" => $id,
    "password" => $password,
    "nickname" => $nickname,
    "name" => $name,
    "email" => $email,
    // sql구문 select now() 와 같음
    "date" => $db->now()
);

$data = array_filter($data);

// sql INSERT 구문 실행
if ($db->insert ('member', $data)) {
    $result['error'] = false;
} else {
    $result['error'] = true;
    $result['msg'] = $data;
}

// json 형식으로 반환하기 위해 인코딩
echo json_encode($result);

// 위의 코드를 sql문으로 나타내면 다음과 같음.
// INSERT INTO member (id, password, nickname, name, email, date) VALUES ('$id', '$password', '$nickname', '$name', '$email', '$registDate');

