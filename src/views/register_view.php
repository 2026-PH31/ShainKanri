<?php
$shainMei ??= '';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <?php if ($error !== ''): ?>
        <p style="color: red;"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
    <?php endif; ?>
    <form action="register.php" method="post">
        <p><label>氏名: <input type="text" name="shain_mei" value="<?= htmlspecialchars($shainMei, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" required></label></p>
        <p><label>メールアドレス: <input type="email" name="mail_address" value="<?= htmlspecialchars($mailAddress, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>" required></label></p>
        <p><label>パスワード: <input type="password" name="password" required></label></p>
        <p><button type="submit">登録</button></p>
    </form>
    <p><a href="login.php">ログインへ戻る</a></p>
</body>
</html>