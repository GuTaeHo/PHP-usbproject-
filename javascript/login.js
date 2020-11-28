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
    // document.loginForm.submit();

    $.ajax({
        url : "./controller/getLogin.php",
        data : $("#loginForm").serialize(),
        type : "POST",
        dataType: "json",
        // 갱신된 데이터를 받아올 수 있도록 캐싱 false
        cache: false,
        error: function() {
            console.log('connection error..');
        },

        success: function(response) {
            console.log(response['captcha_error']);
            console.log(response['error']);
            // 관리자에 의해 삭제가 되지 않았다면
            if (response['deleted_user'] !== true) {
                if (response['error']) {
                    alert('로그인 완료');
                    // 메인 페이지로
                    location.href = '../index.php';
                } else {
                    alert('아이디 또는 패스워드가 다릅니다!!!');
                    location.href = '../index.php?target=login';
                }
            // 삭제되었다면
            } else {
                alert('관리자에 의해 삭제된 회원입니다.');
                location.href = '../index.php?target=login';
            }
        },
    }); // end ajax
}

// 취소 버튼이 눌렸때 호출
function cancel() {
    // 홈 화면으로
    location.href = '../index.php';
}

// reCaptcha 기능 함수
grecaptcha.ready(function() {
    grecaptcha.execute('6Lfe0eUZAAAAAIOuKccP5Osv1UjoUmWEULFXpLTC', {action: 'login'})
        .then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
});