window.onload = function() {
    // 시간 저장 변수
    var setTime;
    var idForm = document.registForm.id;
    var id = document.getElementById("identity");
    var idCheck = document.getElementById("idCheck");
    var next = document.getElementById("next");
    
    // 페이지 로딩 완료후 아이디 입력란에 포커스
    id.focus();

    idCheck.onclick = function(){
        idCheck.style.outline='5px solid #ffffff';
    }

    id.onkeyup = function(){

        // setTimeout() 메소드를 취소
        clearTimeout(setTime);
        // setTimeout() 메소드는 함수가 실행될 시간을 설정할 수 있음
        setTimeout(function () {
            // 아이디 입력란의 글자가 6자 이하면
            if (id.value.length < 7) {
                idCheck.style.color='#ff3333';
                idCheck.style.background='#ffffff';
                idCheck.value = "아이디는 7자 이상입니다.";
                next.style.display='none';
            }
            // id가 7자 이상일때 ajax 실행
            if (id.value.length > 6) {
                $.ajax({
                    // 쿼리스트링 방식으로 getId.php에 id값 전달
                    url: "./controller/getId.php",
                    type: "GET",
                    // 객체에 id.value의 값을 실어 날림
                    // data : $('#regist_form').serialize()
                    data : {id : id.value},
                    // 받는 형식은 json 형식
                    dataType: "json",
                    cache: false,
                    error: function () {
                        console.log('connection error..');
                    },
                    // ajax 연결에 성공했다면, getId.php의 객체를 받아옴
                    success: function (response) {

                        if (response['error']) {
                            alert(response['msg']);
                        } else {

                            // 아이디 중복시, 문자열 출력 밑 가입 버튼 숨김
                            if (response['result_data_count'] > 0) {
                                idCheck.style.background='#ffb3b3';
                                idCheck.style.color='#ff3333';
                                idCheck.value = "아이디가 중복됩니다!!!";
                                next.style.display='none';

                            // 중복이 아닐경우
                            } else {
                                // 아이디가 정규식 형식에 맞을 경우
                                if (idTypeCheck(idForm.value)) {
                                    idCheck.value = "";
                                    idCheck.style.background = '#ccd9ff';
                                    idCheck.style.color = '#4d79ff';
                                    idCheck.value = "사용가능한 아이디 입니다.";
                                    next.style.display = 'block';
                                } else {
                                    idCheck.value = "";
                                    idCheck.style.background='#ffb3b3';
                                    idCheck.style.color='#ff3333';
                                    idCheck.value = "소문자 및 숫자만 넣어주세요!";
                                    next.style.display='none';
                                }
                                // 중복은 아니지만 글자가 20자가 넘을 경우
                                if (id.value.length > 20) {
                                    idCheck.style.background='#ffb3b3';
                                    idCheck.style.color='#ff3333';
                                    idCheck.value = "아이디는 20자 이하 입니다.";
                                    next.style.display='none';
                                }
                            }
                        }
                    },
                    complete: function () {

                    }
                }); // end ajax
            }
        }, 300);   // end setTimeout, 300ms 대기
    }
}



// 엔터입력시 체크함수 실행
function enter() {
    // window 객체의 이벤트는 언제든 접근이 가능
    // keyCode의 반환이 13이면 Enter키를 뜻함
    if ( window.event.keyCode === 13 ) {
        // 사용자가 엔터를 입력하면 입력값 체크 함수 실행
        registCheckInput();
    }
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

// 아이디 형식 체크 함수
function idTypeCheck(id) {
    // 영문 소문자로 시작하는 아이디, 영소문자 및 숫자만 들어감, 길이는 7 ~ 20자, 끝날때 제한 없음
    var idReg = /^[a-z]+[a-z0-9]{6,20}$/g;

    if(idReg.test(id)) {
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

// 로그인 버튼 입력시 호출되는 함수
function registCheckInput() {
    // 자바스크립트에서는 데이터 타입을 자동으로 선언해주지만, typeof 연산자를 사용하면 변수의 데이터 타입을 반환함
    // input 태그의 사용자가 입력한 값들은 모두 string형으로 저장됨
    
    // 사용자가 입력한 form태그 내부의 데이터를 추출
    var id = document.registForm.id;
    var email = document.registForm.email;
    var password = document.registForm.passwd;
    var password_check = document.registForm.passwd_check;
    var name = document.registForm.name;
    var nickname = document.registForm.nickname;

    // 자바스크립트에서 == 연산자는 (자료형에 관계없이) 값만을 비교함, 자동으로 형을 변환하여 비교하기 때문
    // ex) 0 == "0" 은 true의 결과를 반환

    // === 연산자는 자료형에 엄격하기 때문에 값과 형 모두를 비교함, 자동으로 형 변환을 하지 않음
    // ex) 0 === "0" 은 false의 결과를 반환

    // 따라서 의도치 않은 결과가 생기지 않도록 === 연산자를 권장

    // 다른 많은 언어와 마찬가지로 자바스크립트에서도 정규식을 지원
    // - 정규식에 관련한 예제 (https://developer.mozilla.org/ko/docs/Web/JavaScript/Guide/%EC%A0%95%EA%B7%9C%EC%8B%9D)

    if (id.value === "") {
        alert("아이디를 입력해주세요!!!");
        id.focus();
        return;
    } else {
        if (!idTypeCheck(id.value)){
            alert("아이디는 소문자로 시작, 7 ~ 20자 사이 입니다");
            id.focus();
            return;
        }
    }
    
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

    // document.registForm.submit();    // submit() 함수는 제출(넘겨줌)기능을 수행

    // ajax로 submit() 기능을 대신함
    $.ajax({
        url: "./controller/putRegist.php",
        type: "POST",
        // form태그에 값을 직렬화하여 putRegist.php로 전달
        data : $('#regist_form').serialize(),
        // 받는 형식은 json 형식
        dataType: "json",
        cache: false,
        error: function () {
            console.log('서버와 연결에 실패했습니다...');
        },
        // ajax 연결에 성공했다면, putRegist.php의 json으로 변환된 변수를 받아옴
        success: function (response) {
            console.log(response);

            if (response['error']) {
                alert(response['msg']);
            } else {
                alert('회원가입 성공! 로그인 페이지로 이동합니다.');
                location.href = '../index.php?target=login'
            }
        },
        complete: function () {

        }
    }); // end ajax
}

// 취소 버튼이 눌렸때 호출
function cancel() {
    // 이전 화면으로
    history.back();
}


