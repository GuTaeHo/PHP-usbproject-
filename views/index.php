<!-- 비 로그인시 출력 -->
<?php
    session_start();
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
    }
?>

<h1 class="content-title">Main Page</h1>

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
                        <h1>USB?</h1>
                        <p>Universal Serial Bus의 준말로 범용 직렬 버스를 의미합니다.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <a href="./?target=wifipage"><img src="./resource/wifi1.jpg" class="d-block w-100" alt="..."></a>
                    <div class="carousel-caption d-none d-md-block">
                        <h1>WIFI?</h1>
                        <p>와이파이는 전자기기들이 무선랜(WLAN)에 연결할 수 있게 하는 기술입니다. </p>
                    </div>
                </div>
                <div class="carousel-item">
                    <a href="./?target=bluetoothpage"><img src="./resource/bluetooth1.jpg" class="d-block w-100" alt="..."></a>
                    <div class="carousel-caption d-none d-md-block">
                        <h1>BlueTooth?</h1>
                        <p>근거리 무선통신기술. 여러가지 전자제품의 무선규격을 통일시키자는 의도로 <br>기술의 이름을 블루투스로 제정했습니다.</p>
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

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">제목 영역</h1>
            <p class="lead font-weight-normal">콘텐츠 영역</p>
            <a class="btn btn-outline-secondary" href="#">Coming soon</a>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>

    <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
        <div class="col-md-5 p-lg-5 mx-auto my-5">
            <h1 class="display-4 font-weight-normal">제목 영역</h1>
            <p class="lead font-weight-normal">콘텐츠 영역</p>
            <a class="btn btn-outline-secondary" href="#">Coming soon</a>
        </div>
        <div class="product-device shadow-sm d-none d-md-block"></div>
        <div class="product-device product-device-2 shadow-sm d-none d-md-block"></div>
    </div>
</div>


