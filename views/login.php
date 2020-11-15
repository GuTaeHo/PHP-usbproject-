<!-- 로그인 성공시 게시판으로 이동 -->
<form name="loginForm" action="../model/getLogin.php" method="post">
    <div id="top-contents">
        <div class="form-group">
            <label for="exampleInputEmail1">아이디</label>
            <input type="text" name="id" class="form-control" id="id" aria-describedby="emailHelp" placeholder="아이디 입력" onKeyDown="if(event.keyCode == 13) pressEnter()">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">비밀번호</label>
            <input type="password" name="passwd" class="form-control" id="passwd" placeholder="비밀번호 입력" onKeyDown="if(event.keyCode == 13) pressEnter()">
        </div>
        <br>
        <div class="form-group">
            <button type="button" class="col-md-5 btn btn-dark login" onclick="loginCheckInput()">로그인</button>
            <button type="button" class="col-md-5 btn btn-light cancel" onclick="cancel()">취소</button>
        </div>
    </div>
</form>