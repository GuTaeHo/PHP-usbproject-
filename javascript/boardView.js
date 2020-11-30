// 쿼리스트링 저장 변수
let urlParams;

// replaceAll prototype 선언
// 응답받은 페이지의 문자열을 치환하기 위한 함수 선언 (치환 대상, 바뀔 문자)
String.prototype.replaceAll = function(org, dest) {
    return this.split(org).join(dest);
}

// 댓글 허용 문자열을 저장하는 변수


$( document ).ready(function() {
    let commentAllow = "";
    // 게시글을 가져오는 함수
    commentAllow = getBoardNum();
    // comments 컬럼의 값이 allow면 댓글 가져옴
    if (commentAllow === "allow") {
        // 댓글을 가져오는 함수
        getBoardComment();
        // comments 컬럼의 값이 deny라면
    } else {
        // class 하위에 태그 찾기
        let commentContainer = document.getElementById('commentContainer');
        let hiddenContents = document.getElementsByClassName('hiddenContents');
        let writeButton = document.getElementsByClassName('writeButton');

        for (let i = 0; i < commentContainer.length; i += 1){
            commentContainer[i].style.background='#ffffff';
        }

        for (let i = 0; i < hiddenContents.length; i += 1){
            hiddenContents[i].style.display='block';
            hiddenContents[i].style.fontSize='24px';
        }

        for (let i = 0; i < writeButton.length; i += 1) {
            writeButton[i].style.display='none';
        }
    }
});

// 게시글을 가져오는 함수
function getBoardNum(){
    // 쿼리스트링 가져옴
    urlParams = getUrlParams();

    let saveCommentAllow = "";

    // 비동기 게시글 정보 출력
    $.ajax({
        url: "./controller/getBoardNum.php",
        type : "GET",
        // get 방식으로 urlParams에 boardCode와 viewCount의 키, 값을 getboardNum.php에 넘겨줌
        data : { "boardCode": urlParams.boardCode, "viewCount" : urlParams.viewCount},
        dataType: "json",
        // return 시 값을 받기위해 success후 동기 방식으로 전환
        async: false,
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

            // db의 comments컬럼의 값을 변수에 저장

            // getBoard.php에서 db에 정상적으로 입/출력이 완료되었다면
            // result['error'] 배열에 false의 값이 저장되어 있음
            // 즉 else 문을 실행하여 each() 메소드 실행
            if (response['error']) {
                alert(response['msg']);
            } else {
                // each() 메서드는 첫 번째 인자로 배열이나 유사 배열형식인 객체를 받음, 두 번째 인자로 콜백 함수를 받으며
                // 콜백 함수의 첫 번째 인자는 배열의 인덱스 번호, 두 번째 인자는 해당 위치의 값을 의미함
                // getBoard.php의 sql문이 저장된 response['result_data'] 배열에 키, 값을 통해 레코드를 가져옴
                // 게시글 내용 변수에 저장
                let textBox = response['result_data']['textbox'];
                // 내용의 \n기호를 html 줄바꿈 기호로 치환
                textBox = textBox.replaceAll("\n", "<br>");

                div += "<div>" + response['result_data']['title'] + "</div>"
                div += "<div>" + response['result_data']['date'] + "</div>"
                div += "<div>" + response['result_data']['nickname'] + "</div>"
                div += "<div>조회수 " + response['result_data']['viewcount'] + "</div>"
                if (response['result_data']['file_name']) {
                    div += "<div class='fileImage'><img src='../resource/postboard/" + response['result_data']['file_name'] + "'/></div>"
                }
                div += "<div>" + textBox + "</div>"

                saveCommentAllow = response['result_data']['comments'];
            }
            $('.reFresh').html(div);
        },
        complete: function () {
        }
    }); // end ajax

    // 댓글 허용 정보 반환
    return saveCommentAllow;
}

// 댓글을 가져오는 함수
function getBoardComment() {
    let reFreshCommentNode = document.getElementById('commentNode');
    
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

            $('.reFreshComment').css("background", "#ffffff");
            // html 태그들이 들어갈 tag 변수 초기화
            var div = "";

            // getBoard.php에서 db에 정상적으로 입/출력이 완료되었다면
            // result['error'] 배열에 false의 값이 저장되어 있음
            // 즉 else 문을 실행하여 each() 메소드 실행
            if (response['error']) {
                alert(response['msg']);

            } else {
                let i = 0;
                // comment테이블의 기본키 저장 배열
                // 각각의 고유번호, 경고수 를 배열로 저장
                let commentCode = new Array();
                let cautionNum = new Array();

                // each() 메서드는 첫 번째 인자로 배열이나 유사 배열형식인 객체를 받음, 두 번째 인자로 콜백 함수를 받으며
                // 콜백 함수의 첫 번째 인자는 배열의 인덱스 번호, 두 번째 인자는 해당 위치의 값을 의미함
                // getBoard.php의 sql문이 저장된 response['result_data'] 배열에 키, 값을 통해 레코드를 가져옴
                $.each(response['result_data'], function (key, val) {
                    // 배열에 첫 번째 댓글의 고유 번호와 경고 수를 순차적으로 저장
                    commentCode[i] = val.c_code;
                    cautionNum[i] = val.caution;
                    switch (val.type) {
                        case 0 :
                            div += "<div class='subCommentContainer'>"
                            div += "<div>" + val.nickname + "</div>"
                            div += "<div>" + val.date + "</div>"
                            div += "<div class='cautionContainer'>" +
                                val.caution + "&nbsp<img src='../resource/warning.png' class='cautionImage' onclick='cationClicked(" + i + "," + commentCode[i] + ", " + cautionNum[i] + ")'/>" +
                                "</div>"
                            div += "<div>" + val.comment + "</div>"
                            div += "</div>"
                            ++i;
                            break;

                        case -1 :
                            div += "<div class='subCommentContainer'>"
                            div += "<div>" + val.nickname + "</div>"
                            div += "<div>" + val.date + "</div>"
                            div += "<div class='cautionDelete'>신고가 누적되어 삭제된 댓글 입니다.</div>"
                            div += "</div>"
                            ++i;
                            break;

                        case -2 :
                            div += "<div class='subCommentContainer'>"
                            div += "<div>" + val.nickname + "</div>"
                            div += "<div>" + val.date + "</div>"
                            div += "<div class='adminDelete'>관리자에 의해 삭제된 댓글 입니다.</div>"
                            div += "</div>"
                            ++i;
                            break;
                    }
                });
            }

            $('.reFreshComment').html(div);
        },
        complete: function () {
            // id가 commentNode인 자식의 개수 콘솔에 출력
            // console.log(reFreshCommentNode.childElementCount);
            // 자식이 아무도 없다면
            if (reFreshCommentNode.childElementCount === 0) {
                reFreshCommentNode.style.background='#f2f2f2';
                reFreshCommentNode.style.boxShadow='none';
            }
        }
    }); // end ajax
}

// 신고 버튼이 클릭 될 때마다 호출되는 함수
// 매개 변수로 몇번 댓글인지 구별하는 i와 댓글 기본키, 댓글의 경고 수가 들어옴
function cationClicked(i, commentCode, caution) {
    let cautionImage = document.getElementsByClassName('cautionImage');

    if (confirm("이 댓글을 신고하시겠습니까?")) {
        // 비동기 댓글 신고 기능 수행
        $.ajax({
            url: "./controller/putCautionUpdate.php",
            type : "POST",
            // POST 방식으로 게시글 번호와, 댓글 고유값(댓글 테이블 기본키), 경고수 전달
            data : { "boardCode": urlParams.boardCode, "commentCode" : commentCode, "caution" : caution},
            dataType: "json",
            cache: false,
            error: function () {
                console.log("connection error ...");
            },
            // ajax 연결에 성공했다면
            success: function (response) {
                console.log(response);
                if (response['error']) {
                    alert(response['msg']);
                } else {
                    //console.log(response);
                    alert("댓글이 신고되었습니다.");
                    // 댓글 비동기 새로고침
                    getBoardComment();
                }
            },
        }); // end ajax
        // 이미지 변경
        cautionImage[i].src = '../resource/warningClicked.png';
    } else {
        // cautionImage[i].src = '../resource/warning.png';
    }
}

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
                alert("게시 완료!");
                // console.log(response['result_data']);
            }

        },
        complete: function () {
            // 댓글 작성란 입력값 초기화
            inputText.value = "";
            // 댓글 비동기 새로고침
            getBoardComment();
        }
    }); // end ajax
}

// 엔터입력시 체크함수 실행
function enter() {
    // window 객체의 이벤트는 언제든 접근이 가능
    // keyCode의 반환이 13이면 Enter키를 뜻함
    if ( window.event.keyCode === 13 ) {
        commentFormSubmit();
    }
}