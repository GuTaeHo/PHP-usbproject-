// 스크립트가 준비되면 호출되는 함수
$(document).ready(function() {

    $.ajax({
        // getMember.php와 통신
        url: "./controller/getMember.php",
        type: "GET",
        // 받는 형식은 json 형식
        dataType: "json",
        cache: false,
        
        // 실패시 호출되는 함수
        error: function () {
            console.log('connection error...');
        },
        // 성공시 호출되는 함수
        success: function (response) {
            // class가 reFresh인 태그 초기화
            $('.reFresh').html("");

            var div = "";

            if (response['error']) {
                alert(response['msg']);
            } else {
                // response['result_data']
                // console.log(response['result_data']);
                // response배열의 0번 인덱스 (객체) 반환
                // console.log(response[0]);
                // response배열의 0번 인덱스에 id(key)에 값(value)을 반환
                // console.log(response[0].id);
                div += "<div class='form-group'><label>아이디</label>" +
                    "<input type='text' class='form-control' value='" + response[0].id + "' readonly/></div>"
                div += "<div class='form-group'><label>비밀번호</label>" +
                    "<input type='password' name='passwd' class='form-control passwd' placeholder='비밀번호 변경' onkeydown='enter()'></div>"
                div += "<div class='form-group'><label>비밀번호 확인</label>" +
                    "<input type='password' name='passwd_check' class='form-control' placeholder='비밀번호 확인' onkeydown='enter()'></div>"
                div += "<div class='form-group'><label>닉네임</label>" +
                    "<input type='text' name='nickname' class='form-control' placeholder='닉네임 변경' value='" + response[0].nickname + "' onkeydown='enter()'></div>"
                div += "<div class='form-group'><label>이름</label>" +
                    "<input type='text' name='name' class='form-control' placeholder='이름 변경' value='" + response[0].name + "' onkeydown='enter()'></div>"
                div += "<div class='form-group'><label>이메일</label>" +
                    "<input type='text' name='email' class='form-control' placeholder='이메일 변경' value='" + response[0].email + "' onkeydown='enter()'></div>"
            }
            // 태그 출력
            $('.reFresh').html(div);
        },
        // 완료시 호출되는 함수
        complete: function () {
            // 패스워드 위치에 포커스
            $('.passwd').focus();
        }
    }); // end ajax
});

// 엔터입력시 체크함수 실행
function enter() {
    // window 객체의 이벤트는 언제든 접근이 가능
    // keyCode의 반환이 13이면 Enter키를 뜻함
    if ( window.event.keyCode === 13 ) {
        // 사용자가 엔터를 입력하면 입력값 체크 함수 실행
        registCheckInput();
    }
}

// 취소 버튼이 눌렸때 호출
function cancel() {
    // 이전 화면으로
    history.back();
}

// 이메일 형식 체크 함수
function emailCheck(email) {

    // 이메일 형식에 관한 정규식
    var regEmail = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

    // tset() 메소드는 대응되는 문자열이 있는지 검사하는 정규식 관련 메소드임, true 나 false를 반환함
    if(regEmail.test(email)) {
        return true;
    } else {
        return false;
    }
}

// 패스워드 형식 체크 함수
function passCheck(password) {
    // 특수문자, 문자, 숫자 포함 형태의 8~20자리 이내의 암호 정규식
    var passReg = /^.*(?=^.{8,20}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;

    if(passReg.test(password)) {
        return true;
    } else {
        return false;
    }
}

// 정보 수정 버튼 입력시 호출되는 함수
function registCheckInput() {
    // 자바스크립트에서는 데이터 타입을 자동으로 선언해주지만, typeof 연산자를 사용하면 변수의 데이터 타입을 반환함
    // input 태그의 사용자가 입력한 값들은 모두 string형으로 저장됨

    // 사용자가 입력한 form태그 내부의 데이터를 추출
    let email = document.memberModify.email;
    let password = document.memberModify.passwd;
    let password_check = document.memberModify.passwd_check;
    let name = document.memberModify.name;
    let nickname = document.memberModify.nickname;

    console.log(email.value);
    console.log(password.value);
    console.log(password_check.value);
    console.log(name.value);
    console.log(nickname.value);


    // 다른 많은 언어와 마찬가지로 자바스크립트에서도 정규식을 지원
    // - 정규식에 관련한 예제 (https://developer.mozilla.org/ko/docs/Web/JavaScript/Guide/%EC%A0%95%EA%B7%9C%EC%8B%9D)

    if (password.value === "") {
        alert("비밀번호를 입력해주세요!!!");
        password.focus();
        return;
    } else {
        if (!passCheck(password.value)){
            alert("비밀번호는 영문, 숫자, 특수문자 포함 8 ~ 20자 사이 입니다");
            password.focus();
            return;
        }
    }

    if (password_check.value === ""){
        alert("비밀번호 확인란을 입력해주세요!!!");
        password_check.focus();
        return;
    } else {
        if (!(password_check.value === password.value)) {
            alert("비밀번호가 서로 일치하지 않습니다.");
            password_check.focus();
            return;
        }
    }

    if (name.value.length > 20){
        alert("너무 긴 이름입니다...");
        name.focus();
        return;
    }

    if (nickname.value === ""){
        alert("닉네임을 입력해주세요!!!");
        nickname.focus();
        return;
    } else {
        if (nickname.value.length > 10) {
            alert("닉네임은 10자 이내로 입력해주세요");
            nickname.focus();
            return;
        }
    }


    // email 유효성 검사 시작
    if (email.value === "") {
        // email에 포커싱
        alert("이메일을 입력해주세요!!!");
        email.focus();
        return;
    } else {
        // 대응되는 email형식이 아니라면
        if (!emailCheck(email.value)) {
            alert("이메일 형식이 잘못되었습니다");
            email.focus();
            return;
        }
    }

    // document.memberModify.submit();    // submit() 함수는 제출(넘겨줌)기능을 수행

    // ajax로 submit() 기능을 대신함
    $.ajax({
        url: "./controller/putMemberModify.php",
        type: "POST",
        // form태그에 값을 직렬화하여 putMemberModify.php로 전달
        data : $('#memberForm').serialize(),
        // 받는 형식은 json 형식
        dataType: "json",
        cache: false,
        error: function () {
            console.log('서버와 연결에 실패했습니다...');
        },
        // ajax 연결에 성공했다면, putMemberModify.php의 json으로 변환된 변수를 받아옴
        success: function (response) {
            console.log(response);

            if (response['error']) {
                alert(response['msg']);
            } else {
                console.log(response['msg']);
                // alert('정보 수정 성공! 메인 페이지로 이동합니다.');
                // location.href = '../index.php'
            }
        },
        complete: function () {

        }
    }); // end ajax
}