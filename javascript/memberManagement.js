// 윈도우가 준비되면 호출되는 콜백 함수
window.onload = function () {

    // 회원 정보 가져오고, html형식으로 레코드 출력
    getMemberResult();
    // 게시글 정보 가져오고, html형식으로 레코드 출력
    getBoardResult();
    // 댓글 정보 가져오고, html형식으로 레코드 출력
    getCommentResult();
}

// 회원 정보를 가져오는 함수
function getMemberResult() {
    // 글 번호 저장 변수
    let tableNum = 0;

    $.ajax({
        url : "./controller/getAllMembers.php",
        dataType: "json",
        // 갱신된 데이터를 받아올 수 있도록 캐싱 false
        cache: false,
        error: function () {
            console.log('connection error..');
        },

        success: function(response) {
            if (response['error']) {
                alert('DB 연결에 문제가 생겼습니다...');
            } else {
                console.log(response);
                tableNum = response['member_count'];

                // reFreshMember하위의 html엘리먼트 초기화
                $('.reFreshMember').html("");
                // html 태그를 저장할 변수 선언
                var tag = "";

                // each 콜백 함수를 사용하여 배열에 값이 없을 때 까지 반복
                $.each(response['result_data'], function (key, val) {
                    // 권한에 따라 다른 문자열을 출력하기위한 변수 선언
                    let permissionString = val.permission;
                    tag += "<tr>";
                    // 배열의 값을 추출하여 <td>태그 내부에 적용
                    switch (val.permission) {
                        case 1:
                            permissionString = '일반사용자';
                            break;
                        case 2:
                            permissionString = '우수사용자';
                            break;
                        case 3:
                            permissionString = '매니저';
                            break;
                        case 4:
                            permissionString = '관리자';
                            break;
                        default : permissionString = "???";
                    }
                    tag += "<td>" + permissionString + "&nbsp(" + val.permission + ")</td>";
                    tag += "<td>" + val.id + "</td>";
                    tag += "<td>" + val.password + "</td>";
                    tag += "<td>" + val.nickname + "</td>";
                    tag += "<td>" + val.name + "</td>";
                    tag += "<td>" + val.email + "</td>";
                    tag += "<td>" + val.date + "</td>";
                    tag += "</tr>"
                    // 글 번호 줄임
                    --tableNum;
                });
            }
            $('.reFreshMember').html(tag);
        },

        complete: function(response) {

        }
    }); // end ajax
}


// 게시글을 가져오는 함수
function getBoardResult() {
    // 글 번호 저장 변수
    let tableNum = 0;

    $.ajax({
        url : "./controller/getBoard.php",
        dataType: "json",
        // 갱신된 데이터를 받아올 수 있도록 캐싱 false
        cache: false,
        error: function () {
            console.log('connection error..');
        },

        success: function(response) {
            if (response['error']) {
                alert('DB 연결에 문제가 생겼습니다...');
            } else {
                console.log(response);
                tableNum = response['board_count'];

                // reFreshBoard하위의 html엘리먼트 초기화
                $('.reFreshBoard').html("");
                // html 태그를 저장할 변수 선언
                var tag = "";

                // each 콜백 함수를 사용하여 배열에 값이 없을 때 까지 반복
                $.each(response['result_data'], function (key, val) {
                        // 게시판 글 클릭시 boardView.php에게 get 방식으로 게시판 글 번호 전달
                        tag += "<tr>";
                        // 배열의 값을 추출하여 <td>태그 내부에 적용
                        tag += "<td>" + tableNum + "</td>";
                        tag += "<td>" + val.title + "</td>";
                        tag += "<td>" + val.nickname + "</td>";
                        tag += "<td class='writeDate'>" + val.date + "</td>";
                        tag += "<td class='viewCount'>" + val.viewcount + "</td>";
                        tag += "<td class='type'>" + val.type + "</td>";
                        tag += "</tr>"
                    // 글 번호 줄임
                    --tableNum;
                });
            }
            $('.reFreshBoard').html(tag);
        },

        complete: function(response) {

        }
    }); // end ajax
}



// 댓글 정보를 가져오는 함수
function getCommentResult() {
    // 글 번호 저장 변수
    let tableNum = 0;

    $.ajax({
        url : "./controller/getAllComment.php",
        dataType: "json",
        // 갱신된 데이터를 받아올 수 있도록 캐싱 false
        cache: false,
        error: function () {
            console.log('connection error..');
        },

        success: function(response) {
            if (response['error']) {
                alert('DB 연결에 문제가 생겼습니다...');
            } else {
                console.log(response);

                // reFreshComment하위의 html엘리먼트 초기화
                $('.reFreshComment').html("");
                // html 태그를 저장할 변수 선언
                var tag = "";

                // each 콜백 함수를 사용하여 배열에 값이 없을 때 까지 반복
                $.each(response['result_data'], function (key, val) {
                    // 게시판 글 클릭시 boardView.php에게 get 방식으로 게시판 글 번호 전달
                    tag += "<tr>";
                    // 배열의 값을 추출하여 <td>태그 내부에 적용
                    tag += "<td>" + val.b_code + "</td>";
                    tag += "<td>" + val.m_code + "</td>";
                    tag += "<td>" + val.comment + "</td>";
                    tag += "<td>" + val.date + "</td>";
                    tag += "<td>" + val.caution + "</td>";
                    tag += "</tr>"
                });
            }
            $('.reFreshComment').html(tag);
        },

        complete: function(response) {

        }
    }); // end ajax
}

// 상태 저장 변수
let idToggle = 0;

// 세션 id박스가 눌리면 호출되는 함수
function idClick() {

    let currentID = document.getElementsByClassName('current-id');

    if (idToggle === 0) {
        // 스타일을 적용하기 위해서 적용할 태그의 자식 노드들 까지 반복해서 적용해 주어야 정상 동작한다.
        for (let i = 0; i < currentID.length; i += 1) {
            currentID[i].style.opacity = '0.25';
        }
        idToggle = 1;
    } else {
        for (let j = 0; j < currentID.length; j += 1) {
            currentID[j].style.opacity = '1';
        }
        idToggle = 0;
    }

    // 위의 for문의 코드를 jQuery를 사용하면 다음과 같음
    // $('.current-id').css('opacity','0.25');
}

let helpToggle = 0;
// 관리 페이지 설명 박스가 눌리면 호출되는 함수
function expandHelpBox() {
    let expandHelpBox = document.getElementsByClassName('help');
    let hiddenHelpText = document.getElementsByClassName('hiddenHelpText');
    let pTag = document.getElementsByClassName('helpTitle');

    if (helpToggle === 0) {
        // 스타일을 적용하기 위해서 적용할 태그의 자식 노드들 까지 반복해서 적용해 주어야 정상 동작한다.
        for (let i = 0; i < expandHelpBox.length; i += 1) {
            expandHelpBox[i].style.width = '40%';
            expandHelpBox[i].style.height = '35%';
            expandHelpBox[i].style.background = '#343A40';
        }

        for (let i = 0; i < hiddenHelpText.length; i+= 1) {
            hiddenHelpText[i].style.display='block';
            hiddenHelpText[i].style.color='#f1f1f1';
        }

        for (let i = 0; i < pTag.length; i+= 1) {
            pTag[i].style.color='#f1f1f1';
        }

        helpToggle = 1;
    } else {
        for (let j = 0; j < expandHelpBox.length; j += 1) {
            expandHelpBox[j].style.width = '200px';
            expandHelpBox[j].style.height = '80px';
            expandHelpBox[j].style.background = '#ffffff';
        }

        for (let j = 0; j < hiddenHelpText.length; j+= 1) {
            hiddenHelpText[j].style.display='none';
            hiddenHelpText[j].style.color='#000000';
        }

        for (let i = 0; i < pTag.length; i+= 1) {
            pTag[i].style.color='#2a2a2a';
        }

        helpToggle = 0;
    }
}