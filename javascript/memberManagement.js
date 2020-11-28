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
                // console.log(response);
                tableNum = response['member_count'];

                // reFreshMember하위의 html엘리먼트 초기화
                $('.reFreshMember').html("");
                // html 태그를 저장할 변수 선언
                var tag = "";

                // 직위를 담는 변수 선언
                let position = "";

                // each 콜백 함수를 사용하여 배열에 값이 없을 때 까지 반복
                $.each(response['result_data'], function (key, val) {
                    switch (val.permission) {
                        case 1 :
                            position = "사용자"
                            break;
                        case 2 :
                            position = "사용자"
                            break;
                        case 3 :
                            position = "매니저"
                            break;
                        case 4 :
                            position = "관리자"
                            break;
                    }

                    // 관리자가 삭제하지 않았다면 출력
                    if (val.type !== -2) {
                        tag += "<tr>";
                        tag += "<td><button class='boardPermissionButton' type='button' data-toggle='modal' data-target='#modal_member_permission' data-m_code='"+ val.m_code + "'>" + position + "</button></td>";
                        tag += "<td>" + val.id + "</td>";
                        tag += "<td>" + val.nickname + "</td>";
                        tag += "<td>" + val.name + "</td>";
                        tag += "<td>" + val.email + "</td>";
                        tag += "<td>" + val.date + "</td>";
                        tag += "<td>" + val.type + "</td>";
                        tag += "<td><input type='button' value='삭제' onclick=\"deleteMember('" + val.id + "')\"/></td>";
                        tag += "</tr>"
                    }
                });
            }
            $('.reFreshMember').html(tag);
        },

        complete: function(response) {

        }
    }); // end ajax
}

// 모달이 띄워졌을때 호출되는 함수
$('#modal_member_permission').on('show.bs.modal', function (event) {
    var data = $(event.relatedTarget);

    var memberCode = data.data('m_code');

    $('#m_code').val(memberCode);
    // putMemberPermission(memberCode);
})

// 권한 주기 버튼을 클릭하였을 때 호출되는 함수
$('.permissionButton').click(function () {
    var memberCode = $('#m_code').val();
    var permission = $(this).val();
    if (confirm("정말 변경하시겠습니까?")) {
        $.ajax({
            url: "./controller/patchMemberPermission.php",
            data: {"memberCode": memberCode, "permission" : permission},
            type: "POST",
            dataType: "json",
            // 갱신된 데이터를 받아올 수 있도록 캐싱 false
            cache: false,
            error: function () {
                console.log('connection error..');
            },

            success: function (response) {
                console.log(response);
                if (response['error']) {
                    alert('DB 연결에 문제가 생겼습니다...');
                } else {
                    location.reload();
                }
            },
        }); // end ajax
    }
});

// 게시글을 가져오는 함수
function getBoardResult() {

    $.ajax({
        url: "./controller/getBoard.php",
        dataType: "json",
        // 갱신된 데이터를 받아올 수 있도록 캐싱 false
        cache: false,
        error: function () {
            console.log('connection error..');
        },

        success: function (response) {
            if (response['error']) {
                alert('DB 연결에 문제가 생겼습니다...');
            } else {
                // console.log(response);

                // reFreshBoard하위의 html엘리먼트 초기화
                $('.reFreshBoard').html("");
                // html 태그를 저장할 변수 선언
                var tag = "";
                let hiddenType = "";

                // each 콜백 함수를 사용하여 배열에 값이 없을 때 까지 반복
                $.each(response['result_data'], function (key, val) {
                    // 컬럼의 값이 -2(삭제됨)가 아닌 레코드만 출력
                    if (val.type !== -2) {
                        switch (val.type) {
                            case 0 :
                                hiddenType = "공개글";
                                break;

                            case 1 :
                                hiddenType = "비밀글";
                                break;
                        }
                        tag += "<tr>";
                        // 배열의 값을 추출하여 <td>태그 내부에 적용
                        tag += "<td>" + val.title + "</td>";
                        tag += "<td>" + val.nickname + "</td>";
                        tag += "<td class='writeDate'>" + val.date + "</td>";
                        tag += "<td class='viewCount'>" + val.viewcount + "</td>";
                        tag += "<td class='type'>" + hiddenType + "</td>";
                        tag += "<td><input type='button' value='삭제' onclick=\"deleteBoard('" + val.b_code + "')\"/></td>";
                        tag += "</tr>"
                    }
                });
            }
            $('.reFreshBoard').html(tag);
        },

        complete: function (response) {

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
                // console.log(response);

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
                    tag += "<td><input type='button' value='삭제' onclick=\"deleteComment('" + val.c_code + "')\"/></td>";
                    tag += "</tr>"
                });
            }
            $('.reFreshComment').html(tag);
        },
    }); // end ajax
}

// 회원 삭제 함수
function deleteMember(member) {

    if (confirm("정말 삭제하시겠습니까?")){
        $.ajax({
            url : "./controller/deleteMember.php",
            type : "POST",
            data: {"member" : member},
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
                    // alert(response['memberCode'][0]['m_code']);
                    // console.log(response['memberCode'][0]['m_code']);
                    console.log(response);
                }
            },
            complete: function() {
                // 게시글 새로고침
                getMemberResult();
            }
        }); // end ajax
    }
}

// 게시글 삭제 함수
function deleteBoard(board) {

    if (confirm("정말 삭제하시겠습니까?")){
        $.ajax({
            url : "./controller/deleteBoard.php",
            type : "POST",
            data: {"board" : board},
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
                    // alert(response['memberCode'][0]['m_code']);
                    // console.log(response['memberCode'][0]['m_code']);
                    console.log(response);
                }
            },
            complete: function() {
                // 게시글 새로고침
                getBoardResult();
            }
        }); // end ajax
    }
}

// 게시글 삭제 함수
function deleteComment(comment) {

    if (confirm("정말 삭제하시겠습니까?")){
        $.ajax({
            url : "./controller/deleteComment.php",
            type : "POST",
            data: {"comment" : comment},
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
                    // alert(response['memberCode'][0]['m_code']);
                    // console.log(response['memberCode'][0]['m_code']);
                    console.log(response);
                }
            },
            complete: function() {
                // 게시글 새로고침
                getCommentResult();
            }
        }); // end ajax
    }
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