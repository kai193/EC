<?php
require_once __DIR__ . '/classes/Diary.php';
require_once __DIR__ . '/classes/DiaryData.php';
require_once __DIR__ . '/classes/UserData.php';

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

$title = htmlspecialchars($diary->getTitle(), ENT_QUOTES, 'UTF-8');
$body = htmlspecialchars($diary->getBody(), ENT_QUOTES, 'UTF-8');

if (isset($_POST['submit-button'])) {
    $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
    $createdAt = htmlspecialchars($_POST['created-at'], ENT_QUOTES, 'UTF-8');
    $body = htmlspecialchars($_POST['body'], ENT_QUOTES, 'UTF-8');

    $diary->setTitle($title);
    $diary->setBody($body);
    $diary->setCreatedAt($createdAt);

    $diaryData = new DiaryData();
    $diaryData->update($diary);

    header('Location: ./index.php');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/includes/head.php' ?>
<body>
    <div class="container mt-5">
        <h1 class="display-4">編集ページ</h1>
        <form action="./edit.php?id=<?php echo $id ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">タイトル</label>
                <input type="text" name="title" id="title" class="form-control" value="<?php echo $title ?>" required>
            </div>
            <div class="mb-3">
                <label for="created-at" class="form-label">日付</label>
                <input type="text" name="created-at" id="created-at" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="body" class="form-label">本文</label>
                <textarea name="body" id="body" class="form-control" rows="8" required><?php echo $body ?></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" name="submit-button" class="btn btn-primary">投稿</button>
            </div>
        </form>
    </div>
</body>
<?php include __DIR__ . '/includes/foot.php' ?>
</html>
