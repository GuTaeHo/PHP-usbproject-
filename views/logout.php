<?php
    session_start();
    // 세션 해제
    // 유저 번호
    unset($_SESSION["userCode"]);
    // 아이디
    unset($_SESSION['userId']);
    // 닉네임
    unset($_SESSION["userNickname"]);
    // 이름
    unset($_SESSION["userName"]);
    // 이메일
    unset($_SESSION["userEmail"]);
    // 권한
    unset($_SESSION["userPermission"]);

    echo "<script>
            alert('로그아웃 완료!');
            location.href='../index.php';
        </script>";

?>