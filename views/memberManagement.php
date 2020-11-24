<div class="container">
    <!-- 사용자 id 표시 O-->
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
            <div>주요 기능</div>
            <div> - 회원의 사용자 권한 변경 및 삭제 기능</div>
            <div> - 게시글 삭제 기능</div>
            <div> - 댓글 경고 및 삭제 기능</div>
        </div>
    </div>

    <div class="memberContainer">
        <h3>회원 수정</h3>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>권한</th>
                <th>아이디</th>
                <th>비밀번호</th>
                <th>닉네임</th>
                <th>이름</th>
                <th>이메일</th>
                <th>가입일</th>
            </tr>
            </thead>
            <tbody class="reFreshMember">
            <!-- 비동기 회원 정보 생성 -->
            </tbody>
        </table>
    </div>
    <div class="boardContainer">
        <h3>게시판 수정</h3>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th class="writeDate">작성일</th>
                <th class="viewCount">조회수</th>
                <th class="type">공개여부</th>
            </tr>
            </thead>
            <tbody class="reFreshBoard">
            <!-- 비동기 게시글 생성-->
            </tbody>
        </table>
    </div>
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
            </tr>
            </thead>
            <tbody class="reFreshComment">
            <!-- 비동기 댓글 정보 생성 -->
            </tbody>
        </table>
    </div>
</div>