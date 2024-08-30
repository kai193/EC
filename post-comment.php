<?php
require_once __DIR__ . '/classes/Diary.php';
require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/CommentData.php';
require_once __DIR__ . '/classes/Comment.php';

session_start();

if (!isset($_SESSION['userId']) && !isset($_COOKIE['userId'])) {
    header('Location: ./login.php');
    die();
}

if (!isset($_GET['id'])) {
    header('location: ./index.php');
    die();
}

$id = $_GET['id'];
$diaryData = new DiaryData();
$diary = $diaryData->get($id);

if (isset($_POST['submit-button'])) {
    $commentInput = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');

    if (empty($commentInput)) {
        $error = "Please enter a comment.";
    } else {
        $comment = new Comment();
        $comment->setComment($commentInput);
        $comment->setDiary($diary);

        $userId = $_SESSION['userId'] ?? $_COOKIE['userId'];
        $userData = new UserData();
        $author = $userData->get($userId);
        $comment->setAuthor($author);

        $commentData = new CommentData();
        $commentData->save($comment);

        header("Location: ./diary.php?id={$id}");
        die();
    }
}
?>
<html>
<?php include __DIR__ . '/includes/head.php' ?>
<body>
    <h1>コメントページ</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form action="./post-comment.php?id=<?php echo $id ?>" method="post">
        <div class="mb-3">
            <label for="comment" class="form-label">コメント</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" name="submit-button" class="btn btn-primary">投稿</button>
        </div>
    </form>
</body>
<?php include __DIR__ . '/includes/foot.php' ?>
</html>
