<?php
// login.php에서 정상적으로 로그인을 했다면 세션에 값이 들어있음
session_start();
?>

<div id="header" onscroll="">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
        <a class="navbar-brand" href="?target=index">HOME</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02"
                aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation" onclick="dropDown()">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="?target=usbpage">USB<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?target=bluetoothpage">Bluetooth</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?target=wifipage">WIFI</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?target=cablepage">Cable</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?target=board">Board</a>
                </li>
                <li class="nav-item dropdown" id="">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#"
                       role="button" aria-haspopup="true" aria-expanded="false" >Member</a>
                    <div class="dropdown-menu">

                        <!-- 비로그인 상태일 경우-->
                        <?php if (!$_SESSION["userId"]) {?>
                        <a class="dropdown-item" href="./?target=regist">회원가입</a>
                        <a class="dropdown-item" href="./?target=login">로그인</a>

                        <!-- 로그인 상태일 경우-->
                        <?php } else {?>
                            <!-- 회원 정보 수정이 눌리면 getMember.php로 이동한 뒤, session을 통해 userId를 가져온 뒤,
                                    json형식으로 레코드 반환후, memberModify.php로 이동-->
                        <a class="dropdown-item" href="./?target=memberModify">회원 정보 수정</a>
                        <a class="dropdown-item" href="./?target=logout">로그아웃</a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./?target=etc">기타</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</div>