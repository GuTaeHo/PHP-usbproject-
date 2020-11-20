// 취소 버튼이 눌렸때 호출
function cancel() {
    // 이전 화면으로
    history.back();
}

// 게시 버튼이 눌렸을 때 호출
function boardCheckInput() {
    let title = document.getElementById('inputTitle');
    let boardContent = document.getElementById('boardContent');


    if (title.value === "") {
        alert("제목을 입력해 주세요!!!");
        title.focus();
        return;
    }

    if (boardContent.value === "") {
        alert("내용을 입력해 주세요!!!");
        boardContent.focus();
        return;
    } else {
        if (boardContent.value.length > 1000) {
            alert("글 내용은 1000자 이하로 작성해 주세요!!!");
            boardContent.focus();
            return;
        }
    }


    // 비동기 댓글 게시
    $.ajax({
        url: "./controller/putBoard.php",
        type : "POST",
        // form태그 하위의 input에 모든 값들을 POST형식으로 보냄
        data : $("#boardWriteForm").serialize(),
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
                alert("ajax 연결 성공, db 연결 실패");
            } else {
                console.log(response);
            }

        },
        complete: function () {
            // 댓글 작성란 입력값 초기화
            title.value = "";
            boardContent.value = "";
            // 게시판 으로
            history.back();
        }
    }); // end ajax
}

// 글자수 카운팅 및 출력 메소드
$('#boardContent').keyup(function (e){
    // 키보드가 눌릴 때 마다 boardContent의 값 가져와서 변수에 저장
    var content = $(this).val();
    // counter의 태그 내용물 갱신
    $('.counter').html(content.length+" / 1000");    //글자수 실시간 카운팅

    if (content.length >= 1000){
        alert("최대 1000자까지 입력 가능합니다.");
        $(this).val(content.substring(0, 1000));
        $('#counter').html("(1000 / 1000자)");
    }
});
