<?php
require_once "../app.php";

/**
 * 본 파일은 regist.php의 가입버튼이 눌리면 호출되며,
 * 넘겨받은 값을 db에 INSERT 시키고, 에러 결과를
 * json형식으로 인코딩하여 반환하는 기능을 함
 */

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


//recaptcha v3 사용
$captcha = $_POST['g-recaptcha-response'];
// 발급 받은 사이트 키를 저장
$secretKey = "6Lfe0eUZAAAAADiu94iBRJ4d07vyZol_D5Wqz8Jg";
$ip = $_SERVER['REMOTE_ADDR'];
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);

// 인증에 성공한 경우
if($responseKeys["success"]) {
    //통과한 경우의 코드를 작성
    $result['captcha_result'] = "인증 성공";
    $result['captcha_error'] = false;
}
else {
    $result['captcha_result'] = "인증 실패";
    $result['captcha_error'] = true;
    return;
}

// 객체를 하나 생성한 뒤, post방식으로 받은 데이터를 객체의 키, 값으로 저장
$data = Array (
    "id" => $id,
    "password" => $password,
    "nickname" => $nickname,
    "name" => $name,
    "email" => $email,
    // sql구문 select now() 와 같음
    // 현재 날짜 및 시간을 반환함
    // 날짜 형식 ex)  2020-11-14 19:51:49
    "date" => $db->now(),
    // 권한 부여 (1: 일반 사용자)
    "permission" => 1,
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

