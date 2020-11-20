<!-- reCaptcha v3.0-->
<script src='https://www.google.com/recaptcha/api.js?render=6Lfe0eUZAAAAAIOuKccP5Osv1UjoUmWEULFXpLTC'></script>

<form id="regist_form" method="post" action="../controller/putRegist.php" name="registForm">
    <div id="top-contents">
        <div class="form-group">
            <label for="exampleInputPassword1">아이디</label>
            <input type="text" name="id" class="form-control" id="identity" placeholder="아이디 입력 (7 ~ 20자)" onkeydown="enter()">
            <!-- readonly = input태그의 입력 비활성화 -->
            <input type="text" class="form-control" id="idCheck" readonly/>
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputPassword1">비밀번호</label>
            <input type="password" name="passwd" class="form-control" placeholder="비밀번호 입력" onkeydown="enter()">
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputPassword2">비밀번호 확인</label>
            <input type="password" name="passwd_check" class="form-control" placeholder="비밀번호 확인" onkeydown="enter()">
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputPassword2">성명</label>
            <input type="text" name="name" class="form-control" placeholder="성명 입력" onkeydown="enter()">
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputPassword2">닉네임</label>
            <input type="text" name="nickname" class="form-control" placeholder="닉네임 (10자 이하)" onkeydown="enter()">
        </div>
        <br>
        <div class="form-group">
            <label for="exampleInputEmail1">이메일</label>
            <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="이메일 입력" onkeydown="enter()">
            <small id="text" class="form-text text-muted">본사는 누구에게도 가입 정보를 공유하지 않습니다.</small>
        </div>
        <div>
            <!-- reCaptcha 추가-->
            <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
        </div>
        <div class="form-group">
            <button type="button" id="next" class="col-md-5 btn btn-dark" onclick="registCheckInput()">가입</button>
            <button type="button" class="col-md-5 btn btn-light" onclick="cancel()">취소</button>
        </div>
    </div>
</form>