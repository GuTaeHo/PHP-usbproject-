<?php
require_once "../app.php";

// post형식으로 전송된 id값 저장
$idValue = $_POST["id"];
$passWordValue = $_POST["passwd"];

// get()는 SELECT 하는 기능을 가지며, 인자로 테이블명, 레코드 수, 컬럼명을 입력받음
// 아래의 코드를 sql으로 변환하면 다음과 같음 => SELECT * FROM member WHERE id = "$idValue"

$db->where ("id" , $idValue);
$member = $db->getOne("member");

    // 아이디, 비번이 db와 일치하면
    if (($idValue == $member['id']) && ($passWordValue == $member['password'])) {
        // 세션 시작
        session_start();
        $_SESSION["userId"] = $member['id'];
        $_SESSION["userNickname"] = $member['nickname'];
        $_SESSION["userEmail"] = $member['email'];
        $_SESSION["userName"] = $member['name'];
        // $_SESSION["userLevel"] = $member['']

        echo "<script>
                alert('로그인 완료');
                // 메인 페이지로
                location.href = '../index.php';
            </script>";
    } else {
        echo "<script>
                alert('아이디 또는 패스워드가 다릅니다!!!');
                // 이전 화면으로 복귀
                location.href = '../index.php?target=login';
            </script>";
    }


?>



