<?php
    // db 라이브러리 포함
    require_once "../app.php";

    // 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
    header('Cache-Control: no-cache, must-revalidate');
    // 날짜와 시간을 포맷 형식에 따라 포맷
    header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
    // json 전송, 문자열을 utf-8로 변경
    header('Content-type: application/json; charset=utf-8');
    
    // 세션 시작
    session_start();

    // 현재 세션에 id를 가져옴
    $id = $_SESSION['userId'];

    // id에 해당하는 레코드를 가져옴
    // WHERE id = $id
    $db->where('id', $id);
    // SELECT * FROM member WHERE id = $id
    $result = $db->get('member');

    // sql질의 후 반환된 레코드를 result 배열에 저장
    $result['result_data'] = $result;
    $result['error'] = false;

    echo json_encode($result);
?>