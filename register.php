<?php
require_once __DIR__ . '/classes/User.php';
require_once __DIR__ . '/classes/UserData.php';

session_start();

if (isset($_POST['submit-button'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $user->setName($name);
    $user->setEmail($email);
    $user->setPassword($password);

    $userData = new UserData();
    $userData->save($user);
    $_SESSION['userId'] = $user->getId();
    header('Location: ./index.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include __DIR__ . '/includes/head.php' ?>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="display-4">会員登録</h1>
        <form action="./register.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">名前</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary" name="submit-button">登録</button>
            </div>
        </form>
        <div class="mb-3">
            <a href="./login.php">ログインはこちら</a>
        </div>
    </div>
</body>
<?php include __DIR__ . '/includes/foot.php' ?>
</html>
