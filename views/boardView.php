<h1>게시판 글보기 페이지 입니다.</h1>

<div class="container-fluid container">
    <!-- ajax 통신 -->
    <div class="reFresh">
        <!-- 비동기적으로 태그 생성-->
    </div>
    <form action="" method="post" name="boardCommentSubmitForm">
        <!-- 세션에 userId있다면 댓글 달기 버튼 생성 (비로그인 사용자는 글쓰기 X)-->
        <?php if ($_SESSION["userId"]) {?>
            <div class="form-group writeButton">
                <button type="button" class="col-sm-2 col-md-2 btn btn-dark float-right commentWrite" onclick="showCommentForm()">댓글 달기</button>
                <!-- 댓글 달기 버튼이 눌리면 display:block -->
                <div class="commentForm" style="display: none">
                    <h4>댓글 작성</h4>
                    <input type="textarea" name="commentTyping" class="form-control inputText" onkeydown="enter()" placeholder="내용을 입력해 주세요" value="">
                    <input type="hidden" name="sessionPost" value="<?=$_SESSION['userCode']?> "/>
                    <input type="button" class="btn btn-dark" onclick="commentFormSubmit()" value="다음">
                </div>
            </div>
            <!-- 로그인 시 게시판 댓글 달기 가능 출력-->
        <?php } else {?>
            <div class="loginPlease">로그인 시 댓글 달기가 가능 합니다.</div>
        <?php } ?>
    </form>
    <div id="commentContainer">
        <h2>댓글</h2>
        <!-- ajax 통신 -->
        <div class="reFreshComment">
            <!-- 비동기적으로 태그 생성-->
        </div>
    </div>
</div>