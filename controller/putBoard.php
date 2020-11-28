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

// 문자열 랜덤 생성 함수 ($length변수의 값만큼 랜덤한 문자열 생성)
function generateRandomString($length = 7){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// 파일 이름을 랜덤으로 생성해서 DB에 있는지 확인 한 후에 중복된 값이 존재 하면
// 다시 재생성 해주는 함수
function getFileName($ext, $db) {
    do {
        $randomStringResult = generateRandomString();

        // 현재 시간을 변수에 저장 ex : 20201122014722
        $currentDate = date("YmdHis");
        // 날짜 + 랜덤 문자열 + 확장자로 새로운 파일명 생성 ex : 7bA92FW
        $serverUploadFile = $currentDate . "_" . $randomStringResult . "." . $ext;

        // db에 중복되는 값이 있는지 확인
        $db->where('file_name', $serverUploadFile);
        $db->get('board');

        // 조회된 레코드의 갯수 가져오기
        $count = $db->count;
    // DB에 중복되는 값이 있다면 재생성
    } while ($count != 0);

    return $serverUploadFile;
}

// 제목, 비공개, 댓글허용, 내용
// $author = $_POST["author"];
$title = $_POST["title"];
$type = $_POST["type"];
$comments = $_POST["comments"];
$boardContent = $_POST["boardContent"];

// 로그인 한 유저의 멤버코드 가져옴
$memberCode = $_SESSION["userCode"];

// --------------------- 파일 업로드 --------------------------

// 파일관련 정보 추출
$fileName = $_FILES["uploadFile"]["name"];
$fileTempName = $_FILES["uploadFile"]["tmp_name"];
$fileType = $_FILES["uploadFile"]["type"];
$fileSize = $_FILES["uploadFile"]["size"];
$fileError  = $_FILES["uploadFile"]["error"];

// --------------------- DataBase INSERT --------------------------

$data = Array (
    'title' => $title,
    'm_code' => $memberCode,
    'textbox' => $boardContent,
    'date' => $db->now(),
);

// 댓글 허용 여부 설정
$data['comments'] = isset($comments) ? "allow" : "deny";

// 비공개 글 설정
$data['type'] = isset($type) ? 1 : 0;

// 파일이 존재할 경우 아래 로직 실행
if ($fileSize > 0) {
    // 파일에 오류가 있을 경우 로직 종료
    if ($fileError) {
        $result['error'] = true;
        $result['msg'] = "파일 업로드 에러 에러코드 : ".$fileError;
        echo json_encode($result);
        exit;
    }

    // 파일 확장자 가져오기
    $ext = substr($fileName, strrpos($fileName, '.') + 1);
    $allowExtension = array('bmp', 'jpg', 'gif', 'png', 'jpeg');

    // 업로드 된 파일의 확장자가 $allowExtension의 배열의 값과 일치하지 않는다면 로직 종료
    if(!in_array($ext, $allowExtension)) {
        $result['error'] = true;
        $result['msg'] = "그림파일만 업로드 가능합니다.";
        echo json_encode($result);
        exit;
    }

//     파일 업로드
//    $upload_directory = _DS_."wwwfile"._DS_."usbProject"._DS_."postboard";
    $upload_directory = "../resource/postboard/";

    // 해당 경로가 유효한지(존재 하는지) 검사
    if (!is_dir($upload_directory)) {
        $result['error'] = true;
        $result['msg'] = "파일 업로드 경로가 유효하지 않습니다.";
        echo json_encode($result);
        exit;
    }

    // 해당 경로에 파일 쓰기가 가능한지 검사
    if (!is_writable($upload_directory)) {
        $result['error'] = true;
        $result['msg'] = "파일 업로드 경로에 쓰기 권한이 유효하지 않습니다.";
        echo json_encode($result);
        exit;
    }

    // 파일 이름 생성
    $serverUploadFile = getFileName($ext, $db);
    // 최종 업로드 경로&파일이름
    $fullPath = $upload_directory . $serverUploadFile;

    // 파일 업로드 로직
    if (move_uploaded_file($fileTempName, $fullPath)) {
        $data['file_type'] = $fileType;
        $data['file_name'] = $serverUploadFile;
    } else {
        $result['error'] = true;
        $result['msg'] = "파일이 업로드 되지 않았습니다.";
        echo json_decode($result);
        exit;
    }
}

// DB에 정보 insert
if ($queryResult = $db->insert('board', $data)) {
    $result['result_data'] = $queryResult;
} else {
    $result['msg'] = "게시글 쓰기에 실패하였습니다.\n\n".$db->getLastError();
    $result["error"] = true;
}

$result['msg'] = "success";
$result['error'] = false;

echo json_encode($result);