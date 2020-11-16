<?php
// db와의 연동을 위해 app.php (같은 파일을 한번만) 포함
require_once "../app.php";

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

// putMemberModify.php는 member 테이블에 가입정보를 수정(업데이트)하는 기능을 담당

// WHERE 문으로 비교하기 위해 post로 가져옴
$id = $_POST["id"];

// 사용자가 수정한 데이터 post로 가져옴
$password = $_POST["passwd"];
$nickname = $_POST["nickname"];
$name = $_POST['name'];
$email = $_POST["email"];

// 객체를 하나 생성한 뒤, post방식으로 받은 데이터를 객체의 키, 값으로 저장
$data = Array (
    "password" => $password,
    "nickname" => $nickname,
    "name" => $name,
    "email" => $email,
);

// array_filter() 함수는 객체의 프로퍼티의 키에 값이 없다면 프로퍼티를 제거해버림
// 사용자가 name에 아무런 값도 입력하지 않았다면 "name"이라는 프로퍼티를 제거함
// db에서는 name 컬럼에 아무런 값도 입력하지 않았기 때문에 null을 넣음
$data = array_filter($data);

// $db->where('id', $id);
$db->where('id', $id);
// sql UPDATE 구문 실행

if ($db->update('member',$data)) {
    $result['error'] = false;
    $result['msg'] = $data;
} else {
    $result['error'] = true;
    $result['msg'] = $data;
}

// 위의 코드를 sql문으로 나타내면 다음과 같음.
// UPDATE member SET password = '$password', nickname = '$nickname', name = '$name', email = '$email' WHERE id = '$id'


// json 형식으로 반환하기 위해 인코딩
echo json_encode($result);

