<div class="container">
    <!-- 입력된 결과를 putMemberModify.php로 보내 db에 업데이트-->
    <form id="memberForm" action="../controller/putMemberModify.php" method="post" name="memberModify" >
        <div class="col-12 col-md-12 col-xl-12">
            <div class="reFresh">
                <!-- 비동기적으로 태그 생성-->
            </div>
            <div class="form-group submit">
                <button type="button" id="next" class="col-md-5 btn btn-dark login" onclick="registCheckInput()">가입</button>
                <button type="button" class="col-md-5 btn btn-light cancel" onclick="cancel()">취소</button>
            </div>
        </div>
    </form>
</div>
