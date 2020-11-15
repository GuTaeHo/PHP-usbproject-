window.__scrollPosition = document.documentElement.scrollTop || 0;

// 스크롤시 이벤트. addEventListener() 메소드는 자바스크립트에서 이벤트를 등록할때 가장 권장되는 방식
document.addEventListener('scroll', function() {
    let _documentY = document.documentElement.scrollTop;
    let _direction = _documentY - window.__scrollPosition >= 0 ? 1 : -1;
    console.log(_documentY); // 현재 스크롤 위치 출력
    // console.log(_direction); // 콘솔창에 스크롤 방향을 출력

    window.__scrollPosition = _documentY; // Update scrollY

    var header = document.getElementById('header');



    // 스크롤 위치가 75px 이하라면
    if (_documentY < 75) {

        header.style.top='-0px';
    // 스크롤 위치가 75px 이상이라면
    } else {
        // 아래로 스크롤 되면
        if (_direction === 1) {
            header.style.top='-75px';
        } else {
            header.style.top='0px';
        }
    }

});


var navvar = document.getElementById('navbar');
var dropDownMenu = document.getElementsByClassName('dropdown-menu');
var temp = 1;

// (스마트폰에서) 메뉴 토글 버튼이 눌리면 호출되는 함수
function dropDown() {
    // 불투명하게
    if (temp === 1) {
        navvar.style.opacity = '1';
        temp = 0;
    // 원래대로
    } else {
        navvar.style.opacity = '0.7';
        temp = 1;
    }
}