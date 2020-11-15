// 페이지 로드 완료시 아이디 입력란에 포커스
window.onload = function() {
    var id = document.loginForm.id;
    id.focus();
}

// 엔터키가 눌리면 함수 실행
function pressEnter(){
    loginCheckInput();
}


function loginCheckInput() {
    var id = document.loginForm.id;
    var passwd = document.loginForm.passwd;

    if (id.value === ""){
        alert("아이디를 입력해 주세요!");
        id.focus();
        return
    }

    if (passwd.value === ""){
        alert("비밀번호를 입력해 주세요!");
        passwd.focus();
        return
    }
    document.loginForm.submit();
}

// 취소 버튼이 눌렸때 호출
function cancel() {
    // 홈 화면으로
    location.href = '../index.php';
}