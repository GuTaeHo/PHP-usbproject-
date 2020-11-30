<!-- 비 로그인시 출력 -->
<?php
    if (!$_SESSION['userId']) {
?>
<!-- 콘텐츠 최상위 경고창 -->
<div class="alert alert-primary alert-dismissible fade show" role="alert">
    <strong>안녕하세요!</strong> 본 페이지는 USB 프로젝트 메인 페이지입니다.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<!-- 콘텐츠 최상위 경고창 -->
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    회원이 아니신가요? <a href="./?target=regist" class="alert-link">회원 가입</a>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php
    } else {
?>
<!-- 사용자 id 표시 O-->
<div class="current-id" onclick="idClick()">
    <p>안녕하세요</p>
    <div><?=$_SESSION['userId']?>님</div>
    <h5>현재 권한 </h5>
    <div><?=$_SESSION["userPermission"]?></div>
</div>
<?php } ?>

<h1 class="content-title">Main</h1>

<div class="content">
    <!-- 콘텐츠 부분 -->
    <!-- 사진 전환 캐러셀 적용 -->
    <div class="bd-example">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- get방식으로 usbpage 정보를 전달-->
                    <a href="./?target=usbpage"><img src="./resource/usb2.jpg" class="d-block w-100" alt="..."></a>
                    <div class="carousel-caption d-none d-md-block">
                        <h1>USB</h1>
                        <p>헷갈리는 USB에 대한 팁들을 알려드립니다.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <a href="./?target=bluetoothpage"><img src="./resource/bluetooth1.jpg" class="d-block w-100" alt="..."></a>
                    <div class="carousel-caption d-none d-md-block">
                        <h1>BlueTooth</h1>
                        <p>이제는 없어서는 안될 BlueTooth에 대해서 알려드립니다.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <a href="./?target=cablepage"><img src="./resource/cable.jpg" class="d-block w-100" alt="..."></a>
                    <div class="carousel-caption d-none d-md-block">
                        <h1>Cable</h1>
                        <p>전자기기를 사용하다보면 셀 수 없이 많은 케이블들이 있습니다.</p>
                        <p>케이블의 유형과 그에 맞는 사용법을 알려드립니다.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <!-- 캐러셀 끝 -->

</div>


