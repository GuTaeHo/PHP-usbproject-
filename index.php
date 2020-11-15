<?php
    include "app.php";
?>

<!doctype html>
<html lang="en">
<head>
    <?php
    include "head.php";

    // url에 get방식의 값이 있다면
    if (isset($_GET["target"])) {
        $target = $_GET["target"];
    } else {
        $target = "index";
    }
    ?>

    <!-- 네비게이션 바의 css 적용-->
    <link rel="stylesheet" href="navigation.css">
    <!-- 현재 target의 값(페이지)에 맞는 css 적용-->
    <link rel="stylesheet" href="./css/<?= $target ?>.css">
    <!-- 공통 적용 css -->
    <link rel="stylesheet" href="everyPage.css">
</head>
<body>
    <?php
    // get방식의 target에 설정된 값이 없다면
    if (empty($_GET['target'])){
        // 기본 페이지로 이동
        $target = "index";
    } else {
        $target = $_GET['target'];
    }

    // 네비게이션 바 적용
    include "navigation.php";

    // 현재 target의 값(페이지)에 맞는 content 적용
    include "./views/".$target.".php";
    ?>
</body>
<script>
    <?php
    if (empty($_GET['target'])){
        $target = "index";
    } else {
        $target = $_GET['target'];
    }
    // 현재 target의 값(페이지)에 맞는 js 적용
    include "./javascript/".$target.".js";
    // 네비게이션 js 적용
    include "./navigation.js";
    ?>
</script>
</html>