// 상태 저장 변수
let toggle = 0;

// 세션 id박스가 눌리면 호출되는 함수
function idClick() {

    let currentID = document.getElementsByClassName('current-id');

    if (toggle === 0) {
        for (let i = 0; i < currentID.length; i += 1) {
            currentID[i].style.opacity = '0.25';
        }
        toggle = 1;
    } else {
        for (let j = 0; j < currentID.length; j += 1) {
            currentID[j].style.opacity = '1';
        }
        toggle = 0;
    }

    // 위의 for문의 코드를 jQuery를 사용하면 다음과 같음
    // $('.current-id').css('opacity','0.25');
}
