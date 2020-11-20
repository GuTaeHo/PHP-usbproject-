
$( document ).ready(function() {
    // 글 번호 저장 변수
    let tableNum = 0;
    $.ajax({
        url: "./controller/getBoard.php",
        // post 방식으로 전송
        type: "POST",
        // getBoard에서 어느 페이지로 부터 요청인지 알기 위한 data 객체
        data : {pageDivide : 100},
        dataType: "json",
        cache: false,
        error: function () {
            console.log('connection error..');
        },
        // ajax 연결에 성공했다면, html 코드 생성
        success: function (response) {
            // db의 게시글 갯수를 반환한 결과값을 변수에 저장
            tableNum = response['board_count'];
            console.log(response);
            // tbody 내부의 html 초기화
            $('#tbody').html("");
            // html 태그들이 들어갈 tag 변수 초기화
            var tag = "";

            // getBoard.php에서 db에 정상적으로 입/출력이 완료되었다면
            // result['error'] 배열에 false의 값이 저장되어 있음
            // 즉 else 문을 실행하여 each() 메소드 실행
            if (response['error']) {
                alert(response['msg']);
            } else {
                // each() 메서드는 첫 번째 인자로 배열이나 유사 배열형식인 객체를 받음
                // 두 번째 인자로 콜백 함수를 받으며
                // 콜백 함수의 첫 번째 인자는 배열의 인덱스 번호, 두 번째 인자는 해당 위치의 값을 의미함
                // getBoard.php의 sql문이 저장된 response['result_data'] 배열에 키, 값을 통해 레코드를 가져옴
                $.each(response['result_data'], function (key, val) {

                    // 게시판 글 클릭시 boardView.php에게 get 방식으로 게시판 글 번호 전달
                    tag += "<tr onclick='viewPage(" + val.b_code + "," + val.viewcount + ")'>";
                    
                    // 배열의 값을 추출하여 <td>태그 내부에 적용
                    tag += "<td>" + tableNum + "</td>";
                    tag += "<td>" + val.title + "</td>";
                    tag += "<td>" + val.nickname + "</td>";
                    tag += "<td class='writeDate'>" + val.date + "</td>";
                    tag += "<td class='viewCount'>" + val.viewcount + "</td>";
                    tag += "</tr>"
                    // 글 번호 줄임
                    --tableNum;
                });
            }

            $('#tbody').html(tag);
        },
        complete: function () {

        }
    });
});

// 게시글 클릭 시 페이지 이동과 동시에 게시글 번호, 조회수 get 방식으로 전달
function viewPage(boardCode, viewCount) {
    location.href='../?target=boardView&boardCode=' + boardCode + '&viewCount=' + viewCount;
}