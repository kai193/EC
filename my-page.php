<?php
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/DiaryData.php';

session_start();

if (!isset($_SESSION['userId']) && !isset($_COOKIE['userId'])) {
    header('Location: ./login.php');
    die();
}

$id = $_SESSION['userId'] ?? $_COOKIE['userId'];

$userData = new UserData();
$user = $userData->get($id);

$name = htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($user->getEmail(), ENT_QUOTES, 'UTF-8');
$password = htmlspecialchars($user->getPassword(), ENT_QUOTES, 'UTF-8');

$diaryData = new DiaryData();
$diaries = $diaryData->getAll();
$myDiaries = [];

foreach ($diaries as $diary) {
    if (intval($diary->getAuthor()->getId()) === intval($id)) {
        $myDiaries[] = $diary;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/includes/head.php' ?>
<body>
    <div class="container mt-5">
        <h1 class="display-4">マイページ</h1>
        <div class="mb-3">
            <a href="./logout.php" class="btn btn-danger">ログアウト</a>
        </div>
        <div class="mb-3">
            <a href="./index.php" class="btn btn-primary">一覧へ</a>
        </div>
        <div class="mb-3">
            ID：<?php echo $id ?>
        </div>
        <div class="mb-3">
            お名前：<?php echo $name ?>
        </div>
        <div class="mb-3">
            メールアドレス：<?php echo $email ?>
        </div>
        <div class="mb-3">
            パスワード：<?php echo $password ?>
        </div>
        <ul class="list-group">
            <?php foreach ($myDiaries as $diary): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><?php echo $diary->getCreatedAt() ?></span>
                    <a href="./diary.php?id=<?php echo $diary->getId() ?>" class="text-decoration-none">
                        <?php echo $diary->getTitle() ?>
                    </a>
                    <div class="btn-group">
                        <a href="./edit.php?id=<?php echo $diary->getId() ?>" class="btn btn-warning">編集</a>
                        <a href="./delete.php?id=<?php echo $diary->getId() ?>" class="btn btn-danger">削除</a>
                    </div>
                </li>
            <?php endforeach ?>
        </ul>
        <a href="./index.php">一覧へ</a>
    </div>
</body>
<?php include __DIR__ . '/includes/foot.php' ?>
</html>
