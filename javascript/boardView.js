// 쿼리스트링 저장 변수
let urlParams;

$( document ).ready(function() {

    // 쿼리스트링 가져옴
    urlParams = getUrlParams();


    // 비동기 게시글 정보 출력
    $.ajax({
        url: "./controller/getBoardNum.php",
        type : "GET",
        // get 방식으로 urlParams에 boardCode와 viewCount의 키, 값을 getboardNum.php에 넘겨줌
        data : { "boardCode": urlParams.boardCode, "viewCount" : urlParams.viewCount},
        dataType: "json",
        cache: false,
        error: function () {
            console.log('connection error..');
        },
        // ajax 연결에 성공했다면, html 코드 생성
        success: function (response) {
            // tbody 내부의 html 초기화
            $('.reFresh').html("");
            // html 태그들이 들어갈 tag 변수 초기화
            var div = "";

            // getBoard.php에서 db에 정상적으로 입/출력이 완료되었다면
            // result['error'] 배열에 false의 값이 저장되어 있음
            // 즉 else 문을 실행하여 each() 메소드 실행
            if (response['error']) {
                alert(response['msg']);

            } else {
                console.log(urlParams.boardCode);
                console.log(response['result_data']);
                // each() 메서드는 첫 번째 인자로 배열이나 유사 배열형식인 객체를 받음, 두 번째 인자로 콜백 함수를 받으며
                // 콜백 함수의 첫 번째 인자는 배열의 인덱스 번호, 두 번째 인자는 해당 위치의 값을 의미함
                // getBoard.php의 sql문이 저장된 response['result_data'] 배열에 키, 값을 통해 레코드를 가져옴
                $.each(response['result_data'], function (key, val) {
                    div += "<label>글번호</label>" +
                        "<div>" + val.b_code + "</div>"
                    div += "<label>제목</label>" +
                        "<div>" + val.title + "</div>"
                    div += "<label>작성자</label>" +
                        "<div>" + val.nickname + "</div>"
                    div += "<label>작성일</label>" +
                        "<div>" + val.date + "</div>"
                    div += "<label>조회수</label>" +
                        "<div>" + val.viewcount + "</div>"
                    div += "<label>게시글</label>" +
                        "<div>" + val.textbox + "</div>"
                });
            }

            $('.reFresh').html(div);
        },
        complete: function () {

        }
    }); // end ajax

    // 비동기 댓글 출력
    $.ajax({
        url: "./controller/getBoardComment.php",
        type : "GET",
        // get 방식으로 urlParams에 boardCode의 키, 값을 getboardNum.php에 넘겨줌
        data : { "boardCode": urlParams.boardCode},
        dataType: "json",
        cache: false,
        error: function () {
            console.log('connection error..');
        },
        // ajax 연결에 성공했다면, html 코드 생성
        success: function (response) {
            // tbody 내부의 html 초기화
            $('.reFreshComment').html("");
            // html 태그들이 들어갈 tag 변수 초기화
            var div = "";

            // getBoard.php에서 db에 정상적으로 입/출력이 완료되었다면
            // result['error'] 배열에 false의 값이 저장되어 있음
            // 즉 else 문을 실행하여 each() 메소드 실행
            if (response['error']) {
                alert(response['msg']);

            } else {
                console.log(urlParams.boardCode);
                console.log(response['result_data']);
                // each() 메서드는 첫 번째 인자로 배열이나 유사 배열형식인 객체를 받음, 두 번째 인자로 콜백 함수를 받으며
                // 콜백 함수의 첫 번째 인자는 배열의 인덱스 번호, 두 번째 인자는 해당 위치의 값을 의미함
                // getBoard.php의 sql문이 저장된 response['result_data'] 배열에 키, 값을 통해 레코드를 가져옴
                $.each(response['result_data'], function (key, val) {
                    div += "<div class='subCommentContainer'>"
                    div += "<div>" + val.nickname + "</div>"
                    div += "<div>" + val.date + "</div>"
                    div += "<div>" + val.comment + "</div>"
                    div += "</div>"
                });
            }

            $('.reFreshComment').html(div);
        },
        complete: function () {

        }
    }); // end ajax
});

// url 주소의 쿼리 스트링을 들고오기 위한 함수 
function getUrlParams() {
    var params = {};
    window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) { params[key] = value; });
    return params;
}

// 댓글 쓰기 버튼이 눌리면 호출
function showCommentForm() {
    let commentWrite= document.getElementsByClassName('commentWrite');
    let commentForm = document.getElementsByClassName('commentForm');
    for (let i = 0; i < commentWrite.length; i++) {
        // 댓글 달기 버튼 숨기기
        commentWrite[i].style.display = 'none';
    }

    for (let i = 0; i < commentForm.length; i++) {
        // 댓글 양식 보이기
        commentForm[i].style.display = 'block';
    }
}

// 댓글 작성의 다음 버튼이 눌리면 호출되는 함수
function commentFormSubmit() {
    let inputText = document.boardCommentSubmitForm.commentTyping;
    var session = document.boardCommentSubmitForm.sessionPost;

    if (inputText.value === "") {
        alert("댓글을 입력해 주세요!");
        return;
    }

    if (inputText.length > 50){
        alert("50자 이하로 작성해 주세요!!!");
        return;
    }


    // inputText.value="";

     // document.boardCommentSubmitForm.submit();

    // 비동기 댓글 게시
    $.ajax({
        url: "./controller/putBoardComment.php",
        type : "POST",
        // POST 방식으로 urlParams에 boardCode의 키, 값을 getboardComment.php에 넘겨줌
        data : { "boardCode": urlParams.boardCode, "comment": inputText.value, "sessionPost" : session.value},
        dataType: "json",
        cache: false,
        error: function () {
            console.log('connection error..');
        },
        // ajax 연결에 성공했다면, html 코드 생성
        success: function (response) {
            // getBoard.php에서 db에 정상적으로 입/출력이 완료되었다면
            // result['error'] 배열에 false의 값이 저장되어 있음
            // 즉 else 문을 실행하여 each() 메소드 실행
            if (response['error']) {
                alert(response['msg']);

            } else {
                console.log(response['result_data']);
            }

        },
        complete: function () {
            // 댓글 작성란 입력값 초기화
            inputText.value = "";
        }
    }); // end ajax
}

// 엔터입력시 체크함수 실행
function enter() {
    // window 객체의 이벤트는 언제든 접근이 가능
    // keyCode의 반환이 13이면 Enter키를 뜻함
    if ( window.event.keyCode === 13 ) {
        commentFormSubmit();
        alert("게시 완료!");
    }
}