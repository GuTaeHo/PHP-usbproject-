<?php
// $_SERVER 변수의 인자 'HTTP_HOST'는 현재 url주소의 도메인 명을 반환
$SERVER_URL = "http://".$_SERVER['HTTP_HOST'];

define('_DS_', DIRECTORY_SEPARATOR);

define('_SYS_', realpath(dirname(__FILE__)._DS_)); // system directory

define('_CONFIG_', _SYS_._DS_.'config'._DS_);
define('_VIEWS_', _SYS_._DS_.'views'._DS_);
define("_JS_", _SYS_._DS_."js"._DS_);

// DB 서버 접속에 필요한 정보 상수화
define('_MYSQL_HOST_',      'localhost');
define('_MYSQL_USER_',      'usbproject');
define('_MYSQL_PASSWORD_',  'usbproject1!');
define('_MYSQL_DB_',        'usbproject');

// 같은 파일 한번만 포함, 포함할 파일이 없다면 밑의 코드는 실행 x
// db 라이브러리를 실행하기 전 초기화
require_once (_CONFIG_."MysqliDb.php");

// mysql 접속 객체를 생성하여 변수에 할당
$mysqli = new mysqli (_MYSQL_HOST_, _MYSQL_USER_, _MYSQL_PASSWORD_, _MYSQL_DB_);
// db와 연결
$db = new MysqliDb ($mysqli);

// 세션 시작
session_start();
