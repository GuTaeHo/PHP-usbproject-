<?php
    session_start();
    unset($_SESSION['userId']);
    unset($_SESSION["userNickname"]);
    unset($_SESSION["userEmail"]);
    unset($_SESSION["userName"]);

    echo "<script>
            alert('로그아웃 완료!');
            location.href='../index.php';
        </script>";

?>