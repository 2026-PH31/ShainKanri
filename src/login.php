<?php

session_start();

if (isset($_SESSION['shain_id'])) {
    header('Location: home.php');
    exit;
}

require __DIR__ . '/db.php';
require_once __DIR__ . '/../model/ShainModel.php';

$error = '';
$mailAddress = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mailAddress = trim($_POST['mail_address'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($mailAddress === '' || $password === '') {
        $error = 'メールアドレスとパスワードを入力してください';
    } else {
        $shain = (new ShainModel($pdo))->findByMailAddress($mailAddress);

        if ($shain && password_verify($password, $shain['password'])) {
            session_regenerate_id(true);
            $_SESSION['shain_id'] = $shain['shain_id'];
            $_SESSION['shain_mei'] = $shain['shain_mei'];
            header('Location: home.php');
            exit;
        }

        $error = 'メールアドレスまたはパスワードが違います';
    }
}

require __DIR__ . '/views/login_view.php';