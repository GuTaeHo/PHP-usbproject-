<div class="container">
<form id="boardForm" name="boardForm" method="post" action="../index.php?target=boardWrite">
    <div class="col-12 col-md-12 col-xl-12">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>번호</th>
            <th>제목</th>
            <th>작성자</th>
            <th class="writeDate">작성일</th>
            <th class="viewCount">조회수</th>
        </tr>
        </thead>
        <tbody id="tbody">
            <!-- 동적(비동기)으로 테이블 로우 생성 -->
        </tbody>
    </table>
        
    <!-- 세션에 userId있다면 글쓰기 버튼 생성 (비로그인 사용자는 글쓰기 X)-->
    <?php if ($_SESSION["userId"]) {?>
    <div class="form-group writeButton">
        <button type="submit" class="col-sm-2 col-md-2 btn btn-dark float-right">글쓰기</button>
    </div>
    <!-- 로그인 시 게시판 글쓰기 가능 출력-->
    <?php } else {?>
        <div class="loginPlease">로그인 시 글 쓰기가 가능 합니다.</div>
    <?php } ?>
    </div>
</form>
</div>
