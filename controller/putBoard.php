<?php
require_once "../app.php";
// db와의 연동을 위해 app.php (같은 파일을 한번만) 포함

/**
 * 본 파일은 boardWrite.php 의 글쓰기 버튼이 눌리면 넘어오는 값을
 * db의 board테이블에 INSERT하는 기능을 가지며, json형식으로 에러 결과를 반환함
 */

// 강제적으로 캐시 무효화(서버와 클라이언트간의 동적인 html 생성을 위해)
header('Cache-Control: no-cache, must-revalidate');
// 날짜와 시간을 포맷 형식에 따라 포맷
header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
// json 형태, 문자열을 utf-8로 변경
header('Content-type: application/json; charset=utf-8');

session_start();

// 제목, 비공개, 댓글허용, 내용
// $author = $_POST["author"];
$title = $_POST["title"];
$type = $_POST["type"];
$comments = $_POST["comments"];
$boardContent = $_POST["boardContent"];

// 로그인 한 유저의 멤버코드 가져옴
$memberCode = $_SESSION["userCode"];

// 비공개가 체크되지 않았다면
if (empty($type)) {
    $type = "display";
}

// 댓글 허용이 체크되지 않았다면
if (empty($comments)) {
    $comments = "deny";
}

// --------------------- 파일 업로드 --------------------------

// 파일관련 정보 추출
$fileName = $_FILES["uploadFile"]["name"];
$fileTempName = $_FILES["uploadFile"]["tmp_name"];
$fileType = $_FILES["uploadFile"]["type"];
$fileSize = $_FILES["uploadFile"]["size"];
$fileError  = $_FILES["uploadFile"]["error"];

// 업로드 경로 저장
$fileUploadDir = "../usb_project/resource/postboard/";

// 제목과 내용의 쿼티션 기호를 일반 문자로 인식되도록 치환
$title = htmlspecialchars($title, ENT_QUOTES);
$boardContent = htmlspecialchars($boardContent, ENT_QUOTES);

// 파일 업로드 이상 유무 체크
if ($fileName && !$fileError) {
    // .(점)을 기준으로 문자열 분리
    $file = explode(".", $fileName);
    // 분리된 파일이름 저장
    $expFileName = $file[0];
    // 현재 날짜로 만들어진 새로운 파일명에 확장자로 사용될 변수 $fileExt에 확장자 저장
    $expFileExt = $file[1];

    // 현재 시간을 파일의 이름으로 저장 (ex : 2020-11-22 01:47:22)
    $newFileName = date("Y-m-d H:i:s");
    // 위의 새이름과 분리된 확장자를 합침
    $fakeFileName = $newFileName.".".$expFileExt;
    // 서버의 지정된 위치에 파일을 저장하기 위해 경로와 파일명을 합침
    $serverUploadFile = $fileUploadDir.$fakeFileName;
    
    // 서버에 파일을 올리는 move_uploaded_file() 함수를 실행
    if (!move_uploaded_file($fileTempName, $serverUploadFile)) {
        // 파일올리기에 실패했다면
        $result['file_Upload_Error'] = true;
    }
}

else {
    // 업로드를 실패했다면 파일 이름이 저장된 변수 초기화
    $fileName = "";
    $fileType = "";
    $fakeFileName = "";
    $result['file_Upload_Error'] = false;
}

// --------------------- DataBase INSERT --------------------------

$data = Array (
    'title' => $title,
    'm_code' => $memberCode,
    'textbox' => $boardContent,
    'date' => $db->now(),
    'type' => $type,
    'comments' => $comments,
    // 원본 파일명
    'file_name' => $fileName,
    // 파일 확장자
    'file_type' => $fileType,
    // 조합된 파일명
    'file_copied' => $fakeFileName,
);

$queryResult = $db->insert('board', $data);

$result['result_data'] = $queryResult;
$result["error"] = false;

echo json_encode($result);



