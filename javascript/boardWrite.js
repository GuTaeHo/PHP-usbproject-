// 파일명을 boardCehckInput() 메소드에서 참조할 수 있도록 전역 변수 설정
let filename;

$(document).ready(function() {
    var fileTarget = $('.filebox .upload-hidden');
    // input file 의 값이 변경(업로드)되면 호출되는 함수
    fileTarget.on('change', function(){
        if(window.FileReader){ // modern browser
            // 파일명을 변수에 저장
            filename = $(this)[0].files[0].name;
        } else { // old IE
            filename = $(this).val().split('/').pop().split('\\').pop(); // 파일명만 추출
        }

        // 추출한 파일명 삽입
        $(this).siblings('.upload-name').val(filename);
    });
});


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

    // form 태그가 있는 경우
    // form 태그가 html에 있는경우(여기서는 create_form이라는 id로 세팅된 form 태그)
    // FormData 생성자 함수에 인자로 넘겨서 input 태그에 있는 데이터들을 따로 세팅하지 않아도 사용할 수 있다.
    var createForm = document.getElementById("boardWriteForm");
    var formData = new FormData(createForm);

    console.log(formData);

    // 게시글 비동기 게시
    $.ajax({
        url: "./controller/putBoard.php",
        type : "POST",
        // form태그의 모든 값들을 POST형식으로 보냄
        // $('#boardWriteForm').serialize(),
        data : formData,
        // input file타입의 데이터를 보내기 위해 설정
        enctype: 'multipart/form-data',
        // formData를 string으로 변환하지 않음
        processData: false,
        // content-type 헤더가 multipart/form-data로 전송되게 함
        contentType: false,
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
                alert("게시글이 등록되었습니다.");
                history.back();
            }
        },
        complete: function () {
            // 댓글 작성란 입력값 초기화
            // title.value = "";
            // boardContent.value = "";
            // 게시판 으로
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


