<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン</title>
</head>
<body>
    <h1>社員ログイン</h1>
    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <p><label>メールアドレス: <input type="email" name="mail_address" value="<?= htmlspecialchars($mailAddress, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" required></label></p>
        <p><label>パスワード: <input type="password" name="password" required></label></p>
        <p><button type="submit">ログイン</button></p>
    </form>
    <p><a href="register.php">ユーザー登録</a></p>
</body>
</html>