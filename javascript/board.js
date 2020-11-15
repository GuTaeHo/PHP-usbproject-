$( document ).ready(function() {
    $.ajax({
        url: "./controller/getBoard.php",
        // type: "GET",
        // data : $('#form_song_search').serialize(),
        data : {id : "asdf", pw : "qwer"},
        dataType: "json",
        cache: false,
        error: function () {
            console.log('connection error..');
        },
        // ajax 연결에 성공했다면, html 코드 생성
        success: function (response) {
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
                    tag += "<tr>";
                    // 배열의 값을 추출하여 <td>태그 내부에 적용
                    tag += "<td>" + val.b_code + "</td>";
                    tag += "<td>" + val.title + "</td>";
                    tag += "<td>" + val.nickname + "</td>";
                    tag += "<td>" + val.date + "</td>";
                    tag += "<td>" + val.viewcount + "</td>";
                    tag += "</tr>"
                });
            }

            $('#tbody').html(tag);
        },
        complete: function () {

        }
    });
});