<?php

require_once __DIR__ . '/classes/UserData.php';
require_once __DIR__ . '/classes/User.php';

session_start();

$errorMessage = null;
$email = '';
if (isset($_POST['submit-button'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $userData = new UserData();
    $users = $userData->getAll();

    foreach ($users as $user) {
        if ($email === $user->getEmail() && password_verify($password, $user->getPassword())) {
            $_SESSION['userId'] = $user->getId();

            if (isset($_POST['remember-me'])) {
                setcookie('userId', $user->getId(), time() + 60 * 60, '/');
            }

            header('Location: ./index.php');
            die();
        }
    }

    $errorMessage = 'メアドとパスワードが一致するユーザーが見つかりませんでした';
}

?>
<?php include __DIR__ . '/includes/head.php' ?>
    <div class="container mt-5">
        <h1 class="display-4">ログイン</h1>
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $errorMessage; ?>
            </div>
        <?php endif; ?>
        <form action="./login.php" method="post">
            <div class="mb-3">
                <label for="email" class="form-label">メールアドレス</label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo $email ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">パスワード</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember-me" id="remember-me" class="form-check-input">
                <label for="remember-me" class="form-check-label">ログイン状態を保持する</label>
            </div>
            <div class="mb-3">
                <input type="submit" value="ログイン" name="submit-button" class="btn btn-primary">
            </div>
        </form>
        <div>
            <a href="./register.php">登録はこちら</a>
        </div>
    </div>
</body>
<?php include __DIR__ . '/includes/foot.php' ?>
</html>
