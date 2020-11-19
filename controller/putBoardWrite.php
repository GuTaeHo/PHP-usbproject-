<?php
// db와의 연동을 위해 app.php (같은 파일을 한번만) 포함
require_once "../app.php";

/**
 * 본 파일은 boardWrite.php 의 글쓰기 버튼이 눌리면 넘어오는 값을
 * db의 board테이블에 INSERT하는 기능을 가지며, json형식으로 에러 결과를 반환함
 */