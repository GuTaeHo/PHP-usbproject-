
<div class="container">
    <!-- 사이드 박스 -->
    <div class="current-id" onclick="idClick()">
        <p>안녕하세요</p>
        <div><?=$_SESSION['userId']?>님</div>
        <h5>현재 권한 </h5>
        <div><?=$_SESSION["userPermission"]?></div>
    </div>
    <div class="help" onclick="expandHelpBox()">
        <p class="helpTitle" style="display:block">관리 페이지?</p>
        <div class="hiddenHelpText" style="display:none;">
            <div>manage 페이지는 게시판, 회원, 댓글을 DataBase에 접속하지 않고 <br>빠르게 정보를 수정하기 위한 페이지 입니다.</div>
            <br>
            <div class="helpFunctionTitle">주요 기능</div>
            <div>회원의 사용자 권한 변경 및 삭제 기능</div>
            <div>-2 (삭제), 0 (보임), 1 (비밀글)</div>
            <br>
            <div>게시글 삭제 기능</div>
            <div>댓글 삭제 기능</div>
        </div>
    </div>

    <!-- 회원 수정 -->
    <form name="memberForm" id="memberForm">
        <div class="memberContainer">
            <h3>회원 수정</h3>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>권한</th>
                    <th>아이디</th>
                    <th>닉네임</th>
                    <th>이름</th>
                    <th>이메일</th>
                    <th>가입일</th>
                    <th>상태</th>
                    <th>삭제</th>
                </tr>
                </thead>
                <tbody class="reFreshMember">
                <!-- 비동기 회원 정보 생성 -->
                </tbody>
            </table>
        </div>
    </form>

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="modal_member_permission" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">회원 권한 변경</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form id="memberUpdateForm">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">권한 할당</h4>
                                    <div class="form-group row">
                                        <label class="col-sm-4 col-form-label">관리자 권한</label>
                                        <div class="col-sm-8 permissionContainer">
                                            <!-- memberManagement.js에서 모달이 띄워졌을때 value 할당-->
                                            <input type="hidden" id="m_code" name="m_code" readonly/>
                                            <input type="button" name="overseer" class="btn btn-gradient-primary permissionButton" value="4" />
                                        </div>
                                        <label class="col-sm-4 col-form-label">매니저 권한</label>
                                        <div class="col-sm-8 permissionContainer">
                                            <input type="button" name="manager" class="btn btn-gradient-primary permissionButton" value="3" />
                                        </div>
                                        <label class="col-sm-4 col-form-label">우수사용자 권한</label>
                                        <div class="col-sm-8 permissionContainer">
                                            <input type="button" name="superb" class="btn btn-gradient-primary permissionButton" value="2" />
                                        </div>
                                        <label class="col-sm-4 col-form-label">일반사용자 권한</label>
                                        <div class="col-sm-8 permissionContainer">
                                            <input type="button" name="commonUser" class="btn btn-gradient-primary permissionButton" value="1" />
                                        </div>
                                    </div>
                                </div>
                                <!-- card-body end -->
                            </div>
                            <!-- card end-->
                        </form>
                    </div>
                    <!-- container-fluid end -->
                </div>
                <!-- modal-body end -->
            </div>
            <!-- modal-content end -->
        </div>
        <!-- modal-dialog end -->
    </div>
    <!-- modal end -->

    <!-- 게시판 수정 -->
    <form name="boardForm" id="boardForm">
        <div class="boardContainer">
            <h3>게시판 수정</h3>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>제목</th>
                    <th>작성자</th>
                    <th class="writeDate">작성일</th>
                    <th class="viewCount">조회수</th>
                    <th class="type">공개여부</th>
                    <th>삭제</th>
                </tr>
                </thead>
                <tbody class="reFreshBoard">
                <!-- 비동기 게시글 생성-->
                </tbody>
            </table>
        </div>
    </form>

    <!-- 댓글 수정 -->
    <form name="commentForm" id="commentForm">
        <div class="commentContainer">
            <h3>댓글 수정</h3>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>글 번호</th>
                    <th>회원 번호</th>
                    <th>댓글 내용</th>
                    <th>작성일</th>
                    <th>신고 횟수</th>
                    <th>삭제</th>
                </tr>
                </thead>
                <tbody class="reFreshComment">
                <!-- 비동기 댓글 정보 생성 -->
                </tbody>
            </table>
        </div>
    </form>
</div>
