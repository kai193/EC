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

$title = $diary->getTitle();
$body = $diary->getBody();


$diaryData = new DiaryData();
$diaryData->delete($diary);



?>
<html>

<body>
    <p>削除しました</p>
    <a href="./index.php">一覧</a>
</body>

</html>
