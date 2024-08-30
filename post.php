<?php
require_once __DIR__ . '/classes/Diary.php';
require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';

session_start();

if (!isset($_SESSION['userId']) && !isset($_COOKIE['userId'])) {
    header('Location: ./login.php');
    die();
}

if (isset($_POST['submit-button'])) {
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $createdAt = htmlspecialchars($_POST['created-at'], ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8');

    // Check if required fields are not empty
    if (empty($title) || empty($createdAt) || empty($body)) {
        $error = "Please fill in all fields.";
    } else {
        $diary = new Diary();
        $diary->setTitle($title);
        $diary->setBody($body);
        $diary->setCreatedAt($createdAt);

        $userId = $_SESSION['userId'] ?? $_COOKIE['userId'];
        $userData = new UserData();
        $user = $userData->get($userId);
        $diary->setAuthor($user);

        $diaryData = new DiaryData();
        $diaryData->save($diary);

        header('Location: ./index.php');
        die();
    }
}
?>
<html>
<?php include __DIR__ . '/includes/head.php' ?>
<body>
    <h1>投稿ページ</h1>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>
    <form action="./post.php" method="post">
        <div class="mb-3">
            <label for="title" class="form-label">タイトル</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="created-at" class="form-label">日付</label>
            <input type="text" name="created-at" id="created-at" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">本文</label>
            <textarea name="body" id="body" class="form-control" rows="8" required></textarea>
        </div>
        <div class="mb-3">
            <button type="submit" name="submit-button" class="btn btn-primary">投稿</button>
        </div>
    </form>
</body>
<?php include __DIR__ . '/includes/foot.php' ?>
</html>
