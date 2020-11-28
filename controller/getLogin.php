<?php
require_once "../app.php";

/**
 * 본 파일은 login.php 의 로그인 버튼이 눌리면 호출 되며,
 * 넘겨받은 id가 db와 일치하면 세션에 db의 관련 컬럼을 저장하고,
 * 메인 페이지로 돌려보내는 기능을 함
 */
// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 전송, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');


// post형식으로 전송된 id값 저장
$idValue = $_POST["id"];
$passWordValue = $_POST["passwd"];

//recaptcha v3 사용
$captcha = $_POST['g-recaptcha-response'];
// 발급 받은 사이트 키를 저장
$secretKey = "6Lfe0eUZAAAAADiu94iBRJ4d07vyZol_D5Wqz8Jg";
$ip = $_SERVER['REMOTE_ADDR'];
$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
$responseKeys = json_decode($response,true);

// CAPTCHA 인증에 성공한 경우
if($responseKeys["success"]) {
    // 통과한 경우 
    $result['captcha_error'] = "인증 성공";
}
else {
    // 실패한 경우 (봇)
    $result['captcha_error'] = "인증 실패";
    return;
}


// get()는 SELECT 하는 기능을 가지며, 인자로 테이블명, 레코드 수, 컬럼명을 입력받음
// 아래의 코드를 sql으로 변환하면 다음과 같음 => SELECT * FROM member WHERE id = "$idValue"

$db->where ("id" , $idValue);
$member = $db->getOne("member");

    // 아이디, 비번이 db와 일치하고 type(상태)가 -2(관리자에 의해 삭제)가 아니라면
    if (($idValue == $member['id']) && ($passWordValue == $member['password'])) {
        if ($member['type'] != -2) {
            // 세션 시작
            session_start();
            $_SESSION["userCode"] = $member['m_code'];
            $_SESSION["userId"] = $member['id'];
            $_SESSION["userNickname"] = $member['nickname'];
            $_SESSION["userName"] = $member['name'];
            $_SESSION["userEmail"] = $member['email'];
            $_SESSION["userPermission"] = $member['permission'];

            /**
             * permission(권한)의 종류는 4가지가 있음
             *  - 1 : 일반 사용자
             *  - 2 : 우수 사용자
             *  - 3 : 매니저
             *  - 4 : 관리자
             */

            switch ($_SESSION["userPermission"]) {
                // 일반 사용자 라면
                case 1:
                    $_SESSION['userPermission'] = '일반사용자';
                    break;
                // 우수 사용자 라면
                case 2:
                    $_SESSION['userPermission'] = '우수사용자';
                    break;
                // 매니저 라면
                case 3:
                    $_SESSION['userPermission'] = '매니저';
                    break;
                // 관리자 라면
                case 4:
                    $_SESSION['userPermission'] = '관리자';
                    break;
            }
            $result["error"] = true;
            // 관리자에 의해 삭제 되었다면
        } else {
            $result["deleted_user"] = true;
        }
        
    // 아이디 비번이 일치하지 않는다면
    } else {
        $result["error"] = false;
    }

echo json_encode($result);




