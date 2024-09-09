<?php
require_once __DIR__ . '/classes/DiaryData.php';

$diaryData = new DiaryData();
$diaries = $diaryData->getAll();
?>
<html>
    <?php include __DIR__ . '/includes/head.php' ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <body class="bg-light">
        <div class="container mt-5">
            <h1 class="text-primary">日記一覧aaaaaaaaaa</h1>
            <div class="mb-3">
                <a href="./my-page.php" class="btn btn-primary">マイページへ</a>
            </div>
            <div class="mb-3">
                <a href="./post.php" class="btn btn-success">新規作成aaaaa</a>
            </div>
            <ul class="list-group">
                <?php foreach ($diaries as $diary): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span><?php echo $diary->getCreatedAt() ?></span>
                        <a href="./diary.php?id=<?php echo $diary->getId() ?>" class="text-decoration-none">
                            <?php echo $diary->getTitle() ?>
                        </a>
                        <span class="badge bg-secondary"><?php echo $diary->getAuthor()->getName() ?></span>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </body>
    <?php include __DIR__ . '/includes/foot.php' ?>
</html>
