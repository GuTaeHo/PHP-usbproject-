<div class="container">
    <!-- db로 입력된 값 INSERT -->
    <form name="boardWriteForm" id="boardWriteForm">
        <!-- 작성자 닉네임 -->
        <div class="form-group">
            <label>작성자</label>
            <!-- 사용자가 수정할 수 없도록 readonly로 input태그 설정 -->
            <input type="text" name="author" id="author" class="form-control" value='<?= $_SESSION["userNickname"]?>' readonly/>
        </div>
        <!-- 게시판 제목 -->
        <div class="form-group">
            <label>제목</label>
            <input type="text" name="title" id="inputTitle" class="form-control" placeholder="제목을 입력해 주세요">
        </div>
        <!-- 비밀글, 댓글 허용 -->
        <div class="form-group row">
            <div class="hiddenContainer">
                <label for="hiddenCheckBox" class="textLabel">비밀글</label>
                <input type="checkbox" id="hiddenCheckBox" name="type" value='hidden'>
                <label for="hiddenCheckBox"></label>
            </div>
            <div class="allowContainer">
                <label for="commentAllowCheckBox" class="textLabel">댓글 허용</label>
                <input type="checkbox" id="commentAllowCheckBox" name="comments" value='allow' checked>
                <label for="commentAllowCheckBox"></label>
            </div>
        </div>
        <!-- 게시글 내용 -->
        <div class="textAreaContainer">
            <textarea name="boardContent" cols="57" rows="10" id="boardContent" placeholder="내용을 입력해 주세요"></textarea>
            <div class="counter"></div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1"></label>
            <div class="form-group">
                <button type="button" id="next" class="col-md-5 btn btn-dark float-right" onclick="boardCheckInput()">게&nbsp&nbsp시</button>
                <button type="button" class="col-md-5 btn btn-light" onclick="cancel()">뒤&nbsp&nbsp로</button>
            </div>
        </div>
    </form>
</div>