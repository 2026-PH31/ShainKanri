<?php
$shainMei ??= '';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ホーム</title>
</head>
<body>
    <p><?= htmlspecialchars($shainMei, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?> さん、ようこそ</p>
    <p><a href="logout.php">ログアウト</a></p>
</body>
</html>