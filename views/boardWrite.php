<h1>게시판 글쓰기 페이지</h1>

<div class="container">
    <!-- db로 입력된 값 INSERT -->
    <form action="../controller/putBoardWrite.php" method="post" name="boardWriteForm">
        <!-- 작성자 닉네임 -->
        <div class="form-group">
            <label for="exampleInputEmail1">작성자 닉네임</label>
            <!-- 사용자가 수정할 수 없도록 readonly로 input태그 설정 -->
            <input type="text" name="author" class="form-control" id="id" value='<?= $_SESSION["userNickname"]?>' readonly/>
        </div>
        <!-- 게시판 제목 -->
        <div class="form-group">
            <label for="exampleInputEmail1">제목</label>
            <input type="text" name="author" class="form-control" placeholder="제목을 입력해 주세요" id="id" >
        </div>
        <!-- 비밀글, 댓글 허용 -->
        <div class="form-group row">
            <label for="hiddenCheckBox" >비밀글</label>
            <input type="checkbox" id="hiddenCheckBox" name="hidden" class="form-control col-xl-6" value=''>
            <label for="commentAllowCheckBox">댓글 허용</label>
            <input type="checkbox" id="commentAllowCheckBox" name="comment" class="form-control col-xl-6" value='' checked>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"></label>
            <div class="form-group">
                <button type="button" id="next" class="col-md-5 btn btn-dark" onclick="registCheckInput()">게시</button>
                <button type="button" class="col-md-5 btn btn-light" onclick="cancel()">뒤로</button>
            </div>
        </div>
    </form>
</div>