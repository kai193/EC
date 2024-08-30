<?php

require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/CommentData.php';

session_start();
$id = $_GET['id'];
$diaryData = new DiaryData();
$diary = $diaryData->get($id);
if (is_null($diary)) {
    echo '日記が見つかりませんでした。';
    exit;
}
$commentData = new CommentData();
$comments = $commentData->getByDiaryId($id);
?>

<html>

<?php include __DIR__ . '/includes/head.php' ?>

<body>
    <div class="container mt-4">
        <h1><?php echo $diary->getTitle() ?></h1>
        <div class="mb-2">投稿日：<?php echo $diary->getCreatedAt() ?></div>
        <div class="mb-2">投稿者：<?php echo $diary->getAuthor()->getName() ?></div>
        <div class="mb-4">
            <?php echo nl2br($diary->getBody()) ?>
        </div>
        <?php foreach ($comments as $comment) : ?>
            <div class="comment-container mb-3">
                <div class="mb-2">投稿者：<?php echo $comment->getAuthor()->getName() ?></div>
                <div class="mb-2">コメント：<?php echo $comment->getComment() ?></div>
            </div>
        <?php endforeach ?>
        <div class="mb-3">
            <a href="./post-comment.php?id=<?php echo $id ?>" class="btn btn-primary">コメントする</a>
        </div>
        <a href="./index.php">一覧へ</a>
</body>

<?php include __DIR__ . '/includes/foot.php' ?>

</html>
